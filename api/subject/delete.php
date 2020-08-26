<?php 
// Required headers 
header("Access-Control-Allow-Origin: *");  
header("Content-Type: application/json; charset=UTF-8"); 
header("Access-Control-Allow-Methods: POST"); 
header("Access-Control-Max-Age: 3600"); 
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php'; 
include_once '../objects/subject.php'; 

$database = new Database(); 
$db = $database->getConnection(); 

// Prepare subject object 
$subject = new Subject($db); 

// Get subject id 
$data = json_decode(file_get_contents("php://input")); 

// Set subject id to be deleted 
$subject->id = $data->id; 

// Delete the subject
if($subject->delete())
{
    // Set response code - 200 OK 
    http_response_code(200); 

    // Tell the user 
    echo json_encode(array("message" => "Subject was deleted")); 
}
// If unable to delete the subject 
else
{
    // Set response code - 503 service unavailable 
    http_response_code(503); 

    // Tell the user
    echo json_encode(array("message"=> "Unable to delete subject.")); 
}
?>