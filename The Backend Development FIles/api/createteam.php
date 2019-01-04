
<?php
 
//creating response array
$response = array();
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// var_dump($_SERVER);
if($_SERVER['REQUEST_METHOD']=='POST'){
 var_dump($_POST);
//     //getting values
    $Email     = $_POST['Email'];
    $username  = $_POST['Username'];
    $Password  = $_POST['Password']; 

 
    //including the db operation file
    require_once '../includes/DbOperation.php';
 
    $db = new DbOperation();
    function getWeekday($date) {
    return date('w', strtotime($date));
    }
 $Date= getWeekday(date('d-m-y',time()));
 // var_dump($Date);
 // exit;
    //inserting values 
    if($db->createUser("mog","alhaj",$Password,$username,$Email,$Date)){
        $response['error']=false;
        $response['message']='User added successfully';
    }else{
 
        $response['error']=true;
        $response['message']='Could not add team';
    }
 
}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}
echo json_encode($response);
?>