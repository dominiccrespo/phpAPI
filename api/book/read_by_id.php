<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8"); 
header("Access-Control-Allow-Methods: GET"); 

include_once "../config/database.php"; 
include_once "../objects/book.php"; 

$database = new Database(); 
$db = $database->getConnection(); 

$book = new Book($db);
$book->id = isset($_GET["id"]) ? $_GET["id"] : die(); 

$book->readById(); 
if($book->book_desc != null)
{
    $book_arr = array(
        "id"=>$book->id, 
        "subject_id"=>$book->subject_id,
        "book_desc"=>$book->book_desc,
        "grade_level"=>$book->grade_level
    );

    // Set response code - 200 Ok 
    http_response_code(200); 

    // Return book to the user
    echo json_encode($book_arr); 
}
else
{
    // Set response code - 404 Not Found
    http_response_code(404); 

    // Tell the user 
    echo json_encode(array("message"=>"The book was not found")); 
}
?>