// Երբ էջը ամբողջությամբ բեռնվում է
document.addEventListener("DOMContentLoaded", () => {
    // localStorage-ից ստանում ենք պահված թեման, եթե չկա՝ վերցնում ենք "default"
    const theme = localStorage.getItem("selectedTheme") || "default";
    console.log("Messenger loaded theme:", theme); // Տպում ենք կոնսոլում՝ տեսնելու համար որ թեման է բեռնվել

    // Հանում ենք հնարավոր թեմաների դասերը, որ չխանգարեն նորին
    document.body.classList.remove("default-mode", "light-mode", "dark-mode");
  
    // Ըստ ստացված թեմայի՝ ավելացնում ենք համապատասխան դասը body-ին
    if (theme === "light") {
      document.body.classList.add("light-mode");
    } else if (theme === "dark") {
      document.body.classList.add("dark-mode");
    } else {
      document.body.classList.add("default-mode");
    }
  });