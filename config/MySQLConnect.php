<?php

try {
	$mysql = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
} catch (Exception $e) {
	echo "Error: " . $e->getMessage();
	exit;
}