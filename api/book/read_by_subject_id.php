<?php 
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 
header("Access-Control-Allow-Methods: GET"); 

include_once '../config/database.php'; 
include_once '../objects/book.php'; 

$database = new Database(); 
$db = $database->getConnection(); 

$book = new Book($db); 

$book->subject_id = isset($_GET["subject_id"]) ? $_GET["subject_id"] : die(); 

// Search for books with subject id 
$stmt = $book->readBySubjectId(); 
$num = $stmt->rowCount(); 

// Check if there was a response 
if($num > 0)
{
    $books_arr=array(); 
    $books_arr["records"]=array(); 
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row); 
        $book_item = array(
            "id"=>$id,
            "subject_id"=>$subject_id,
            "book_desc"=>$book_desc,
            "grade_level"=>$grade_level
        ); 
        
        array_push($books_arr["records"], $book_item);
    }

    // Set response code - 200 OK 
    http_response_code(200); 

    // Return data to the user 
    echo json_encode($books_arr); 
}
else 
{
    // Set response code - 404 Not Found
    http_response_code(404); 

    // Tell the user 
    echo json_encode(array("message"=>"No books with specified subject ID found")); 
}
?> 