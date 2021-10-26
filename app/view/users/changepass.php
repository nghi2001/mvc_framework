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

        <form action="<?php echo URLROOT; ?>/auth/changepass" method ="POST">
            <input type="text" placeholder="Email *" name="email"><br>
            <span class="invalidFeedback">
                <?php echo $data['usernameError']; ?>
            </span><br>

            <input type="password" placeholder="Old Password *" name="pass"><br>
    
            <span class="invalidFeedback">
                <?php echo $data['passError']; ?>
            </span><br>

            <input type="password" placeholder="New Password *" name="newpass"><br>
    
            <span class="invalidFeedback">
                <?php echo $data['newpassError']; ?>
            </span><br>

            <span style="color: #27d959;">
                <p><?php echo $data['success'] ?></p>
            </span>
            <button id="submit" type="submit" value="submit">Submit</button>
            
        </form>
        
    </div>
</div>