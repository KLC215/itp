<?php


namespace App\Helpers;


class CalculateExpCoins
{
	private $standards           = [
		500, 250, 50, 25, 10    // Original exp & coins / standard = extra exp & coins
	];
	private $challengesStandards = [
		500, 250, 25, 10, 5,
	];
	private $exp                 = 0;
	private $coins               = 0;
	
	/**
	 * CalculateExpCoins constructor.
	 *
	 * @param int $exp
	 * @param int $coins
	 * @param int $stars
	 * @param     $stage_type_id
	 */
	public function __construct($exp, $coins, $stars, $stage_type_id)
	{
		if ($stars <= 0) {
			$this->exp = 0;
			$this->coins = 0;
		} else {
			switch ($stage_type_id) {
				case 1:
					$this->exp = $exp / $this->standards[$stars - 1];
					$this->coins = $coins / $this->standards[$stars - 1];
					break;
				case 2:
					$this->exp = $exp / $this->challengesStandards[$stars - 1];
					$this->coins = $coins / $this->challengesStandards[$stars - 1];
			}
		}
	}
	
	/**
	 * @return float|int
	 */
	public function getExp()
	{
		return $this->exp;
	}
	
	/**
	 * @return float|int
	 */
	public function getCoins()
	{
		return $this->coins;
	}
	
}