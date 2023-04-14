<?php
class Account{
    private $pdo;
    private $errorArray = array();

    public function __construct(){
    $this->pdo=Database::instance();
    }

    public function register($fn,$ln,$un,$em,$pw,$pw2){
        $this->validatefirstName($fn);
        $this->validatelastName($ln);
        $this->validatelastEmail($em);
        $this->validatePassword($pw, $pw2);

        if(empty($this->errorArray)){
            return $this->insertUserDetails($fn,$ln,$un,$em,$pw);
        }else{
            return true;
        }
    }
    public function insertUserDetails($fn,$ln,$un,$em,$pw){
        $passHash=password_hash($pw, PASSWORD_BCRYPT);
        $rand = rand(0,2);
        If($rand==0){
            $profilePic="../../frontend/assets/images/defaultProfilePic.png";
            $profileCover="../../frontend/assets/images/backgroundCoverPic.svg";
        }else if($rand==1){
            $profilePic="../../frontend/assets/images/defaultPic.svg";
            $profileCover="../../frontend/assets/images/backgroundImage.svg";
        }else if($rand==2){
            $profilePic="../../frontend/assets/ProfilePic.jpeg";
            $profileCover="../../frontend/assets/images/backgroundCoverPic.svg";
        }
        $stmt=$this->pdo->prepare("INSERT INTO users (firstName, lastName, username, email, password, profileImage, profileCover) VALUES (:fn, :ln, :un, :em, :pw, :pic, :cov)");
        $stmt->bindParam(":fn",$fn, PDO::PARAM_STR);
        $stmt->bindParam(":ln",$ln, PDO::PARAM_STR);
        $stmt->bindParam(":un",$un, PDO::PARAM_STR);
        $stmt->bindParam(":em",$em, PDO::PARAM_STR);
        $stmt->bindParam(":pw",$passHash, PDO::PARAM_STR);
        $stmt->bindParam(":pic",$profilePic, PDO::PARAM_STR);
        $stmt->bindParam(":cov",$profileCover, PDO::PARAM_STR);
       
        $stmt->execute();

        return $this->pdo->lastInsertId();


    }
    private function validatefirstName($fn){
            if($this->lenght($fn,3,25)){
            return array_push($this->errorArray, Constant::$firstNameCharacters);
            }
        }
    
    private function validatelastName($ln){
           if($this->lenght($ln,3,25)){
            return array_push($this->errorArray, Constant::$lastNameCharacters);
           }
        }
    
    private function validatelastEmail($em){
        $stmt=$this->pdo->prepare("SELECT * FROM `users` WHERE email=:email");
        $stmt->bindParam(":email",$em, PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count>0){
            return array_push($this->errorArray, Constant::$emailInUse);
        }
        if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
            return array_push($this->errorArray, Constant::$emailnValid);

        }

    }
    private function validatePassword($pw, $pw2){
        if($pw!=$pw2){
        return array_push($this->errorArray, Constant::$passwordDoNotMath);
        }
        if(preg_match("/[^A-Za-z0-9]/", $pw)){
        return array_push($this->errorArray, Constant::$passwordNotAlphanumeric);

        }
        if($this->lenght($pw,5,30)){
        return array_push($this->errorArray, Constant::$passwordLenght);
        }
    }


    public function getErrorMessage($error){
        if(in_array($error, $this->errorArray)){
        return "<span class='error'> $error</span>";
        }

    }
    private function lenght($input, $min,$max){
        if(strlen($input)<$min){
            return true;
        } else if(strlen($input)>$max){
            return true;
        }
    }


    public function generateUsername($fn,$ln){
        if(!empty($fn)&&!empty($ln)){
            if(!in_array(Constant::$firstNameCharacters, $this->errorArray)&& !in_array(Constant::$lastNameCharacters, $this->errorArray)){
                $username = strtolower($fn." ".$ln);
                if($this->checkUsernameExist($username)){
                    $screenRand=rand();
                    $userLink= $username."".$screenRand;
                }else{
                    $userLink=$username;
                }
                return $userLink;
            }
        }
    }
    private function checkUsernameExist($username){
        $stmt=$this->pdo->prepare("SELECT * FROM `users` WHERE username=:username");
        $stmt->bindParam(":username",$username, PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count>0){
            return true;
        }else{
            return false;
        }
    }
}


?>