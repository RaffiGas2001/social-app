<?php
    // Ստուգում ենք՝ արդյոք session-ը դեռ չի սկսվել
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Եթե դեռ չի սկսվել, սկսում ենք session-ը՝ օգտագործողների տվյալները պահելու համար
    }
    $host = "localhost";  // Տեղական սերվերի հասցեն (հոսթնեյմը), սովորաբար տեղական օգտագործման ժամանակ "localhost"
    $dbusername = "root"; // Մուտքի անունը MySQL սերվերի համար, հիմնականում `root` տեղական համակարգերում
    $dbpassword = ""; // Գաղտնաբառը MySQL սերվերի համար, տեղական միջավայրում հաճախ դատարկ է
    $dbname = "social_site"; // Բազայի անունը, որը ցանկանում ենք օգտագործել
    
    $conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname); // Կապ ենք հաստատում MySQL բազայի հետ՝ mysqli_connect ֆունկցիայի միջոցով
    if(!$conn)die(mysqli_connect_error($conn)); // Եթե կապը չհաստատվեց, դադարեցնում ենք ծրագիրը և ցույց տալիս սխալը
?>