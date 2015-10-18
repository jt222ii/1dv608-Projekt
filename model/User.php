<?php
require_once('model/userDAL.php');
class User{

	private $username;
	private $password;

	public function __construct($username, $password, $dohash = true)
	{
		$this->username = $username;
		//When getting an existing member we do not want to hash the password again.
		//if the construct gets a false it wont hash the password. If it gets true or nothing it will hash the password.
		$this->password = $dohash ? $this->hash($password) : $password;
	}
	public function getUsername()
	{
		return $this->username;
	}
	public function getPassword()
	{
		return $this->password;
	}
	public function hash($password)
	{
		return sha1(Settings::$salt.$password.$this->username);
	}
	public function comparePassword($password)
	{
		if($this->password == $this->hash($password))
		{
			return true;
		}
		return false;
	}
}