<?php
class GameModel {
	private $userWin;
	private $computerMove;
	public function __construct()
	{

	}
	public function getComputersMove(){
		return $this->computerMove;
	}
	public function didUserWin(){
		return $this->userWin;
	}
	public function playGame($userMove)
	{
		//test
		//1 sax, 2 sten, 3 påse
		$this->computerMove = mt_rand(1, 3);
		if($userMove == choice::$scissors)
		{
			if($this->computerMove == choice::$paper)
			{
				$this->userWin = true;
			}
			else
				$this->userWin = false;
		}
		else if($userMove == choice::$paper)
		{
			if($this->computerMove == choice::$rock)
			{
				$this->userWin = true;
			}
			else
				$this->userWin = false;
		}
		else if($userMove == choice::$rock)
		{
			if($this->computerMove == choice::$scissors)
			{
				$this->userWin = true;
			}
			else
				$this->userWin = false;
		}
	}
}