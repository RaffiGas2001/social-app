<?php
  require '../Admin/admin.php';

  if (isset($_POST['submit'])) {
    $nameSurname = $_POST["name_surname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phone_number"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $gender = $_POST["gender"];
    $birthdate = $_POST["birthdate"];

    // Ստուգում ենք՝ username կամ email կրկնվում են, թե ոչ
    $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
    if (mysqli_num_rows($duplicate) > 0) {
      $error_message = "Username or Email already taken.";
    }
    else {
      // Գաղտնաբառի համընկնում
      if ($password !== $confirmpassword) {
        $error_message = "Passwords do not match.";
      }
      // Գաղտնաբառի երկարությունը
      elseif (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
      }
      else {
        // Գաղտնաբառի hash
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Տվյալների մուտքագրում
        $query = "INSERT INTO users (name_surname, username, email, phone_number, password, gender, birthdate) 
                  VALUES ('$nameSurname', '$username', '$email', '$phoneNumber', '$hashedPassword', '$gender', '$birthdate')";
        mysqli_query($conn, $query);

        header("Location: ../Login/login.php");
        exit();
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Responsive Registration Form | CodingLab </title>
  <link rel="stylesheet" href="registration.css">
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
    <div class="title" data-translate="registration">Registration</div>
    <div class="content">
      <div id="error-message" style="color: red; display: none;"></div>
      <form action="#" method="post">
        <div class="user-details">
          <div class="input-box">
            <span class="details" data-translate="full_name">Full Name</span>
            <input type="text" data-translate="enter_name" placeholder="Enter your name-surname" name="name_surname" required value="">
          </div>
          <div class="input-box">
            <span class="details" data-translate="username">Username</span>
            <input type="text" data-translate="enter_username" placeholder="Enter your username" name="username" required value="">
          </div>
          <div class="input-box">
            <span class="details" data-translate="email">Email</span>
            <input type="email" data-translate="enter_email" placeholder="Enter your email" name="email" required value="">
          </div>
          <div class="input-box">
            <span class="details" data-translate="phone">Phone Number</span>
            <input type="text" data-translate="enter_phone" placeholder="Enter your number" name="phone_number" required value="">
          </div>
          <div class="input-box">
            <span class="details" data-translate="birthdate">Birthdate</span>
            <input type="date" name="birthdate" required>
          </div>
          <br>
          <div class="password-group">
            <div class="input-box">
              <span class="details" data-translate="password">Password</span>
              <input type="password" data-translate="enter_password" placeholder="Enter your password" name="password" required value="">
            </div>
            <div class="input-box">
              <span class="details" data-translate="confirm_password">Confirm Password</span>
              <input type="password" data-translate="confirm_your_password" placeholder="Confirm your password" name="confirmpassword" required value="">
            </div>
        </div>
        </div>
        <div class="gender-details">
          <input type="radio" name="gender" value="male" id="dot-1">
          <input type="radio" name="gender" value="female" id="dot-2">
          <input type="radio" name="gender" value="prefer not to say" id="dot-3">
          <span class="gender-title" data-translate="gender">Gender</span>
          <div class="category">
            <label for="dot-1">
              <span class="dot one"></span>
              <span class="gender" data-translate="male">Male</span>
            </label>
            <label for="dot-2">
              <span class="dot two"></span>
              <span class="gender" data-translate="female">Female</span>
            </label>
            <label for="dot-3">
              <span class="dot three"></span>
              <span class="gender" data-translate="prefer_not_say">Prefer not to say</span>
            </label>
          </div>
        </div>
        <div class="button">
          <input type="submit" data-translate="registration" name="submit" value="REGISTRATION">
        </div>
      </form>
      <a href="../Login/login.php" data-translate="login">Log In</a>
    </div>
  </div>
  <script>
    <?php if(isset($error_message)): ?>
      document.getElementById("error-message").innerHTML = "<?php echo $error_message; ?>";
      document.getElementById("error-message").style.display = "block";
    <?php endif; ?>
  </script>
    <script src="../Language/language.js"></script>
</body>
</html>