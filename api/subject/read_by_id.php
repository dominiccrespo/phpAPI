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

$subject->id = isset($_GET['id']) ? $_GET['id'] : die(); 

$subject->readById(); 

if($subject->subject_desc!=null)
{
    $subject_arr = array(
        "id" => $subject->id, 
        "description" => $subject->subject_desc 
    ); 

    // Set response code 
    http_response_code(200); 

    // Json format 
    echo json_encode($subject_arr); 
}
else
{
    // Set response code
    http_response_code(404); 

    // Tell the user 
    echo json_encode(array("message" => "Subject does not exist.")); 
}
?> 