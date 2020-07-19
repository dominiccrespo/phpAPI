<?php 
//This is used for validating correct data is there and parsing it into a product object
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8"); 
header("Access-Control-Allow-Methos: POST"); 
header("Access-Control-Max-Age: 3600"); 
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); 

include_once '../config/database.php'; 
include_once '../objects/subject'; 

$database = new Database(); 
$db = $database->getConnection(); 

$product = new Product($db); 

$data = json_decode(file_get_contents("php://input")); 

// Make sure data is not empty
if(!empty($data->subject_desc))
{
    // Set property values 
    $product->subject_desc = $data->subject_desc; 

    // Create the subject
    if($product->create())
    {
        // Set response code 
        http_response_code(201); 

        // Tell the user
        echo json_encode(array("message"=>"Subject was created"));  
    }
    else
    {
        // Set response code 
        http_response_code(503); 

        // Tell the user 
        echo json_encode(array("message"=>"Unable to create subject")); 
    }
}
// Inform user data is imcomplete 
else
{
    // Set response code 
    http_response_code(400); 

    // Tell the user 
    echo json_encode(array("message"=>"Unable to create subject data is incomplete.")); 
}