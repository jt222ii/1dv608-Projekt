<?php

class userDAL {

	private $conn;

	public function createConnection()
	{
		// Create connection
		$this->conn = mysqli_connect(Settings::$mysql_host, Settings::$mysql_user, Settings::$mysql_password, Settings::$mysql_database);
		// Check connection
		if ($this->conn->connect_error) {
		   die("Connection failed: " . $conn->connect_error);
		} 
		return $this->conn;
	}
	public function closeConnection()
	{
		mysqli_close($this->conn);
	}

	public function addUserToDatabase(User $user)
	{
		$username = $user->getUsername();
		$password = $user->getPassword();
		$connection = $this->createConnection();
		$mysql_database = Settings::$mysql_database;
		$sqlQuery = "INSERT INTO $mysql_database.`member` (`Username`, `Password`) VALUES ('$username', '$password')";  
		$result = $connection->query($sqlQuery);																	    
		$this->closeConnection();
		//if the query failed result will be false
		if (!$result)
		{
			return false;
		}
		return true;
	}
	//get a user from the database using a username
	public function getUserByUsername($username)
	{
		$connection = $this->createConnection();
		$sqlQuery = "SELECT Username, Password FROM member WHERE BINARY Username = '$username'";
		$result = $connection->query($sqlQuery);
		$data = $result->fetch_array(MYSQLI_ASSOC);
		$this->closeConnection();
		if($data == null || !isset($data))
		{
			return null;
		}
		$user = new User($data['Username'], $data['Password'],false);
		return $user;
	}

	//Checks if a user with a specific username already exists
	public function userNameAlreadyExists($username)
	{
		$connection = $this->createConnection();
		$sqlQuery = "SELECT Username, Password FROM member WHERE Username = '$username'";
		$result = $connection->query($sqlQuery);
		$this->closeConnection();
		if($result->num_rows == 0)
		{
			return false;
		}
		return true;
	}

	public function addResultToUser($didUserWin, $username)
	{
		$connection = $this->createConnection();
		if($didUserWin)
		{
			$sqlQuery = "UPDATE member SET Wins = Wins + 1  WHERE Username = '$username'";
		}
		else
		{
			$sqlQuery = "UPDATE member SET Losses = Losses + 1  WHERE Username = '$username'";
		}
		$result = $connection->query($sqlQuery);
		$this->closeConnection();
	}

	public function getUserStats($username)
	{
		$connection = $this->createConnection();
		$sqlQuery = "SELECT Wins, Losses FROM member WHERE BINARY Username = '$username'";
		$result = $connection->query($sqlQuery);
		$this->closeConnection();
		$userStats = $result->fetch_array(MYSQLI_ASSOC);
		return $userStats;
	}

}
