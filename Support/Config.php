<?php
date_default_timezone_set("America/Fortaleza");

$config = array();

// DATABASE
define("CONF_DB_NAME", "financial_control");
define("CONF_DB_HOST", "localhost");
define("CONF_DB_USER", "root");
define("CONF_DB_PASS", "");	
$config['options'] = [
	PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
	PDO::ATTR_CASE => PDO::CASE_NATURAL
];

// PROJECT URLS
define("CONF_BASE_URL", "http://localhost/financial-control/");

// DATES
define("CONF_DATE_BR", "d/m/Y H:i:s");
define("CONF_DATE_APP", "Y-m-d H:i:s");	

// PASSWORD
define("CONF_PASSWD_MIN_LEN", 8);
define("CONF_PASSWD_MAX_LEN", 40);

//SESSION
define("CONF_SESSION_NAME", "control");

global $db;
try{
	$db = new PDO(
		"mysql:dbname=".CONF_DB_NAME.";charset=utf8;host=".CONF_DB_HOST, 
		CONF_DB_USER, 
		CONF_DB_PASS,
		[
			$config['options']
		]
	);
}catch(PDOException $e){
	echo "Erro: ".$e->getMessage();
	exit;
}

// MESSAGE
define("CONF_MESSAGE_CLASS", "alert");
define("CONF_MESSAGE_INFO", "alert-info");
define("CONF_MESSAGE_SUCCESS", "alert-success");
define("CONF_MESSAGE_WARNING", "alert-warning");
define("CONF_MESSAGE_ERROR", "alert-danger");	