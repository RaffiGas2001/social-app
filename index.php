<?php
require 'Admin/admin.php';

// Ստուգում ենք, արդյոք user-ը մուտքագրած է (id պահվում է session–ում)
if (!empty($_SESSION["id"])) {
    // Վերցնում ենք session-ից օգտատիրոջ id–ն
    $id = $_SESSION["id"];
    // Query՝ տվյալ տվյալ id–ով օգտատիրոջ ամբողջ տվյալները բազայում գտնելու համար
    $result = mysqli_query($conn, "SELECT * FROM `users` WHERE id = $id");
    // Փոխարկում ենք արդյունքը ասոցատիվ զանգվածի
    $row = mysqli_fetch_assoc($result); 
} else {
    // Եթե session–ում id–ն չկա, վերադարձնում ենք գլխավոր էջի home.php
    header("Location: Home/home.php");
    exit();
}

// Եթե URL–ում կա 'search' GET պարամետրը, սկսում ենք որոնման լոգիկա
if (isset($_GET['search'])) {
  // Արթնացնող տերմինը վերցնում ենք GET-ից և պաշտպանում SQL ինջեկցիաներից
  $term = $conn->real_escape_string($_GET['search']);

  // SQL հարցում՝ գտնելու օգտատերերին ըստ username կամ name_surname
  // և բացառում ենք ներկայիս մուտք գործած օգտատերին
  $sql = "SELECT id, username, name_surname FROM users 
          WHERE (username LIKE '%$term%' OR name_surname LIKE '%$term%') 
          AND username != '{$row['username']}' 
          LIMIT 10";

  // Կատարում ենք հարցումը
  $result = $conn->query($sql);

  // Ստեղծում ենք զանգված արդյունքների համար
  $users = [];
  // Լցնում ենք զանգվածը յուրաքանչյուր գտած օգտատիրոջ տվյալներով
  while ($user = $result->fetch_assoc()) {
      $users[] = $user;
  }

  // Վերադարձնում ենք JSON ձևաչափով որոնման արդյունքները
  echo json_encode($users);
  // Ապահովում ենք, որ հաջորդին այլ կոդ չի կատարվի
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>INDEX</title>
  <link rel="stylesheet" href="profile.css">
  <link rel="stylesheet" href="profileMessenger.css">
</head>
<body>
<div id="language-selector" style="text-align: right; padding: 10px;">
  <select id="language" onchange="changeLanguage(this.value)">
    <option value="en">English</option>
    <option value="hy">Հայերեն</option>
    <option value="ru">Русский</option>
  </select>
</div>
<div class="theme-selector">
    <label for="theme" data-translate="theme">🎨 Theme:</label>
    <select id="theme" onchange="changeTheme(this.value)">
      <option value="default" data-translate="default">Default</option>
      <option value="light" data-translate="light">Light</option>
      <option value="dark" data-translate="dark">Dark</option>
    </select>
</div>
<section class="main">
  <div class="profile-card">
    <div class="image">
      <?php 
        if (!empty($row['image'])) {
          echo '<img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" class="profile-pic">';
        } else {
          echo '<img src="Images/no_image.jpg" class="profile-pic">';
        }
      ?>
    </div>
    <div class="data">
      <h2><?php echo $row["username"]; ?></h2>
    </div>
    <div class="row">
      <div class="info"><h3 data-translate="followers">Followers</h3><span>100</span></div>
      <div class="info"><h3 data-translate="following">Following</h3><span>1000</span></div>
      <div class="info"><h3 data-translate="posts">Posts</h3><span>50</span></div>
    </div>
    <div class="buttons">
      <a href="#" onclick="openMessengerPopup()" class="btn" data-translate="message">Messanger</a>
      <a href="Settings/setting.php" class="btn" data-translate="settings">Settings</a>
      <a href="Logout/logout.php" class="btn" data-translate="logout">LogOut</a>
    </div>
  </div>
</section>

<div id="wrapper">
  <div class="head-text" data-translate="message">MESSENGER</div>

   <button id="closeMessenger" class="close-btn">X</button>

  <div class="search-user">
    <input type="text" id="searchInput" data-translate="search_user" placeholder="Search for user..." oninput="searchUser()">
  </div>
  <ul id="searchResults" class="user-list"></ul>

  <div class="chat-area" id="chatArea">
    <div class="system" data-translate="select_user_chat">Select a user to chat with</div>
  </div>

  <form class="message-form" onsubmit="sendMessage(event)">
    <input type="text" id="messageInput" data-translate="type_message" placeholder="Type your message..." required>
    <button type="submit" data-translate="send">📨 Send</button>
  </form>
</div>

<div class="modal" id="messengerModal">
  <div class="modal-content">
    <h3 data-translate="where_open_messenger">Where do you want to open Messenger?</h3>
    <div class="modal-buttons">
      <button onclick="openMessengerHere()" data-translate="open_here">Open Here</button>
      <button onclick="openMessengerNewTab()" data-translate="new_tab">New Tab</button>
    </div>
  </div>
</div>

<script src="profileMessenger.js" defer></script> 
<script src="backgroundTheme.js" defer></script> 
<script src="Language/language.js"></script>
</body>
</html>