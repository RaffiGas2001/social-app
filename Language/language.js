// Ստանում ենք էջի ուղին
const currentPath = window.location.pathname;

// Ստուգում ենք՝ էջը թղթապանակի մեջ է, թե ոչ
const isSubdirectory = currentPath.split('/').length > 3;

// Եթե թղթապանակի մեջ է, լեզվի ֆայլերը բերում ենք "../"-ով, եթե ոչ՝ ուղղակի "Language/"
const prefix = isSubdirectory ? "../" : "";

// Լեզվի ֆայլերի ուղիները ըստ ընտրած լեզվի
const languageFiles = {
  en: `${prefix}Language/en.json`,
  ru: `${prefix}Language/ru.json`,
  hy: `${prefix}Language/hy.json`
};

// Բեռնում է լեզվի json ֆայլը և թարգմանում էջը
function loadLanguage(language) {
  fetch(languageFiles[language])
      .then(response => response.json()) // json ֆայլը դարձնում ենք օբյեկտ
      .then(data => {
          translatePage(data);  // թարգմանում ենք էջը
      })
      .catch(error => console.error("Error loading language file:", error));
}

// Թարգմանում է էջը՝ data-translate ունեցող բոլոր էլեմենտների տեքստերը փոխելով
function translatePage(data) {
  const elements = document.querySelectorAll("[data-translate]"); 

  elements.forEach(element => {
    const key = element.getAttribute("data-translate");   // ստանում ենք թարգմանության բանալին
    if (data[key]) {
      if (element.tagName === "INPUT") {
        // եթե <input> է, դնում ենք placeholder կամ value
        if (element.hasAttribute("placeholder")) {
          element.placeholder = data[key];
        } else {
          element.value = data[key];
        }
      } else if (element.tagName === "BUTTON") {
        element.textContent = data[key];
      } else {
         // մյուս բոլոր տարրերի համար փոխում ենք տեքստը
        element.textContent = data[key];
      }
    }
  });
}

// Էջը բացվելիս ընտրում ենք պահված լեզուն (եթե չկա՝ անգլերեն), թարգմանում ենք
function initLanguage() {
  const language = localStorage.getItem("language") || "en"; // պահված լեզուն կամ 'en'
  loadLanguage(language);
  setLanguageSelector(language); // դնում ենք<select>-ի վրա էլի ճիշտ արժեքը
}

// Լեզու փոխելու ֆունկցիա՝ select-ից ընտրելիս
function changeLanguage(language) {
  localStorage.setItem("language", language); // պահում ենք ընտրած լեզուն
  loadLanguage(language);                     // թարգմանում ենք էջը
  setLanguageSelector(language);              // select-ում նշում ենք ճիշտ լեզուն
}

// Այս ֆունկցիան ընտրում է ճիշտ լեզուն<select>-ում
function setLanguageSelector(language) {
  const languageSelector = document.getElementById("language");
  languageSelector.value = language;
}

// Երբ select-ը փոխվում է՝ լեզուն փոխում ենք
document.getElementById("language").addEventListener("change", (e) => {
  changeLanguage(e.target.value);
});

// Էջը ամբողջությամբ բեռնված լինելուց հետո՝ թարգմանում ենք
document.addEventListener("DOMContentLoaded", initLanguage);