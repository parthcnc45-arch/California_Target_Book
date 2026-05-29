<?php

$conn = new mysqli(
    config('database.connections.ctb_data.host'),
    config('database.connections.ctb_data.username'),
    config('database.connections.ctb_data.password'),
    config('database.connections.ctb_data.database')
);
$conn->set_charset('utf8');
$GLOBALS['ctb_conn'] = $conn;

$ctb_pdo = DB::connection('ctb_data')->getPdo();
$ctb_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

$GLOBALS['ctb_pdo'] = $ctb_pdo;
