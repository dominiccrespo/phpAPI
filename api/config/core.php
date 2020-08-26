<?php 
// Show reporting error
ini_set('display_errors', 1); 
error_reporting(E_ALL); 

// home page url 
$home_url = "http://localhost:8080/phprestapi/api/"; 

// Page is given in URL parameter, default is one 
$page = isset($_GET['page']) ? $_GET['page'] : 1; 

// Set # of records
$records_per_page = 5; 

// Calculate for the query LIMIT clause 
$from_record_num = ($records_per_page * $page) - $records_per_page; 
?> 
