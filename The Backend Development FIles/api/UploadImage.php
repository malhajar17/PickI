<?php

// 	error_reporting(E_ALL);
// ini_set('display_errors', 0);

require '../includes/DbOperation.php';
require '/Users/mohamedalhajar/Downloads/Php-Google-API/vendor/autoload.php';
use Google\Cloud\Vision\VisionClient;
use phpFastCache\CacheManager;
$vision = new VisionClient();
$db = new DbOperation();

$target_dir = "/Users/mohamedalhajar/Downloads/mohamed";if(!file_exists($target_dir))
{
mkdir($target_dir, 0777, true);
}

// error_reporting(E_ERROR | E_PARSE);
// error_reporting(0);
ini_set('max_execution_time', 0);
putenv('GOOGLE_APPLICATION_CREDENTIALS=/Users/mohamedalhajar/Downloads/Intsagram helper-9ca46b702877.json');
$file_name = $_FILES["file"]["name"];
// var_dump(expression)
$target_dir = $target_dir . "/" . basename($_FILES["file"]["name"]);
move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir);
$image = $vision->image(
	    fopen('/Users/mohamedalhajar/Downloads/mohamed/'.$file_name, 'r'),
	    ['faces','imageProperties']
		);
$annotation     = $vision->annotate($image);

$W_T_Matrix = 
	array(
0.0172608244066926,
0.0169379334268515,
0.00597814235719424,
0.0151594390442909,
0.000782701648739928,
0.0126237126083977,
0.0155502695019289,
0.0110232733454036,
0.0105287088502678,
0.0201774006185129,
0.0181897633145611,
0.00989474925821418,
0.0161436978292821,
0.00152896121199217,
0.016573730271716,
0.0238606066753849,
0.0122134209364277,
0.0129127747462358,
0.00932571608257826,
0.0118318441296084,
0.000742944376108535,
0.00957756577440113,
0.0171724409116985,
0.00746613050927292,
0.00705798298523297,
0.0137556271802257,
0.0175478692183593,
0.00249922927876621,
0.0145309396354739,
0.0258976193362836
);








$thefaces = $annotation->faces();
		if(!isset($thefaces)){
			echo "noface";
		}
