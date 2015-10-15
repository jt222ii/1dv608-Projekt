<?php
class GameModel {
	private $userWin = false;
	private $computerMove;
	public function __construct()
	{

	}
	public function getComputersMove(){
		return $this->computerMove;
	}
	public function didUserWinTheRound(){
		return $this->userWin;
	}
	public function playGame($userMove)
	{
		//test
		//1 sax, 2 sten, 3 påse
		$this->computerMove = mt_rand(1, 3);
		if($userMove == choice::$scissors && $this->computerMove == choice::$paper)
		{
			$this->userWin = true;
		}
		else if($userMove == choice::$paper && $this->computerMove == choice::$rock)
		{
			$this->userWin = true;	
		}
		else if($userMove == choice::$rock && $this->computerMove == choice::$scissors)
		{
			$this->userWin = true;
		}
	}
}