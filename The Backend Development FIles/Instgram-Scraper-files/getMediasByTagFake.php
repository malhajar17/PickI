


<?php

require   'vendor/autoload.php';
Unirest\Request::verifyPeer(false);
require '../includes/DbOperation.php';
require '/Users/mohamedalhajar/Downloads/Php-Google-API/vendor/autoload.php';
use Google\Cloud\Vision\VisionClient;
use phpFastCache\CacheManager;
ini_set('max_execution_time', 0);
putenv('GOOGLE_APPLICATION_CREDENTIALS=/Users/mohamedalhajar/Downloads/Intsagram helper-9ca46b702877.json');
$vision = new VisionClient();
$db = new DbOperation();
$instagram = \InstagramScraper\Instagram::withCredentials('mohamedalhajjar1', 'Mohamed11', '/Users/mohamedalhajar/Downloads/instagram-scraper-master3');
$media = $instagram->getMediaByUrl('https://www.instagram.com/p/BHaRdodBouH');
echo "Number of likes: {$media->getLikesCount()}";
// var_dump($db->getData());
$dataArray = $db->getData();
foreach ($dataArray as $key => $value) {
	$link = $dataArray[$key]["ImageInstagramLink"]; 
	if ($link) {
		# code...
	try {
			$media = $instagram->getMediaByUrl($link);
	$dataArray[$key]["likes"] =$media->getLikesCount();  
	$dataArray[$key]["comments"]=$media->getCommentsCount();
	$likes 	  = $dataArray[$key]["likes"];
	$comments = $dataArray[$key]["comments"];
	$id = $dataArray[$key]["ID"];

	var_dump($db->updateData($id,$likes,$comments));

		} catch (Exception $e) {
			continue;
		}	
		if ($id < 3000) {
			continue;
		}
	
	}
}
//127
var_dump($dataArray);
// var_dump($media);
exit;
//moisopol
//Mohamed11

