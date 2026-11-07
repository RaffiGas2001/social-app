<?php
    require '../Admin/admin.php';

    // Ստուգում ենք, արդյոք սեսսիայում կա ակտիվ օգտագործող՝ ըստ id-ի
    if(!empty($_SESSION["id"])){
        $id = $_SESSION["id"];
        // Տվյալների բազայից վերցնում ենք տվյալ օգտագործողի ամբողջ ինֆորմացիան
        $result = mysqli_query($conn, "SELECT * FROM `users` WHERE id = $id");
        $row = mysqli_fetch_assoc($result); 
    } else {
        // Եթե սեսսիայում չկա id, ուղարկում ենք օգտվողին լոգին էջ
        header("Location: ../Login/login.php");
        exit();
    }

    // Եթե օգտատերը սեղմել է "update" կոճակը՝ թարմացնելու համար տվյալները
    if (isset($_POST["update"])) {
        $id = $_SESSION["id"]; // Ընդհանուր օգտատիրոջ id
        // Ստանում ենք ֆորմայից ուղարկված տվյալները
        $nameSurname = $_POST["name_surname"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $phoneNumber = $_POST["phone_number"];
        $password = $_POST["password"];
        $gender = $_POST["gender"];

        // Եթե նոր գաղտնաբառ տրվել է, ապա կոդավորում ենք այն, հակառակ դեպքում պահում ենք նախկին գաղտնաբառը
        if (!empty($password)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $password = $row['password'];
        }

        // Կազմում ենք SQL հարցումը՝ տվյալների թարմացման համար
        $update = "UPDATE `users` SET 
            name_surname = '$nameSurname', 
            username = '$username', 
            email = '$email', 
            phone_number = '$phoneNumber', 
            password = '$password', 
            gender = '$gender'";

        // Եթե օգտատերը նոր նկար է ընտրել՝ բազայում թարմացնենք այն
        if (!empty($_FILES['image']['tmp_name'])) {
            $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
            $update .= ", image = '$image'";
        }

        // Եթե օգտատերը ցանկանում է ջնջել նկարը, ապա նկարին նշանակենք NULL
        if (!empty($_POST['delete_image'])) {
            $update .= ", image = NULL";
        }

        // Ավարտում ենք հարցումը՝ նշելով WHERE սակագիծը id-ի համար
        $update .= " WHERE id = $id";

        // Շատացնում ենք տվյալների բազայում
        mysqli_query($conn, $update);

        // Վերադառնում ենք գլխավոր էջ
        header("Location: ../index.php");
        exit();
    }

    // Եթե օգտատերը սեղմել է "delete" կոճակը՝ հաշիվը ջնջելու համար
    if(isset($_POST["delete"])){
        $id = $_SESSION["id"];
        // Ջնջում ենք օգտվողի գրառումը տվյալների բազայից
        $delete = "DELETE FROM `users` WHERE id=$id";
        mysqli_query($conn, $delete);
        
        // Մաքրում ենք սեսսիան և ավերում ենք այն
        session_unset();
        session_destroy();

        // Հանձնում ենք օգտատիրոջը լոգին էջ
        header("Location: ../Login/login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="setting.css">
    <title>Settings</title>
</head>
<body>
<div id="language-selector" style="text-align: right; padding: 10px;">
  <select id="language" onchange="changeLanguage(this.value)">
    <option value="en">English</option>
    <option value="hy">Հայերեն</option>
    <option value="ru">Русский</option>
  </select>
</div>
    <section class="main">
        <div class="profile-card">
            <h2 data-translate="personal_info">Personal information</h2>
            <form action="#" method="post" enctype="multipart/form-data">
                <span data-translate="picture">Picture: </span><input type="file" accept=".jpg, .jpeg, .png" name="image">

                <label>
                    <input type="checkbox" name="delete_image" value="1">
                    <span data-translate="delete_picture">Delete image</span>
                </label>

                <input type="text" name="name_surname" value="<?php echo $row['name_surname']?>">
                <input type="text" name="username" value="<?php echo $row['username']?>">
                <input type="email" name="email" value="<?php echo $row['email']?>">
                <input type="text" name="phone_number" value="<?php echo $row['phone_number']?>">
                <input type="password" name="password" data-translate="new_password_change" placeholder="New Password (if you want to change it)">
                <input type="text" name="gender" value="<?php echo $row['gender']?>">
                <input type="submit" name="update" data-translate="update" value="Update">
                <input type="submit" name="delete" data-translate="delete_account" value="Delete Account">
            </form>
        </div>
    </section>
    <script src="../Language/language.js"></script>
    <script src="setting.js"></script>
</body>
</html>