<?php 
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 

include_once '../config/core.php'; 
include_once '../shared/utilities.php'; 
include_once '../config/database.php'; 
include_once '../objects/subject.php'; 

// Utilities 
$utilities = new Utilities(); 

// Instantiate database 
$database = new Database(); 
$db = $database->getConnection(); 

// Initialize object 
$subject = new Subject($db); 

// Query subjects 
$stmt = $subject->readPaging($from_record_num, $records_per_page); 
$num = $stmt->rowCount(); 
if($num > 0)
{
    // Subjects array 
    $subjects_arr=array(); 
    $subjects_arr["records"]=array(); 
    $subjects_arr["paging"]=array(); 
    // Fetch table contents 
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row); 

        $subject_item=array(
            "id" => $id, 
            "subject_desc" => $subject_desc
        ); 
        array_push($subjects_arr["records"], $subject_item); 
    }

    // Include paging
    $total_rows=$subject->count(); 
    $page_url="{$home_url}subject/read_paging.php?"; 
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url); 
    $subjects_arr["paging"]=$paging; 

    // Set response code - 200 OK 
    http_response_code(200); 

    // Return subjects 
    echo json_encode($subjects_arr); 
}
else
{
    // Set response code - 404 Not Found
    http_response_code(404); 

    // Tell the user
    echo json_encode(array(
        "message" => "No Subjects found. "
    )); 
}
?>