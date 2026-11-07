<?php
// Սկսում ենք session, որպեսզի օգտագործենք session փոփոխականները
session_start();
require "../Admin/admin.php";

// Ստանում ենք ներկայումս մուտք գործած օգտագործողի username-ը, կամ null եթե չկա
$currentUsername = $_SESSION['username'] ?? null;

// Ստուգում ենք, արդյոք ուղարկված է 'search' հարցում (GET տարբերակում)
if (isset($_GET['search'])) {
    // Վերականգնվող տողը վերցնում ենք, անվտանգ դարձնում SQL ինջեկցիաներից պաշտպանվելու համար
    $term = $conn->real_escape_string($_GET['search']);

    // Եթե ունենք մուտք գործած օգտվող, ապա բացառում ենք նրան որոնման արդյունքներից
    $excludeSelf = $currentUsername ? "AND username != '$currentUsername'" : "";

    // SQL հարցում, որը փնտրում է օգտվողների username կամ name_surname դաշտերում համապատասխանություններ
    // Վերցնում ենք առավելագույնը 10 արդյունք
    $sql = "SELECT username, name_surname, image FROM users 
        WHERE (username LIKE '%$term%' OR name_surname LIKE '%$term%') 
        $excludeSelf 
        LIMIT 10";

// Կատարում ենք հարցումը
$result = $conn->query($sql);
// Ստեղծում ենք զանգված՝ արդյունքների համար
$users = [];

// Հետազոտում ենք արդյունքները հերթականաբար
while ($row = $result->fetch_assoc()) {
    // Եթե նկար կա
    if (!empty($row['image'])) {
        // Եթե նկար դաշտի արժեքը URL է, թողնում ենք այնպես ինչպես կա
        if (filter_var($row['image'], FILTER_VALIDATE_URL)) {
            $row['image'] = $row['image'];
        } else {
            // Հակառակ դեպքում՝ ենթադրում ենք, որ նկարն ուղիղ տվյալներ են (բազայի մեջ պահված)
            // Պատճենում ենք base64 ձևաչափով, որպեսզի նկարն ուղղակի կարողանա բեռնվել
            $row['image'] = 'data:image/jpeg;base64,' . base64_encode($row['image']);
        }
    } else {
        // Եթե նկար չկա, օգտագործում ենք լռելյայն նկարի ճանապարհ (փոխարինեք իրական ճանապարհով)
        $row['image'] = 'default_image_path.jpg';
    }
    // Ավելացնում ենք փոփոխված տվյալները users զանգվածին
    $users[] = $row;
}
// Վերադարձնում ենք JSON ձևաչափով որոնման արդյունքները
echo json_encode($users);
// Վերջացնում ենք սցենարը՝ ոչ մի ավելորդ բան չկատարելու համար
exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messenger</title>
    <link rel="stylesheet" href="messenger.css">
    <script src="messenger.js" defer></script>
</head>
<body>
<div id="language-selector" style="text-align: right; padding: 10px;">
  <select id="language" onchange="changeLanguage(this.value)">
    <option value="en">English</option>
    <option value="hy">Հայերեն</option>
    <option value="ru">Русский</option>
  </select>
</div>
    <div id="messenger-container">
        <div class="header">
            <h2 data-translate="message">Messenger</h2>
            <button id="closeMessenger">X</button>
        </div>

        <div class="search-user">
            <input type="text" id="searchInput" data-translate="search_user" placeholder="Search for user...">
        </div>

        <ul id="searchResults"></ul>

        <div class="chat-area" id="chatArea">
            <div class="system" data-translate="select_user_chat">Select a user to chat with</div>
        </div>

        <form class="message-form" id="messageForm" onsubmit="sendMessage(event)">
            <input type="text" id="messageInput" data-translate="type_message" placeholder="Type your message..." required>
            <button type="submit" data-translate="send">Send</button>
        </form>
    </div>
    <script src="../Language/language.js"></script>
</body>
</html>