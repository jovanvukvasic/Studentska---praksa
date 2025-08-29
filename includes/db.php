<?php
$host = 'localhost';     
$dbname = 'studentska_praksa'; 
$username = 'root';       
$password = '';           
$port = 3306;

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Konekcija neuspešna: " . $e->getMessage());
}
?>
