<?php
//creating response array
$response = array();
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// var_dump($_SERVER);
// var_dump($_GET);
//     //getting values
//     $Email     = $_POST['Email'];
//     $username  = $_POST['Username'];
//     $Password  = $_POST['Password']; 

 
//     //including the db operation file
    require_once '../includes/DbOperation.php';
 
    $db = new DbOperation();
 	$users = $db->getUsers();
//     //inserting values 
    if($users){
    	echo json_encode($users);
    }
//         $response['error']=false;
//         $response['message']='User added successfully';
//     }else{
 
//         $response['error']=true;
//         $response['message']='Could not add team';
//     }
 
// echo json_encode($response);
?>