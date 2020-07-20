<?php 
// required headers
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 
header("Access-Control-Allow-Methods: GET"); 

include_once '../config/database.php'; 
include_once '../objects/subject.php'; 

$database = new Database(); 
$db = $database->getConnection(); 

$subject = new Subject($db);

$stmt = $subject->read(); 
$num = $stmt->rowCount(); 

if($num > 0)
{
    // Subjects array
    $subjects_arr=array(); 
    $subjects_arr["records"]=array(); 

    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row); 
        $subject_item = array(
            "id" => $id, 
            "subject_desc" => $subject_desc
        ); 
        array_push($subjects_arr["records"], $subject_item); 
    }

    // Set response code 
    http_response_code(200); 

    echo json_encode($subjects_arr); 
}
else
{
    // Set response code
    http_response_code(404); 
    // Tell user 
    echo json_encode(array("message"=>"No subjects found")); 
}
?>