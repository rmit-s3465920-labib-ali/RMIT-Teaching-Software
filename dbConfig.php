<?php
/**
 * Created by PhpStorm.
 * User: Labib Ali Syed
 * Date: 16/1/18
 * Time: 11:53 AM
 */


// Database connection.

//DB details
$dbHost = 'localhost:8889';
$dbUsername = 'root';
$dbPassword = 'root';
$dbName = 'RMIT-Teaching-Software';

//Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Unable to connect database: " . $db->connect_error);
}