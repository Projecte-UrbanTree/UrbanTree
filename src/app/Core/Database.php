<?php

namespace App\Core;

use PDO;

class Database
{
	public static function connect()
	{
		// Read the database connection parameters from environment variables
		$db_host = getenv('DB_HOST');
		$db_name = getenv('DB_NAME');
		$db_user = getenv('DB_USER');

		// Read the password file path from an environment variable
		$password_file_path = getenv('PASSWORD_FILE_PATH');

		// Read the password from the file
		$db_pass = trim(file_get_contents($password_file_path));

		// Create a new PDO instance
		$db_handle = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

		// Set the PDO error mode to exception
		$db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $db_handle;
	}

	public static function disconnect($db_handle)
	{
		return $db_handle = null;
	}

	public static function query($db_handle, $query)
	{
		$result = $db_handle->query($query);

		Database::disconnect($db_handle);

		return $result;
	}
}
