# 1dv608-Projekt
Installation instruction for my project. For my vision look here: https://github.com/jt222ii/1dv608-Projekt/wiki

1 - Download the repository

2 - Create a new database.

3 - Enter the following sql command to create the table:

CREATE TABLE IF NOT EXISTS `member` (
  `Username` varchar(40) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `Wins` int(11) NOT NULL DEFAULT '0',
  `Losses` int(11) NOT NULL DEFAULT '0',
  `ProfilePicURL` varchar(100) NOT NULL DEFAULT 'http://i.imgur.com/W77VpWC.png?1',
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

4 - Enter the hostname, databasename, username, password and salt in Settings.php. (Make sure that your user has full access to the database)

5 - Run the application on your webserver
