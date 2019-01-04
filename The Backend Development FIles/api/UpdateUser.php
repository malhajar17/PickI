
<?php
 
//creating response array
$response = array();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// var_dump($_SERVER);
if($_SERVER['REQUEST_METHOD']=='POST'){

        //                      /* Update Array ready */

        // // Fetch content and determine boundary
        // $raw_data = file_get_contents('php://input');
        // $boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));

        // // Fetch each part
        // $parts = array_slice(explode($boundary, $raw_data), 1);
        // $data = array();

        // foreach ($parts as $part) {
        //     // If this is the last part, break
        //     if ($part == "--\r\n") break; 

        //     // Separate content from headers
        //     $part = ltrim($part, "\r\n");
        //     list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);

        //     // Parse the headers list
        //     $raw_headers = explode("\r\n", $raw_headers);
        //     $headers = array();
        //     foreach ($raw_headers as $header) {
        //         list($name, $value) = explode(':', $header);
        //         $headers[strtolower($name)] = ltrim($value, ' '); 
        //     } 

        //     // Parse the Content-Disposition to get the field name, etc.
        //     if (isset($headers['content-disposition'])) {
        //         $filename = null;
        //         preg_match(
        //             '/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/', 
        //             $headers['content-disposition'], 
        //             $matches
        //         );
        //         list(, $type, $name) = $matches;
        //         isset($matches[4]) and $filename = $matches[4]; 

        //         // handle your fields here
        //         switch ($name) {
        //             // this is a file upload
        //             case 'userfile':
        //                  file_put_contents($filename, $body);
        //                  break;

        //             // default for all other files is to populate $data
        //             default: 
        //                  $data[$name] = substr($body, 0, strlen($body) - 2);
        //                  break;
        //         } 
        //     }

        // } 


        //                    /* Finish preparing Update Array  */

    //getting values
    $DidLogin        = 1;
    $followingNumber = $_POST['FollowingNumber'];
    $followerNumber  = $_POST['FollowersNumber'];
    $numofposts      = $_POST['NumberOfPosts'];
    $Celebrity       = $_POST['Celebrity'];
    $username        = $_POST['Username'];
    // var_dump($_POST);

 
    //including the db operation file
    require_once '../includes/DbOperation.php';
 
    $db = new DbOperation();
 
    //inserting values 
    if($db->updateUser($DidLogin,$followingNumber,$followerNumber,$numofposts,$Celebrity,$username)){
        $response['error']=false;
        $response['message']='User Updated successfully';
    }else{
 
        $response['error']=true;
        $response['message']='Could not Update User';
    }
 
}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}
echo json_encode($response);
?>