<?php
   require APPROOT . '/view/Layout/head.php';
?>


<?php
    require APPROOT . '/view/Layout/navigation.php';
?>



<div class="container-login">
    <div class="wrapper-login">
        <h2>Register</h2>

            <form
                id="register-form"
                method="POST"
                action="<?php echo URLROOT; ?>/auth/register"
                >
            <div class="form_row">
            <input type="text" placeholder="Username *" name="username"><br>
            <span class="invalidFeedback">
                <?php echo $data['usernameError']; ?>
            </span>
            </div>

            <div class="form_row">
            <input type="email" placeholder="Email *" name="email"><br>
            <span class="invalidFeedback">
                <?php echo $data['emailError']; ?>
            </span>
            </div>

            <div class="form_row">
            <input type="password" placeholder="Password *" name="password"><br>
            <span class="invalidFeedback">
                <?php echo $data['passError']; ?>
            </span>
            </div>

            <div class="form_row">
            <input type="password" placeholder="Confirm Password *" name="confirmPassword"><br>
            <span class="invalidFeedback">
                <?php echo $data['confirmpassError']; ?><br>
            </span>
            </div>
            <button id="submit" type="submit" value="submit">Submit</button>

            
        </form>
    </div>
</div>

<?php require_once APPROOT.'/view/Layout/footer.php'; ?>