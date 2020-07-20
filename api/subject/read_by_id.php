<?php
// Required headers
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 
header("Access-Control-Allow-Methods: GET"); 

include_once '../config/database.php'; 
include_once '../objects/subject.php'; 

$database = new Database(); 
$db = $database->getConnection(); 

$subject = new Subject($db); 

// Check if ID is present

?> 