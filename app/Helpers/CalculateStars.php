<?php

namespace App\Helpers;
/**
 * Class CalculateStars
 */
class CalculateStars
{
	private $tutorialStandards = [
		50000, 40000, 30000, 20000, 15000 //milliseconds
	];
	
	private $levelsStandards = [
		100000, 90000, 80000, 70000, 60000, //milliseconds
	];
	
	private $challengesStandards = [
		5, 10, 15, 20, 25,                    // correct ratio
	];
	
	/**
	 * User's finished time
	 *
	 * @var
	 */
	private $seconds;
	/**
	 * User's error ratio of the question
	 *
	 * @var
	 */
	private $errorRatio;
	/**
	 * Default stars number
	 *
	 * @var int
	 */
	private $stars = 5;
	/**
	 *    Default stage type
	 *
	 * @var int
	 */
	private $stage_type = 0;
	/**
	 * Count number to get stars
	 *
	 * @var int
	 */
	private $count = 0;
	
	/**
	 * CalculateStars constructor.
	 *
	 * @param     $seconds
	 * @param     $errorRatio
	 * @param int $stage_type
	 */
	public function __construct($seconds, $errorRatio, $stage_type)
	{
		$this->seconds = $seconds;
		$this->errorRatio = $errorRatio;
		$this->stage_type = $stage_type;
		
		$this->startCalculate();
	}
	
	
	/**
	 *    Calculate how many stars that user can get.
	 */
	public function startCalculate()
	{
		$this->calculateStars();
		
		if ($this->errorRatio > 0) {
			$this->hasErrorRatio();
		}
	}
	
	/**
	 * @return int
	 */
	public function getStars()
	{
		return $this->stars;
	}
	
	/**
	 *    Calculate with milliseconds
	 */
	private function calculateStars()
	{
		switch ($this->stage_type) {
			case 0: // Tutorial
				for ($i = 0; $i < sizeof($this->tutorialStandards); $i++) {
					if ($this->seconds <= $this->tutorialStandards[$i]) {
						$this->count += 1;
					}
				}
				break;
			case 1: // Level 1 and Level 2
				for ($i = 0; $i < sizeof($this->levelsStandards); $i++) {
					if ($this->seconds <= $this->levelsStandards[$i]) {
						$this->count += 1;
					}
				}
				break;
			case 2: // Challenges
				for ($i = 0; $i < sizeof($this->challengesStandards); $i++) {
					if ($this->seconds <= $this->challengesStandards[$i]) {
						$this->count += 1;
					}
				}
				break;
		}
		
		$this->stars = $this->count;
	}
	
	/**
	 *    Calculate with error ratio
	 */
	private function hasErrorRatio()
	{
		switch ($this->errorRatio) {
			case 1:
				$this->stars -= 0.5;
				break;
			case 2:
			case 3:
			case 4:
				$this->stars -= 1;
				break;
		}
	}
}