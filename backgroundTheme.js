// Թեմայի փոփոխման ֆունկցիա
function changeTheme(mode) {
  // Սկզբում հեռացնում ենք բոլոր հնարավոր թեմաները
  document.body.classList.remove("default-mode", "light-mode", "dark-mode");

  // Ըստ ընտրված թեմայի՝ ավելացնում ենք համապատասխան դասը body-ին
  if (mode === "light") {
    document.body.classList.add("light-mode");
  } else if (mode === "dark") {
    document.body.classList.add("dark-mode");
  } else {
    document.body.classList.add("default-mode");
  }

  // Պահպանում ենք ընտրած թեման՝ որպեսզի հաջորդ այցելության ժամանակ հիշվի
  localStorage.setItem("selectedTheme", mode);
}

// Երբ էջը բեռնվում է
window.onload = function () {
  // Ստանում ենք պահված թեման կամ սահմանում ենք լռելյայն՝ "default"
  const savedTheme = localStorage.getItem("selectedTheme") || "default";

  // Կիրառում ենք այդ թեման
  document.getElementById("theme").value = savedTheme;
  changeTheme(savedTheme);
};