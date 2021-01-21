<?php


function db_connect() {
	require_once 'config.php';
	$config = new CConfig();

	return new mysqli(
			$config::$db_host,
			$config::$db_username,
			$config::$db_password,
			$config::$db_name
	);
}
