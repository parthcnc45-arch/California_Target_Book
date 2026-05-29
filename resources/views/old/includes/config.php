<?php

ob_start();
session_start();

//set timezone

date_default_timezone_set('America/Los_Angeles');

//database credentials

define('DBHOST', '198.74.49.22');
define('DBUSER', 'nufec');
define('DBPASS', 'Mrw0mbat8');
define('DBNAME', 'ctb');

//application address

define('DIR', '');
define('SITEEMAIL', 'webmaster@10.0.1.3');

try {

    //create PDO connection

    //        $db = new PDO("mysql:host=" . DBHOST . ";port=3306;dbname=" . DBNAME, DBUSER, DBPASS);
    $db = new PDO("mysql:host=198.74.49.22;port=3306;dbname=ctb_dev", 'corey_dev', 'ctb_dev');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    //show error
    echo "<p class='bg-danger'>" . $e->getMessage() . '</p>';
    exit;
}

require_once('classes/user.php');

User::setDatabase($db);