$ColorsArray    = $annotation->imageProperties()->info()["dominantColors"]["colors"];
$dominantColors = BiggesetColorSearch($ColorsArray);
$DominantRed    = $dominantColors["red"];
$DominantGreen  = $dominantColors["green"];
$DominantBlue   = $dominantColors["blue"];
		$arrayOfFaces = array(
		'FaceOneJoy'		 	 => NULL,
		'FaceOneExposed'		 => NULL,
		'FaceOneSorrow'		     =>	NULL,
		'FaceOneBlurred'		 => NULL,
		'FaceOneHeadwear'		 => NULL,
		'FaceOneSurprised'		 => NULL,
		'FaceOneAnger'			 => NULL,
		'FaceTwoJoy'		 	 => NULL,
		'FaceTwoExposed'		 => NULL,
		'FaceTwoBlurred'		 => NULL,
		'FaceTwoSorrow'		     =>	NULL,
		'FaceTwoHeadwear'		 => NULL,
		'FaceTwoAnger'			 => NULL,
		'FaceTwoSurprised'		 => NULL,
		'FaceThreeJoy'			 => NULL,
		'FaceThreeExposed'		 => NULL,
		'FaceThreeBlurred'		 => NULL,
		'FaceThreeHeadwear'		 => NULL,
		'FaceThreeAnger'		 => NULL,
		'FaceThreeSorrow'	     =>	NULL,
		'FaceThreeSurprised'	 => NULL
	);
		foreach ($annotation->faces() as $key => $face) {
			// var_dump($face->info());

	    if ($key == 0) {
	        $arrayOfFaces['FaceOneJoy'] 	  = CheckNumber( $face->info()["surpriseLikelihood"]);
	        $arrayOfFaces['FaceOneExposed']   = CheckNumber( $face->info()["underExposedLikelihood"]);
	        $arrayOfFaces['FaceOneSorrow']    = CheckNumber( $face->info()["sorrowLikelihood"]);
	        $arrayOfFaces['FaceOneBlurred']   = CheckNumber( $face->info()["blurredLikelihood"]);
	        $arrayOfFaces['FaceOneHeadwear']  = CheckNumber( $face->info()["headwearLikelihood"]);
	        $arrayOfFaces['FaceOneSurprised'] = CheckNumber( $face->info()["surpriseLikelihood"]);
	        $arrayOfFaces['FaceOneAnger']     = CheckNumber( $face->info()["angerLikelihood"]);
	    }
	    if ($key == 1) {
	        $arrayOfFaces['FaceTwoJoy'] 	  = CheckNumber( $face->info()["surpriseLikelihood"]);
	        $arrayOfFaces['FaceTwoExposed']   = CheckNumber( $face->info()["underExposedLikelihood"]);
	        $arrayOfFaces['FaceTwoSorrow']    = CheckNumber( $face->info()["sorrowLikelihood"]);
	        $arrayOfFaces['FaceTwoBlurred']   = CheckNumber( $face->info()["blurredLikelihood"]);
	        $arrayOfFaces['FaceTwoHeadwear']  = CheckNumber( $face->info()["headwearLikelihood"]);
	        $arrayOfFaces['FaceTwoSurprised'] = CheckNumber( $face->info()["surpriseLikelihood"]);
	        $arrayOfFaces['FaceTwoAnger']	  = CheckNumber( $face->info()["angerLikelihood"]);
	    }
	    if ($key == 2) {
	        $arrayOfFaces['FaceThreeJoy'] 	    = CheckNumber( $face->info()["surpriseLikelihood"]);
	        $arrayOfFaces['FaceThreeExposed']   = CheckNumber( $face->info()["underExposedLikelihood"]);
	        $arrayOfFaces['FaceThreeSorrow']    = CheckNumber( $face->info()["sorrowLikelihood"]);
	        $arrayOfFaces['FaceThreeBlurred']   = CheckNumber( $face->info()["blurredLikelihood"]);
	        $arrayOfFaces['FaceThreeHeadwear']  = CheckNumber( $face->info()["headwearLikelihood"]);
	        $arrayOfFaces['FaceThreeSurprised'] = CheckNumber( $face->info()["surpriseLikelihood"]);
	        $arrayOfFaces['FaceThreeAnger']	    = CheckNumber( $face->info()["angerLikelihood"]);
	    }
	    // var_dump($face->info());
	}
	$ArrayOfAccount = array(
		
		'Celebrity'         =>  0,
		
		'CreationTime'   		 =>  getWeekday(date('d-m-Y',time())),
		'Ad'				     =>  0,
		//Google Api related
		'FaceOneJoy'		 	 => $arrayOfFaces["FaceOneJoy"],
		'FaceOneExposed'		 => $arrayOfFaces['FaceOneExposed'],
		'FaceOneSorrow'		     => $arrayOfFaces['FaceOneSorrow'],
		'FaceOneBlurred'		 => $arrayOfFaces['FaceOneBlurred'],
		'FaceOneHeadwear'		 => $arrayOfFaces['FaceOneHeadwear'],
		'FaceOneSurprised'		 => $arrayOfFaces['FaceOneSurprised'],
		'FaceOneAnger'			 => $arrayOfFaces['FaceOneAnger'],
		'FaceTwoAnger'			 => $arrayOfFaces['FaceTwoAnger'],
		'FaceTwoJoy' 		     => $arrayOfFaces['FaceTwoJoy'],
		'FaceTwoSorrow'          => $arrayOfFaces['FaceTwoSorrow'],
		'FaceTwoExposed'		 => $arrayOfFaces['FaceTwoExposed'],
		'FaceTwoBlurred'		 => $arrayOfFaces['FaceTwoBlurred'],
		'FaceTwoHeadwear'		 => $arrayOfFaces['FaceTwoHeadwear'],
		'FaceTwoSurprised'		 => $arrayOfFaces['FaceTwoSurprised'],
		'FaceThreeJoy'			 => $arrayOfFaces['FaceThreeJoy'],
		'FaceThreeExposed'		 => $arrayOfFaces['FaceThreeExposed'],
		'FaceThreeBlurred'		 => $arrayOfFaces['FaceThreeBlurred'],
		'FaceThreeHeadwear'		 => $arrayOfFaces['FaceThreeHeadwear'],
		'FaceThreeAnger'		 => $arrayOfFaces['FaceThreeAnger'],
		'FaceThreeSorrow'        => $arrayOfFaces['FaceThreeSorrow'],
		'FaceThreeSurprised'	 => $arrayOfFaces['FaceThreeSurprised'],
		'DominantRed'			 => $DominantRed,
		'DominantGreen'			 => $DominantGreen,
		'DominantBlue'			 => $DominantBlue,
		'username'				 => $_POST["username"]

		 );
	
 $users = $db->getUsers();
 $username = $_POST["username"];
 $userMatrixNotEdited = array();
 foreach ($users as $key => $value) {
 	if ($value["Username"] == $username)
 		$userMatrixNotEdited = $value;
 }
 // var_dump($userMatrixNotEdited);

 $userMatrix = array();
 $keyk = 0;
 foreach ($userMatrixNotEdited as $key => $value) {
 	if ($key == "ID" || $key == "FirstName" || $key == "LastName" || $key == "Email" || $key == "Username" || $key == "Password" || $key == "DidLogin" ) {
 		continue; 	}
 		$userMatrix[$keyk] = $value;
 		$keyk ++;
 
 }

 $userTest = array(642,484,242,0,0,0,5,5,5,5,5,5,5,0,0,0,0,0,0,0,0,0,0,0,0,0,0,71,44,73 );
 $LikeNumber = 0;
 foreach ($W_T_Matrix as $key => $value) {
 	$LikeNumber = $LikeNumber + ($value * $userMatrix[$key]);
 }
