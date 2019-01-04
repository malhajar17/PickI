


<?php
require __DIR__ . 'vendor/autoload.php';
require_once '../includes/DbOperation.php';

$instagram = \InstagramScraper\Instagram::withCredentials('moisopol', 'Mohamed11', '/Users/mohamedalhajar/Downloads/instagram-scraper-master3');
$instagram->login();
$db = new DbOperation();
$medias = $instagram->getMediasByTag('selfie', 20);
$ArrayOfAccounts = array();
foreach ($medias as $key => $media) {
	$account = $media->getOwner();
	$theaccountinfo = (new \InstagramScraper\Instagram())->getAccountById($account->getId());
	$type = $media->getType();
$ArrayOfAccounts[$key] = array(
	// User related Info 
	'FollowingNumber'		 =>  $theaccountinfo->getFollowsCount(),
	'FollowerNumber'  		 =>  $theaccountinfo->getFollowedByCount(),
	'NumOfPost' 	 	     =>  $theaccountinfo->getMediaCount(),
	'AccountOwnerUserName' 	 =>  $theaccountinfo->getUsername(),
	'VerfiedAccount'         =>  $theaccountinfo->isVerified(),
	'Biography'              =>  $theaccountinfo->getBiography(),
	'profilePicUrl'			 =>  $theaccountinfo->getProfilePicUrl(),
	'profileId' 			 =>  $account->getId(),
	// Media related Info 
	'ImageLink'		  		 =>  $media->getImageHighResolutionUrl(),
	'ImageInstagramLink'     =>  $media->getLink(),
	'LikeNum' 			     =>  $media->getLikesCount(),
	'CommentsNum'   	     =>  $media->getCommentsCount(),
	'CreationTime'   		 =>  date('d-m-Y',$media->getCreatedTime()),
	'Caption' 		 		 =>  $media->getCaption(),	
	'Ad'				     =>  $media->isAd()
	 );

}var_dump($ArrayOfAccounts);
foreach ($ArrayOfAccounts as $key => $Account) {
 	//inserting values 
    if($db->createEntry($Account['FollowingNumber'],$Account['FollowerNumber'],$Account['NumOfPost'],$Account['AccountOwnerUserName'],$Account['VerfiedAccount'],$Account['Biography'],$Account['profilePicUrl'],$Account['profileId'],$Account['ImageLink'],$Account['ImageInstagramLink'],$Account['LikeNum'],$Account['CommentsNum'],$Account['CreationTime'],$Account['Caption'],$Account['Ad'])){
        $response['error']=false;
        $response['message']='Entry added successfully';
    }else{
 
        $response['error']=true;
        $response['message']='Could not add Entry';
    }
 }
  ?>


