<?php 
// Required headers 
header("Access-Control-Allow-Origin: *");  
header("Content-Type: application/json; charset=UTF-8"); 
header("Access-Control-Allow-Methods: POST"); 
header("Access-Control-Max-Age: 3600"); 
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php'; 
include_once '../objects/book.php'; 

$database = new Database(); 
$db = $database->getConnection(); 

// Prepare book object 
$book = new Book($db); 

// Get subject id 
$data = json_decode(file_get_contents("php://input")); 

// Set subject id to be deleted 
$book->id = $data->id; 

// Delete the subject
if($book->delete())
{
    // Set response code - 200 OK 
    http_response_code(200); 

    // Tell the user 
    echo json_encode(array("message" => "Book was deleted")); 
}
// If unable to delete the subject 
else
{
    // Set response code - 503 service unavailable 
    http_response_code(503); 

    // Tell the user
    echo json_encode(array("message"=> "Unable to delete book.")); 
}
?>