<?php
    session_start();
    require '../Admin/admin.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="login.css">
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
        <div class="title" data-translate="login">Log In</div>
        <div class="content">
        <div id="notification" class="notification"></div>
            <form action="#" method="post">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details" data-translate="username_or_email">Username or Email</span>
                        <input type="text" data-translate="enter_username" placeholder="Enter your username or email" name="usernameemail" required value="">
                    </div>
                    <div class="input-box">
                        <span class="details" data-translate="password">Password</span>
                        <input type="password" data-translate="enter_password" placeholder="Enter your password" name="password" required value="">
                    </div>
                </div>
                <div class="forgot-password-container">
                    <a href="../Forgot Password/forgot_password.php" class="forgot-password" data-translate="forgot_password">Forgot Password?</a>
                </div>
                <div class="button">
                    <input type="submit" name="submit" data-translate="login" value="LOGIN">
                </div>
            </form>
            <a href="../Registration/registration.php" data-translate="registration">Registration</a>
        </div>
    </div>

    <!-- Ծանուցում ցուցադրող JavaScript ֆունկցիա -->
    <script>
        function showNotification(message) {
            var notification = document.getElementById("notification"); // վերցնում ենք ծանուցման տարրը
            notification.textContent = message;                         // գրում ենք հաղորդագրությունը
            notification.style.display = "block";                       // ցուցադրում ենք տարրը

            setTimeout(function() {
                notification.style.display = "none";                    // 5 վայրկյան անց թաքցնում ենք
            }, 5000);
        }
    </script>

    <?php
        // Եթե մուտք գործելու ձևը ուղարկվել է (submit կոճակը սեղմվել է)
        if(isset($_POST["submit"])){
            $usernameemail = $_POST["usernameemail"]; // վերցնում ենք մուտքագրված օգտանունը կամ էլ․ հասցեն
            $password = $_POST["password"];           // վերցնում ենք մուտքագրված գաղտնաբառը

            // Բազայում փնտրում ենք օգտվողին ըստ օգտանվան կամ էլ․ հասցեի
            $result = mysqli_query($conn, "SELECT * FROM `users` WHERE `username` = '$usernameemail' OR `email` = '$usernameemail'");
            $row = mysqli_fetch_assoc($result); // բերում ենք տվյալները
        
            if(mysqli_num_rows($result) > 0){
                // Եթե օգտվողը կա բազայում, ստուգում ենք գաղտնաբառը
                if(password_verify($password, $row["password"])){
                    // Եթե գաղտնաբառը ճիշտ է՝ պահում ենք session տվյալներ
                    $_SESSION["login"] = true;
                    $_SESSION["id"] = $row["id"];
                    $_SESSION["username"] = $row["username"];
                    // Վերահղում ենք հիմնական էջ
                    header("Location: ../index.php");
                }
                else{
                    // Եթե գաղտնաբառը սխալ է՝ ցույց ենք տալիս ծանուցում
                    echo "<script>showNotification('Wrong Password');</script>";
                }
            }
            else{
                // Եթե օգտվողը չի գտնվել՝ ծանուցում
                echo "<script>showNotification('User Not Registered');</script>";
            }
        }
    ?>
      <script src="../Language/language.js"></script>
</body>
</html>