$RoundedLikeNumber = round($LikeNumber);
 $range = 5;
 if ( 0  <= $RoundedLikeNumber && $RoundedLikeNumber < 15) {
 	 $range = 1;
 }
  if (15   <=$RoundedLikeNumber && $RoundedLikeNumber < 30 ) {
 	 $range = 2;
 }
  if ( 30  <= $RoundedLikeNumber&& $RoundedLikeNumber < 45) {
 	 $range = 3;
 }
 if ( 45  <= $RoundedLikeNumber&& $RoundedLikeNumber < 60) {
 	 $range = 4;
 }
  if (60  <= $RoundedLikeNumber && $RoundedLikeNumber < 90) {
 	 $range = 5;
 }
  if (90   <= $RoundedLikeNumber && $RoundedLikeNumber < 120) {
 	 $range = 6;
 }
  if (120   <= $RoundedLikeNumber && $RoundedLikeNumber < 180) {
 	 $range = 7;
 }
  if (180   <= $RoundedLikeNumber && $RoundedLikeNumber < 300) {
 	 $range = 8;
 }
  if (300   <= $RoundedLikeNumber && $RoundedLikeNumber < 420) {
 	 $range = 9;
 }
 if ( 420 <= $RoundedLikeNumber && $RoundedLikeNumber < 540) {
 	 $range = 10;
 }
  if (540   <= $RoundedLikeNumber && $RoundedLikeNumber < 660 ) {
 	 $range = 11;
 }
  if ( 660  <= $RoundedLikeNumber && $RoundedLikeNumber < 900) {
 	 $range = 12;
 }
  if (900 <= $RoundedLikeNumber && $RoundedLikeNumber < 1140) {
 	 $range = 13;
 }
  if (1140   <= $RoundedLikeNumber && $RoundedLikeNumber < 1620) {
 	 $range = 14;
 }
  if (1620   <= $RoundedLikeNumber && $RoundedLikeNumber < 2580) {
 	 $range = 15;
 }
  if (2580   <= $RoundedLikeNumber && $RoundedLikeNumber < 3540) {
 	 $range = 16;
 }
  if (3540 <=  $RoundedLikeNumber && $RoundedLikeNumber < 4500) {
 	 $range = 17;
 }
  if (4500   <= $RoundedLikeNumber && $RoundedLikeNumber < 6500) {
 	 $range = 18;
 }
 if ( 6500  <= $RoundedLikeNumber && $RoundedLikeNumber < 9500) {
 	 $range = 19;
 }
  if (9500   <= $RoundedLikeNumber&& $RoundedLikeNumber < 13500 ) {
 	 $range = 20;
 }
  if ( 13500  <= $RoundedLikeNumber && $RoundedLikeNumber < 18500) {
 	 $range = 21;
 }
  if (18500  <= $RoundedLikeNumber && $RoundedLikeNumber < 24500) {
 	 $range = 22;
 }
  if (24500   <= $RoundedLikeNumber && $RoundedLikeNumber < 31500) {
 	 $range = 23;
 }
  if (31500   <= $RoundedLikeNumber&& $RoundedLikeNumber  < 39500) {
 	 $range = 24;
 }
  if (39500   <= $RoundedLikeNumber && $RoundedLikeNumber < 48500) {
 	 $range = 25;
 }
  if (48500   <=  $RoundedLikeNumber && $RoundedLikeNumber < 58500) {
 	 $range = 26;
 }
 
  if ( 58500  <= $RoundedLikeNumber && $RoundedLikeNumber < 69500) {
 	 $range = 27;
 }
  if (69500  <= $RoundedLikeNumber && $RoundedLikeNumber < 81500) {
 	 $range = 28;
 }
  if (81500   <= $RoundedLikeNumber && $RoundedLikeNumber < 100000) {
 	 $range = 29;
 }
  if ( $RoundedLikeNumber > 100000) {
 	 $range = 30;
 }

  echo json_encode([
"LikeNumber" => $range,
]);
 // var_dump(round($LikeNumber));
 
	function CheckNumber($text) {
	   if ($text == "VERY_LIKELY") {
	   	return 1;
	   }
	   if ($text == "LIKELY") {
	   	return 2;
	   }
	   if ($text == "POSSIBLE") {
	   	return 3;
	   }
	   if ($text == "UNLIKELY") {
	   	return 4;
	   }
	   if ($text == "VERY_UNLIKELY") {
	   	return 5;
	   }
	   if ($text == "UNKNOWN"){
	   	return 0;
	   }
	   
	}
	function BiggesetColorSearch($colorsArray){
		 $big = 0;
		 $bigIndex = 0;
		foreach ($colorsArray as $key => $color) {
			if ($color["score"] > $big){
				$big = $color["score"];
				$bigIndex = $key;
			}

		}
		return $colorsArray[$bigIndex]["color"];
		
	}
	function getWeekday($date) {
    return date('w', strtotime($date));
	}
	

?>