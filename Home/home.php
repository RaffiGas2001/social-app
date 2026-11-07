<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title data-translate="website_title">Website Image Slider</title>
  <!-- Միացնում ենք Swiper.js գրադարանի CSS ֆայլը -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <!-- Միացնում ենք մեր սեփական CSS ձևավորումը -->
  <link rel="stylesheet" href="home.css" />
  <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
  <!-- Միացնում ենք Swiper.js-ի JavaScript գրադարանը -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>
<body>
  <div id="language-selector" style="text-align: right; padding: 10px;">
    <select id="language" onchange="changeLanguage(this.value)">
      <option value="en">English</option>
      <option value="hy">Հայերեն</option>
      <option value="ru">Русский</option>
    </select>
  </div>
  <!-- Գլխավոր սլայդային բաժինը՝ swiper գրադարանի միջոցով -->
  <section class="main swiper mySwiper">
    <!-- Wrapper՝ ներառում է բոլոր սլայդները -->
    <div class="wrapper swiper-wrapper">
       <!-- Առաջին սլայդ՝ ողջույններ և ներկայացում -->
      <div class="slide swiper-slide" style="background-color: black">
        <!-- <img src="../Images/profile.jpg" alt="" class="image" /> -->
        <div class="image-data">
          <span class="text" data-translate="welcome_new" >
            New here? Welcome to our community!
          </span><br>
          <span class="text" data-translate="join_us">
            Join us today and create your profile in just a few steps.
          </span><br>
          <span class="text" data-translate="discover">
            Our platform is open for you – discover new connections, conversations, and opportunities.
          </span>
          <hr>
          <br>
          <span class="text" data-translate="welcome_back">
            Back again? Great to see you!
          </span><br>
          <span class="text" data-translate="login_continue">
            Log in to your account to continue connecting, update your profile, or just be part of the community.
          </span>
        </div>
      </div>
      <!-- Երկրորդ սլայդ՝ գրանցման կոճակով -->
      <div class="slide swiper-slide" style="background-color: black">
        <div class="image-data">
          <h2 data-translate="registration">REGISTRATION</h2>
          <a href="../Registration/registration.php" class="button" data-translate="create_account">Create a new account</a>
        </div>
      </div>
      <!-- Երրորդ սլայդ՝ մուտքի կոճակով -->
      <div class="slide swiper-slide" style="background-color: black">
        <div class="image-data">
          <h2 data-translate="login">LOG IN</h2>
          <a href="../Login/login.php" class="button" data-translate="access_account">Access your account</a>
        </div>
      </div>
    </div>
    <!-- Սլայդների նավիգացիոն կոճակներ (առաջ/հետ) -->
    <div class="swiper-button-next nav-btn"></div>
    <div class="swiper-button-prev nav-btn"></div>
    <!-- Սլայդների էջանշման կետեր (pagination) -->
    <div class="swiper-pagination"></div>
  </section>

  <script src="home.js"></script>
  <script src="../Language/language.js"></script>
</body>
</html>