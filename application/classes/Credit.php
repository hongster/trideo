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
		$add = 0; // Number of credits purchased
		$original_amount = $amount;
		$rates = static::$rates;
		arsort($rates, SORT_NUMERIC);

		foreach ($rates as $price => $c)
		{
			while ($amount >= $price)
			{
				$amount -= $price;
				$add += $c;
			}
		}

		// Values smaller than RM 16.00
		if ($amount > 0)
		{
			$add += (int) floor($amount / 16 * 8);
		}

		// Update balance
		$credit = $user->credit;
		$credit->balance += $add;
		$credit->save();

		// Record transaction
		$transaction = ORM::factory('Transaction');
		$transaction->user_id = $user->id;
		$transaction->description = strtr(
			'Purchase :add credits with RM:amount',
			array(':add' => $add, ':amount' => $original_amount));
		$transaction->adjustment = $add;
		$transaction->balance = $credit->balance;
		$transaction->save();

		return $add;
	}

} // Credit