<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Manage user credits.
 * @package Trideo
 */
class Credit {

	/** No charge if usage < 15min */
	const FREE_THRESHOLD = 900; // 15 minutes

	/** Capped at 8 hours per day, no charge for subsequent usage in this day */
	const MAX_HOURS = 28800; // 8 hours

	/** @var array Rates (RM => Credit) */
	public static $rates = array(
		16 => 8,
		72 => 40,
		240 => 160,
		960 => 960,
	);

	/**
	 * Top-up credit.
	 *
	 * @param Model_User $user
	 * @param int $amount Payment amount, in Ringgit.
	 * @return int Number of credits added.
	 */
	public static function purchase_credits(Model_User $user, $amount)
	{
		$topup = static::cost2credits($amount);

		if ($topup < 1) // WTF
		{
			return 0;
		}

		// Update balance
		$credit = $user->credit;
		$credit->balance += $topup;
		$credit->save();

		// Record transaction
		$transaction = ORM::factory('Transaction');
		$transaction->user_id = $user->id;
		$transaction->description = 'Purchase credit.';
		$transaction->price = $amount;
		$transaction->credit = $topup;
		$transaction->balance = $credit->balance;
		$transaction->save();

		return $topup;
	}

	/**
	 * Convert Riggit to credits.
	 * 
	 * @param int $amount in Ringgit.
	 * @return int
	 */
	public static function cost2credits($amount)
	{
		$credits = 0;
		$rates = static::$rates;
		arsort($rates, SORT_NUMERIC);

		foreach ($rates as $price => $c)
		{
			while ($amount >= $price)
			{
				$amount -= $price;
				$credits += $c;
			}
		}

		// Values smaller than RM 16.00
		if ($amount > 0)
		{
			// XXX Hardcoded values here
			$credits += (int) floor($amount / 16 * 8);
		}

		return $credits;
	}

	/**
	 * Charge credits based on access duration.
	 * 
	 * @param Model_Access $access With checkout time recorded.
	 * @return int Number of credits deducted.
	 */
	public static function charge_access(Model_Access $access)
	{
		// Today's 0000h. Might be yesteday's 0000h if access started yesterday 
		// and cross midnight.
		$today = strtotime(date('Y-m-d', $access->checkin));

		$accumulated = ORM::factory('Access')->accumulated_duration(
			$today,
			$access->checkin,
			$access->user_id);

		$credit = ORM::factory('Credit', array('user_id' => $access->user_id));

		// No charge if usage below 15 min
		if ($accumulated < static::FREE_THRESHOLD)
		{
			ORM::factory('Transaction')
				->values(array(
					'user_id' => $access->user_id,
					'price' => 0.00,
					'credit' => 0,
					'balance' => $credit->balance,
					'description' => strtr(
						'Less than 15 min. Not charging access from :start to :end',
						array(':start' => date('Y-m-d H:i:s', $access->checkin), ':end' => date('Y-m-d H:i:s', $access->checkout))),
				))
				->save();

			return 0;
		}

		// Capped at 8 hours per day
		if ($accumulated > static::MAX_HOURS)
		{
			ORM::factory('Transaction')
				->values(array(
					'user_id' => $access->user_id,
					'price' => 0.00,
					'credit' => 0,
					'balance' => $credit->balance,
					'description' => strtr(
						'Exceeded 8 hours in a day. Not charging access from :start to :end',
						array(':start' => date('Y-m-d H:i:s', $access->checkin), ':end' => date('Y-m-d H:i:s', $access->checkout))),
				))
				->save();

			return 0;
		}

		$duration = $access->checkout - $access->checkin;
		
		if ($accumulated + $duration <= static::MAX_HOURS)
		{
			$charge = (int) ceil($duration / 60);	
		}
		else
		{
			// Cross the MAX_HOURS boundry, only charge within boundary
			$charge = (int) ceil((static::MAX_HOURS - $accumulated) / 60);	
		}

		$credit->balance -= $charge;
		$credit->save();

		ORM::factory('Transaction')
			->values(array(
				'user_id' => $access->user_id,
				'price' => 0.00,
				'credit' => -$charge,
				'balance' => $credit->balance,
				'description' => strtr(
					'Charged :charge credits for access from :start to :end',
					array(':charge' => $charge, ':start' => date('Y-m-d H:i:s', $access->checkin), ':end' => date('Y-m-d H:i:s', $access->checkout))),
			))
			->save();

		return $charge;
	}

} // Credit