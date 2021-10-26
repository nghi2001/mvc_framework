<?php
   require APPROOT . '/view/Layout/head.php';
?>

<div class="navbar">
    <?php
       require APPROOT . '/view/Layout/navigation.php';
    ?>
</div>
<?php if(isset($_SESSION['id'])) echo 'success';else echo 'failed';
?>
<div class="container-login">
    <div class="wrapper-login">
        <h2>Sign in</h2>

        <form action="<?php echo URLROOT; ?>/auth/login" method ="POST">
            <input type="text" placeholder="Username *" name="username"><br>
            <span class="invalidFeedback">
                <?php echo $data['usernameError']; ?>
            </span><br>

            <input type="password" placeholder="Password *" name="password"><br>
    
            <span class="invalidFeedback">
                <?php echo $data['passError']; ?>
            </span><br>

            <button id="submit" type="submit" value="submit">Submit</button>

            <p class="options">Not registered yet? <a href="<?php echo URLROOT; ?>/auth/register">Create an account!</a></p>
            <p class="options">Change password <a href="<?php echo URLROOT; ?>/auth/changepass">change pass</a></p>
        </form>
        <a href='<?php echo $data['authURL'] ?>' class="google_login">
        <i class="fab fa-google"></i>
            Login
        </a>
    </div>
</div>