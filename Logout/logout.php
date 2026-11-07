<?php
    require '../Admin/admin.php';
     // Դատարկում ենք ամբողջ session զանգվածը՝ ջնջելով բոլոր session փոփոխականները
    $_SESSION = [];
    // Հանում ենք բոլոր session փոփոխականները PHP-ի հիշողությունից
    session_unset();
    //Ավարտում ենք session-ը՝ օգտվողի տվյալներն ամբողջությամբ հեռացնելու համար
    session_destroy();
    // Վերահղում ենք օգտվողին մուտք գործելու էջ
    header("Location: ../Login/login.php");
    // Կանգնեցնում ենք script-ի աշխատանքը, որպեսզի հետագա կոդ չկատարվի
    exit();
?>