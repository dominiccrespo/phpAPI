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

// get id of subject to be edited 
$data = json_decode(file_get_contents("php://input")); 

// set ID property of subject to be edited
$subject->id = $data->id; 

// set subject property values 
$subject->subject_desc = $data->subject_desc; 

// Update the subject 
if($subject->update())
{
    // Set the response code 
    http_response_code(200); 

    // Tell the user 
    echo json_encode(array("message" => "Subject was updated")); 
}

else
{
    // Set response code 
    http_response_code(503); 

    // Tell the user
    echo json_encode(array("message" => "Unable to update subject")); 
}
?> 