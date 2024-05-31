<?php
$servername = "localhost"; 
$username = "root";
$password = "";
$database = "managemate_db"; 
try{
$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
echo "Connected successfully";}
catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
