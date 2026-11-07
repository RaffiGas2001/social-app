// let swiper = new Swiper(".mySwiper", {
//     slidesPerView: 1,
//     loop: true,
//     pagination: {
//       el: ".swiper-pagination",
//       clickable: true,
//     },
//     navigation: {
//       nextEl: ".swiper-button-next",
//       prevEl: ".swiper-button-prev",
//     },
// });

// Ստեղծում ենք նոր Swiper սլայդեր օբյեկտ՝ որը կապված է .mySwiper class-ով տարրին
let swiper = new Swiper(".mySwiper", {
  // Ցուցադրվող սլայդների քանակը միաժամանակ (միաժամանակ ցույց է տալիս միայն 1 սլայդ)
  slidesPerView: 1,
  // Ակտիվացնում ենք անվերջ կրկնություն (loop) — երբ հասնում ես վերջին սլայդին, հաջորդը դառնում է առաջինը
  loop: true,
  // Սահմանում ենք սլայդների էջանշման կետերը (pagination)
  pagination: {
    el: ".swiper-pagination", // Սլայդների pagination-ը կցվում է այս class ունեցող տարրին
    clickable: true,          // Օգտագործողը կարող է սեղմել էջանիշների վրա՝ փոխելու սլայդը
  },
  // Սահմանում ենք նավիգացիոն կոճակները (առաջ / հետ)
  navigation: {
    nextEl: ".swiper-button-next", // "Հաջորդ" սլայդի կոճակ
    prevEl: ".swiper-button-prev", // "Նախորդ" սլայդի կոճակ
  },
});