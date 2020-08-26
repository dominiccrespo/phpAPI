<?php 
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 

include_once '../config/core.php'; 
include_once '../config/database.php'; 
include_once '../objects/subject.php'; 

// Instantiate database and product object
$database = new Database(); 
$db = $database->getConnection(); 

// Initialize object
$subject = new Subject($db); 

// Get keywords 
$keywords=isset($_GET["s"]) ? $_GET["s"] : ""; 

// Query subjects 
$stmt = $subject->search($keywords); 
$num = $stmt->rowCount(); 

// Check if more than 0 records found 
if($num > 0)
{
    // subjects array
    $subjects_arr=array(); 
    $subjects_arr["records"]=array(); 

    // Retrieve table contents 
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        // extract row 
        // this will make $row['subject_desc'] to 
        // just $subject_desc only
        extract($row); 
        $subject_item=array(
            "id"=>$id, 
            "description"=>html_entity_decode($subject_desc)
        ); 

        array_push($subjects_arr["records"], $subject_item); 
    }

    // Set response code - 200 ok 
    http_response_code(200); 

    // show subject data 
    echo json_encode($subjects_arr); 
}

else
{
    // Set response code - 404 Not found
    http_response_code(404); 

    // Tell the user no subjects found
    echo json_encode(
        array("message" => "No products found.")
    ); 
}
?> 