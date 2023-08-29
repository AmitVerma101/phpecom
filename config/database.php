<?php
// config/database.php

$host = 'localhost';
$dbname = 'ecommerce';
$username = 'postgres';
$password = '1234';

try {
    $db = pg_connect("host=$host dbname=$dbname user=$username password=$password");
    
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}





