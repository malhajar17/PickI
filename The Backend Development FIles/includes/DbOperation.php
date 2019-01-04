
<?php
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class DbOperation
{
    private $conn;
 
    //Constructor
    function __construct()
    {
        require_once 'Config.php';
        require_once 'DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
 
    //Function to create a new user
    public function createUser($FirstName, $LastName , $email,$username,$Password,$Date)
    {
        $stmt = $this->conn->prepare("INSERT INTO Users(FirstName, LastName,Email,Username,Password,CreationTime) values(?,?,?,?,?,?)");
     
        $stmt->bind_param("ssssss", $FirstName, $LastName ,$email,$username,$Password,$Date);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUser($didLogin,$FollowingNumber,$FollowerNumber,$NumOfPost,$Celebrity,$username)
    {
        $stmt = $this->conn->prepare("UPDATE Users SET DidLogin = ? , FollowingNumber = ? , FollowersNumber = ? , NumberOfPosts = ? , Celebrity = ? where Username = ?");
        $stmt->bind_param("iiiiis", $didLogin, $FollowingNumber,$FollowerNumber,$NumOfPost,$Celebrity,$username);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function updateUserPhoto($ArrayOfAccounts)
    {
        $stmt = $this->conn->prepare("UPDATE Users SET
         Celebrity = ?,
         CreationTime = ? ,
         Ad = ?,
         FaceOneJoy = ? ,
         FaceOneExposed= ?,
         FaceOneSorrow = ?,
         FaceOneBlurred = ?,
         FaceOneHeadwear = ?,
         FaceOneSurprised = ?,
         FaceOneAnger = ?,
         FaceTwoAnger = ?,
         FaceTwoJoy = ?,
         FaceTwoSorrow = ?,
         FaceTwoExposed = ?,
         FaceTwoBlurred = ?,
         FaceTwoHeadwear = ?,
         FaceTwoSurprised = ?,
         FaceThreeJoy = ?,
         FaceThreeExposed = ?,
         FaceThreeBlurred = ?,
         FaceThreeHeadwear = ?,
         FaceThreeAnger = ?,
         FaceThreeSorrow = ?,
         FaceThreeSurprised = ?,
         DominantRed = ?,
         DominantGreen = ?,
         DominantBlue = ?

          where Username = ?");
        $stmt->bind_param("iiiiiiiiiiiiiiiiiiiiiiiiiiis", 
          $ArrayOfAccounts["Celebrity"],
          $ArrayOfAccounts["CreationTime"],
          $ArrayOfAccounts["Ad"],
          $ArrayOfAccounts["FaceOneJoy"],
          $ArrayOfAccounts["FaceOneExposed"],
          $ArrayOfAccounts["FaceOneSorrow"],
          $ArrayOfAccounts["FaceOneBlurred"],
          $ArrayOfAccounts["FaceOneHeadwear"],
          $ArrayOfAccounts["FaceOneSurprised"],
          $ArrayOfAccounts["FaceOneAnger"],
          $ArrayOfAccounts["FaceTwoAnger"],
          $ArrayOfAccounts["FaceTwoJoy"],
          $ArrayOfAccounts["FaceTwoSorrow"],
          $ArrayOfAccounts["FaceTwoExposed"],
          $ArrayOfAccounts["FaceTwoBlurred"],
          $ArrayOfAccounts["FaceTwoHeadwear"],
          $ArrayOfAccounts["FaceTwoSurprised"],
          $ArrayOfAccounts["FaceThreeJoy"],
          $ArrayOfAccounts["FaceThreeExposed"],
          $ArrayOfAccounts["FaceThreeBlurred"],
          $ArrayOfAccounts["FaceThreeHeadwear"],
          $ArrayOfAccounts["FaceThreeAnger"],
          $ArrayOfAccounts["FaceThreeSorrow"],
          $ArrayOfAccounts["FaceThreeSurprised"],
          $ArrayOfAccounts["DominantRed"],
          $ArrayOfAccounts["DominantGreen"],
          $ArrayOfAccounts["DominantBlue"],
          $ArrayOfAccounts["username"]
          );
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {
          $error = $this->conn->errno . ' ' . $this->conn->error;
        echo mysqli_errno($this->conn);

        echo $error;
            return false;
        }
    }
    public function updateData($ID,$LikesNumber,$commentsNumber)
    {
        $stmt = $this->conn->prepare("UPDATE InstagramData SET LikeNum = ? , CommentsNum = ?  where ID = ?");
        $stmt->bind_param("iii", $LikesNumber, $commentsNumber,$ID);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function createEntry( 
                $FollowingNumber = -1,
                $FollowerNumber = -1 ,
                $NumOfPost = -1,
                $AccountOwnerUserName="",
                $VerfiedAccount =-1, 
                $Biography ="" ,
                $profilePicUrl= "",
                $profileId= -1 ,
                $ImageLink="" ,
                $ImageInstagramLink="",
                $LikeNum =-1 ,
                $CommentsNum=-1 ,
                $CreationTime="",
                $Caption= "" ,
                $Ad= false,
                $FaceOneJoy,
                $FaceOneExposed,
                $FaceOneSorrow,
                $FaceOneBlurred,
                $FaceOneHeadwear,
                $FaceOneSurprised,
                $FaceOneAnger,
                $FaceTwoAnger,
                $FaceTwoJoy,
                $FaceTwoSorrow,
                $FaceTwoExposed,
                $FaceTwoBlurred,
                $FaceTwoHeadwear,
                $FaceTwoSurprised,
                $FaceThreeJoy,
                $FaceThreeExposed,
                $FaceThreeBlurred,
                $FaceThreeHeadwear,
                $FaceThreeAnger,
                $FaceThreeSorrow,
                $FaceThreeSurprised,
                $DominantRed,
                $DominantGreen,
                $DominantBlue
               )
    {
        if($Ad == false)
            $Ad = 0;
        else
            $Ad = 1;
        $VerfiedAccount = 0;
        if ($VerfiedAccount == true) {
            $VerfiedAccount = 1;
        }
        $stmt = $this->conn->prepare("INSERT INTO InstagramDataFamous(
             FollowingNumber,
             FollowerNumber,
             NumOfPost,
             AccountOwnerUserName,
             VerfiedAccount,
             Biography,
             profilePicUrl,
             profileId,
             ImageLink,
             ImageInstagramLink,
             LikeNum,
             CommentsNum,
             CreationTime,
             Caption,
             Ad,
             FaceOneJoy,
             FaceOneExposed,
             FaceOneSorrow,
             FaceOneBlurred,
             FaceOneHeadwear,
             FaceOneSurprised,
             FaceOneAnger,
             FaceTwoAnger,
             FaceTwoJoy,
             FaceTwoSorrow,
             FaceTwoExposed,
             FaceTwoBlurred,
             FaceTwoHeadwear,
             FaceTwoSurprised,
             FaceThreeJoy,
             FaceThreeExposed,
             FaceThreeBlurred,
             FaceThreeHeadwear,
             FaceThreeAnger,
             FaceThreeSorrow,
             FaceThreeSurprised,
             DominantRed,
             DominantGreen,
             DominantBlue

              ) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
         ");
        if ($stmt){
        $stmt->bind_param("iiisississiissiiiiiiiiiiiiiiiiiiiiiiiii",
          $FollowingNumber,
          $FollowerNumber ,
          $NumOfPost ,
          $AccountOwnerUserName,
          $VerfiedAccount ,
          $Biography ,
          $profilePicUrl,
          $profileId ,
          $ImageLink ,
          $ImageInstagramLink,
          $LikeNum ,
          $CommentsNum ,
          $CreationTime,
          $Caption ,
          $Ad,
          $FaceOneJoy,
          $FaceOneExposed,
          $FaceOneSorrow,
          $FaceOneBlurred,
          $FaceOneHeadwear,
          $FaceOneSurprised,
          $FaceOneAnger,
          $FaceTwoAnger,
          $FaceTwoJoy,
          $FaceTwoSorrow,
          $FaceTwoExposed,
          $FaceTwoBlurred,
          $FaceTwoHeadwear,
          $FaceTwoSurprised,
          $FaceThreeJoy,
          $FaceThreeExposed,
          $FaceThreeBlurred,
          $FaceThreeHeadwear,
          $FaceThreeAnger,
          $FaceThreeSorrow,
          $FaceThreeSurprised,
          $DominantRed,
          $DominantGreen,
          $DominantBlue
        );

        $result = $stmt->execute();
        $stmt->close();}
        else {
        $error = $this->conn->errno . ' ' . $this->conn->error;
        echo mysqli_errno($this->conn);

        echo $error; // 1054 Unknown column 'foo' in 'field list'
   
        }
        // var_dump($FollowingNumber);
        // var_dump($FollowerNumber);
        // var_dump($NumOfPost);
        // var_dump($AccountOwnerUserName);
        // var_dump($VerfiedAccount);
        // var_dump($Biography);
        // var_dump($profilePicUrl);
        // var_dump($profileId);
        // var_dump($ImageLink);
        // var_dump($LikeNum);

        // var_dump($ImageInstagramLink);

        // var_dump($CommentsNum);

        // var_dump($CreationTime);

        // var_dump($Caption);

        var_dump($result);
        if ($result) {
            return true;
        } else {
            
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo mysqli_error($this->conn);
        echo $error;
        return false;
        }
        var_dump($result);
        
    }
    //Function to get the users
    public function getUsers()
    {
        $query = "SELECT * From Users";
        $result=mysqli_query($this->conn,$query);
        $row=mysqli_fetch_array($result,MYSQLI_NUM);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }   
        
        
      
        if ($result) {
            return $rows; 
        } else {
            return false;
        }
    }
    public function getData()
    {
        $query = "SELECT ID,ImageInstagramLink From  InstagramData";
        $result=mysqli_query($this->conn,$query);
        $row=mysqli_fetch_array($result,MYSQLI_NUM);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }   
        
        
      
        if ($result) {
            return $rows; 
        } else {
            return false;
        }
    }
 
}
?>