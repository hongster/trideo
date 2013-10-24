<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Manage user credits.
 * @package Trideo
 */
class Credit {

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
		$transaction->description = strtr(
			'Purchase :topup credits with RM :amount',
			array(':topup' => 'topup', ':amount' => 'amount'));
		$transaction->adjustment = $topup;
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

} // Credit