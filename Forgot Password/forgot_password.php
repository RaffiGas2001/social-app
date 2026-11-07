<?php
    session_start();
    require '../Admin/admin.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="forgot_password.css">
</head>
<body>
<div id="language-selector" style="text-align: right; padding: 10px;">
  <select id="language" onchange="changeLanguage(this.value)">
    <option value="en">English</option>
    <option value="hy">Հայերեն</option>
    <option value="ru">Русский</option>
  </select>
</div>
    <div class="container">
        <div class="title" data-translate="forgot_password">Forgot Password</div>
        <div class="content">
        <div id="notification" class="notification"></div>
            <form action="#" method="post">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details" data-translate="email">Email</span>
                        <input type="email" data-translate="enter_email" placeholder="Enter your email" name="email" required value="">
                    </div>
                    <div class="input-box">
                        <span class="details" data-translate="new_password">New Password</span>
                        <input type="password" data-translate="enter_new_password" placeholder="Enter new password" name="new_password" required value="">
                    </div>
                    <div class="input-box">
                        <span class="details" data-translate="confirm_new_password">Confirm New Password</span>
                        <input type="password" data-translate="confirm_new_password" placeholder="Confirm new password" name="confirm_password" required value="">
                    </div>
                </div>
                <div class="button">
                    <input type="submit" name="submit" data-translate="reset_password" value="RESET PASSWORD">
                </div>
            </form>
            <a href="../Login/login.php" data-translate="back_to_login">Back to Login</a>
        </div>
    </div>
     <!-- Ֆունկցիա՝ ցուցադրելու ծանուցումներ էջում -->
    <script>
        function showNotification(message) {
            var notification = document.getElementById("notification");
            // Սահմանում ենք տեքստը
            notification.textContent = message;
            // Դիտանելի ենք դարձնում
            notification.style.display = "block";
            notification.style.background = "lightgreen"
             // 5 վայրկյան անց թաքցնում ենք ծանուցումը
            setTimeout(function() {
                notification.style.display = "none";
            }, 5000);
        }
    </script>

    <?php
        if(isset($_POST["submit"])){
            $email = $_POST["email"];
            $new_password = $_POST["new_password"];
            $confirm_password = $_POST["confirm_password"];

            if($new_password !== $confirm_password){
                echo "<script>showNotification('Passwords do not match');</script>";
            } else {
                $result = mysqli_query($conn, "SELECT * FROM `users` WHERE `email` = '$email'");
                $row = mysqli_fetch_assoc($result);
        
                if(mysqli_num_rows($result) > 0){
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_query = "UPDATE `users` SET `password` = '$hashed_password' WHERE `email` = '$email'";
                    if(mysqli_query($conn, $update_query)){
                        echo "<script>showNotification('Password successfully updated');</script>";
                    } else {
                        echo "<script>showNotification('Failed to update password');</script>";
                    }
                } else {
                    echo "<script>showNotification('Email not found');</script>";
                }
            }
        }
    ?>
      <script src="../Language/language.js"></script>
</body>
</html>