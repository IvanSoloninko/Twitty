<?php 
 require_once 'backend/initialize.php';
 if(isset($_SESSION['userLogedIn'])){
     $user_id=$_SESSION['userLogedIn'];
     $user=$loadFromUser->userData($user_id);
     $linc=Verify::generateLinc();
     $message="{$user->firstName}, Your account has been created, pleas visit this linc to verifi your email <a href='http:://localhost/Twetty/verification/$linc'> Verifi Linc</a> ";
     $subject="[TWITTER] Pleas verify your account";
     $verify->sendToMail($user->email,$message,$subject);
     $loadFromUser->create("verification", ["user_id"=>$user_id, "code"=>$linc]);

    }else{
     redirect_to(url_for("index"));
 }
?>
<?php $pageTitle="Verify your account "?>
<?php require_once 'backend/shared/header.php'?>
<section class="sign-conteiner">
<?php require_once 'backend/shared/signNav.php'?>
   
    <div class="form-conteiner">
        <div class="form-content">
            <div class="header-form-content">
                <h2>A verification email has been sent to <?php echo $user->email;?> . Pleas check your <?php echo $user->email;?> to verification your account.</h2>
            </div>
            


        </div>
        
    </div>
</section>
<script src="frontend/assets/js/showPassword.js"></script>
