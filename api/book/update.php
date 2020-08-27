<?php 
// Required headers 
header("Access-Control-Allow-Origin: *");  
header("Content-Type: application/json; charset=UTF-8"); 
header("Access-Control-Allow-Methods: POST"); 
header("Access-Control-Max-Age: 3600"); 
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/book.php'; 
include_once '../config/core.php'; 

$database = new Database(); 
$db = $database->getConnection(); 

// Prepare book object
$book = new Book($db); 

// get id of book to be edited 
$data = json_decode(file_get_contents("php://input")); 

// set ID property of book to be edited
$book->id = $data->id; 

// set book property values 
$book->subject_id = !empty($data->subject_id) ? $data->subject_id : -1; 
$book->grade_level = !empty($data->grade_level) ? $data->grade_level : -1; 
$book->book_desc = !empty($data->book_desc) ? $data->book_desc : -1; 

// Update the book 
if($book->update())
{
    // Set the response code 
    http_response_code(200); 

    // Tell the user 
    echo json_encode(array("message" => "Book was updated")); 
}

else
{
    // Set response code 
    http_response_code(503); 

    // Tell the user
    echo json_encode(array("message" => "Unable to update book")); 
}
?> 
