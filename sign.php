<?php 
 require_once 'backend/initialize.php';



if(is_post_request()){
    if(isset($_POST['firstName']) && !empty($_POST['firstName'])){
        $fname=FormSanitaizer::formSanitaizerName($_POST['firstName']);     
        $lname=FormSanitaizer::formSanitaizerName($_POST['lastName']);     
        $emai=FormSanitaizer::formSanitaizerString($_POST['email']);     
        $password=FormSanitaizer::formSanitaizerString($_POST['pass']);     
        $password2=FormSanitaizer::formSanitaizerString($_POST['pass2']);     

        $username=$account->generateUsername($fname,$lname);

        $wasSuccessful = $account->register($fname,$lname,$username,$emai,$password,$password2 );
        if($wasSuccessful){
            session_regenerate_id();
            $_SESSION['userLogedIn']=$wasSuccessful;
            if(isset($_POST['remember'])){
                $_SESSION['remember']=$_POST['remember'];
            }
              (url_for("verification"));
        }

    }

}
?>
<?php $pageTitle="SignUp | Twitter"?>
<?php require_once 'backend/shared/header.php'?>
<section class="sign-conteiner">
<?php require_once 'backend/shared/signNav.php'?>
   
    <div class="form-conteiner">
        <div class="form-content">
            <div class="header-form-content">
                <h2>Create your account</h2>
            </div>
            <form action="sign.php" class="formField" method="POST">
                <div class="form-group">
                    <?php echo $account->getErrorMessage(Constant::$firstNameCharacters); ?>
                    <label for="firstName">FirstName</label>
                    <input type="text" name="firstName" id="firstName" value="<?php getInputValue('firstName');?>" autocomplate="off" required>
                </div>
                <div class="form-group">
                <?php echo $account->getErrorMessage(Constant::$lastNameCharacters); ?>

                    <label for="lastName">LastName</label>
                    <input type="text" name="lastName" id="lastName"  value="<?php getInputValue('lastName');?>" autocomplate="off" required>
                </div> 
                <div class="form-group">
                <?php echo $account->getErrorMessage(Constant::$emailInUse); ?>
                <?php echo $account->getErrorMessage(Constant::$emailInValid); ?>

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email"  value="<?php getInputValue('email');?>" autocomplate="off" required>
                </div> 
                <div class="form-group">
                <?php echo $account->getErrorMessage(Constant::$passwordDoNotMath); ?>
                <?php echo $account->getErrorMessage(Constant::$passwordNotAlphanumeric); ?>
                <?php echo $account->getErrorMessage(Constant::$passwordLenght); ?>

                    <label for="pass">Password</label>
                    <input type="password" name="pass" id="pass" autocomplate="off" required>
                </div> 
                <div class="form-group">
                    <label for="cpass">Confirm Password</label>
                    <input type="password" name="pass2" id="cpass" autocomplate="off" required>
                </div>
                <div class="s-password">
                    <input type="checkbox" class="form-checkbox"  id="s-password" onclick="showPassword()">
                    <label for="s-password">Show Password</label>
                </div>
                <div class="form-btn-wrapper">
                    <button type="submit" class="btn-form">SignUp</button>
                    <input type="checkbox" name="remember" class="form-checkbox"  id="check">
                    <label for="remember">Remember Me</label>
                </div>
            </form>
        </div>
        <footer class="form-footer">
            <p>Already have an account. <a href="login">Login Now</a></p>
        </footer>
    </div>
</section>
<script src="frontend/assets/js/showPassword.js"></script>