//marah.mousa.96
//0957744456
$HashtagsArray = array (
"happyguy" ,
"happyguys" ,
"happyperson" ,
"happypeople" ,
"happygirl" ,
"happygirls",
"happyboy" ,
"happyboys",
"happywife" ,
"happyhusband" ,
"happybabe",
"happybabes" ,
"happydude" ,
"happybaby",
"happybabies" ,
"happychild" ,
"happychildren" ,
"happykid" ,
"happykids"


// "",
// "",
// "",
// "",
// "",
// "",
// "",
// "",
);
foreach ($HashtagsArray as $keydir => $value) {
	$instagram->login();
	$response=array();
	
	$medias = $instagram->getMediasByTag($value, 100);
	$ArrayOfAccounts = array();
	$keyforarrayofaccounts = 0;
	// var_dump($medias);
	error_reporting(E_ALL);
	if(!$medias){
	echo "unable to process wait";
	//exit;
	continue;
}
	foreach ($medias as $key => $media) {
		try {
		$account = $media->getOwner();
		if (!$account)
			continue;
		
			$theaccountinfo = (new \InstagramScraper\Instagram())->getAccountById($account->getId());
			
		} catch (Exception $e) {
			echo "Error found but moving forward";
			continue;
		}
		

		$type = $media->getType();
		// var_dump($type);
		if ($type !== "image"){
			echo "it's a video";
			continue;
		}

		$Caption = explode('#', $media->getCaption());
		$Hashtag = " ";

		foreach ($Caption as $key => $value) {
			if ($key == 0) 
				continue;
			if ($key == 1) 
				$Hashtag = $value;
			
			$Hashtag = $Hashtag.', '.$value;
		}
		
		if (date('d-m-Y',$media->getCreatedTime()) > date("d-m-Y" , strtotime('-3 days'))){
			echo "not today/n";
			continue;
		}
		$ch = curl_init($media->getImageHighResolutionUrl());
		$nameOfPerson = utf8_encode($theaccountinfo->getUsername());
		$fp = fopen('/Users/mohamedalhajar/Downloads/mohamed/'.$nameOfPerson.'.jpg', 'wb');
		if(!$fp)
			echo"shit";
		// var_dump($nameOfPerson);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		$image = $vision->image(
	    fopen('/Users/mohamedalhajar/Downloads/mohamed/'.$nameOfPerson.'.jpg', 'r'),
	    ['faces','imageProperties']
		);
		
	    $annotation     = $vision->annotate($image);
	    $ColorsArray    = $annotation->imageProperties()->info()["dominantColors"]["colors"];
	    $dominantColors = BiggesetColorSearch($ColorsArray);
	    $DominantRed    = $dominantColors["red"];
	    $DominantGreen  = $dominantColors["green"];
	    $DominantBlue   = $dominantColors["blue"];

	    
		// copy($media->getImageHighResolutionUrl(), '/Users/mohamedalhajar/Downloads/mohamed');
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
		$thefaces = $annotation->faces();
		if(!isset($thefaces)){
			echo "not set faces";
			continue;
		}

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
	$verfiedaccountitis = 0;
	if ($theaccountinfo->isVerified()) {
		$verfiedaccountitis = 1;
	}
	$aditis = 0;
	if ($media->isAd()) {
		$aditis = 1;
	}

	$ArrayOfAccounts[$keyforarrayofaccounts] = array(
		// User related Info 
		'FollowingNumber'		 =>  $theaccountinfo->getFollowsCount(),
		'FollowerNumber'  		 =>  $theaccountinfo->getFollowedByCount(),
		'NumOfPost' 	 	     =>  $theaccountinfo->getMediaCount(),
		'AccountOwnerUserName' 	 =>  utf8_encode($theaccountinfo->getUsername()),
		'VerfiedAccount'         =>  $verfiedaccountitis,
		'Biography'              =>  utf8_encode($theaccountinfo->getBiography()),
		'profilePicUrl'			 =>  utf8_encode($theaccountinfo->getProfilePicUrl()),
		'profileId' 			 =>  $account->getId(),
		// Media related Info 
		'ImageLink'		  		 =>  utf8_encode($media->getImageHighResolutionUrl()),
		'ImageInstagramLink'     =>  utf8_encode($media->getLink()),
		'LikeNum' 			     =>  $media->getLikesCount(),
		'CommentsNum'   	     =>  $media->getCommentsCount(),
		'CreationTime'   		 =>  getWeekday(date('d-m-Y',$media->getCreatedTime())),
		'Caption' 		 		 =>  utf8_encode($Hashtag),	
		'Ad'				     =>  $aditis,
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
		'DominantBlue'			 => $DominantBlue

		 );
	$keyforarrayofaccounts = $keyforarrayofaccounts + 1;

		


	}



	foreach ($ArrayOfAccounts as $key => $Account) {
	 	//inserting values 
	 	// var_dump($Account);

	    if($db->createEntry(
	    	$Account['FollowingNumber'],
	    	$Account['FollowerNumber'],
	    	$Account['NumOfPost'],
	    	$Account['AccountOwnerUserName'],
	    	$Account['VerfiedAccount'],
	    	$Account['Biography'],
	    	$Account['profilePicUrl'],
	    	$Account['profileId'],
	    	$Account['ImageLink'],
	    	$Account['ImageInstagramLink'],
	    	$Account['LikeNum'],
	    	$Account['CommentsNum'],
	    	$Account['CreationTime'],
	    	$Account['Caption'],
	    	$Account['Ad'],
	    	$Account['FaceOneJoy'],
			$Account['FaceOneExposed'],
			$Account['FaceOneSorrow'],
			$Account['FaceOneBlurred'],
			$Account['FaceOneHeadwear'],
			$Account['FaceOneSurprised'],
			$Account['FaceOneAnger'],
			$Account['FaceTwoAnger'],
			$Account['FaceTwoJoy'],
			$Account['FaceTwoSorrow'],
			$Account['FaceTwoExposed'],
			$Account['FaceTwoBlurred'],
			$Account['FaceTwoHeadwear'],
			$Account['FaceTwoSurprised'],
			$Account['FaceThreeJoy'],
			$Account['FaceThreeExposed'],
			$Account['FaceThreeBlurred'],
			$Account['FaceThreeHeadwear'],
			$Account['FaceThreeAnger'],
			$Account['FaceThreeSorrow'],
			$Account['FaceThreeSurprised'],
			$Account['DominantRed'],
			$Account['DominantGreen'],
			$Account['DominantBlue']
	    )){
	 	// if ($db->createEntry(1,1,2,'moh',1,'fdv','scd',2,'verv','dfv',1,1,'vev','avc',1)){ 
	        $response['error']=false;
	        $response['message']='Entry added successfully';
	    }else{
	 
	      echo "string";  // var_dump($Account);
	    }
	 }
	//  if ($keydir == 8) {

	// return true;
	//  }
	  echo "finished first one ";
	 sleep(480);
} 

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
	 return $response;
  ?>


