<?php
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 
header("Access-Control-Allow-Methods: POST"); 
header("Access-Control-Max-Age: 3600"); 
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); 

include_once '../config/database.php'; 
include_once '../objects/book.php'; 
include_once '../objects/subject.php'; 

// Initialize database
$database = new Database(); 
$db = $database->getConnection(); 

// Initialize object 
$book = new Book($db); 

$data=json_decode(file_get_contents("php://input")); 

// Make sure data is not empty 
if(!empty($data->subject_id)&&!empty($data->book_desc))
{
    // Check if subject id exists 
    $subject = new Subject($db); 
    $subject->id = $data->subject_id; 
    $subject->readById();
    if($subject->subject_desc!=null)
    {
        // Set grade level default 0.00
        $grade_level = !empty($data->grade_level) ? $data->grade_level : 0.00; 
        // Set property values 
        $book->subject_id = $data->subject_id; 
        $book->book_desc = $data->book_desc; 
        $book->grade_level = $grade_level; 
        
        // Create the subject
        if($book->create())
        {
            // Set response code 
            http_response_code(201); 

            // Tell the user
            echo json_encode(array("message"=>"Book was created"));  
        }
        else
        {
            // Set response code 
            http_response_code(503); 

            // Tell the user 
            echo json_encode(array("message"=>"Unable to create book")); 
        }
    }
    // Subject id does not correspond to an actual subject 
    else 
    {
        // Set response code - 400 Bad Request 
        http_response_code(400); 

        // Tell the user 
        echo json_encode(array(
            "message" => "Subject ID is invalid" 
        )); 
    }
    
}
// Data is incomplete
else
{
   // Set response code 
   http_response_code(400); 

   // Tell the user 
   echo json_encode(array("message"=>"Unable to create book data is incomplete.")); 
}
?>