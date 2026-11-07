// Ֆունկցիա, որը պատասխանատու է հաղորդագրություն ուղարկելու համար
function sendMessage(event) {
    event.preventDefault(); // Անհրաժեշտ է կանխել ֆորմայի ստանդարտ submit-ը
    
    const messageInput = document.getElementById("messageInput"); // Հաղորդագրության տեքստային դաշտը
    const message = messageInput.value.trim(); // Հեռացնում ենք ավելորդ բացատները աջ և ձախ կողմերից
    
    if (message) { // Եթե հաղորդագրությունը դատարկ չէ
        const messageContainer = document.createElement("div"); // Ստեղծում ենք նոր div տարր
        messageContainer.classList.add("message", "sent"); // Ավելացնում ենք css դասեր՝ ցույց տալու, որ հաղորդագրությունն ուղարկված է
        messageContainer.textContent = message; // Ներսը տեղադրում ենք հաղորդագրության տեքստը

        // Դեպքում ավելացնում ենք նոր հաղորդագրությունը հաղորդագրությունների տարածքին (chat area)
        document.getElementById("chatArea").appendChild(messageContainer);
        // Կատարում ենք մուտքային դաշտի դատարկում և ֆոկուսի վերադարձը
        messageInput.value = "";
        messageInput.focus();
    }
}

// Ֆունկցիա, որը բացում է զրույցը տվյալ օգտագործողի հետ
function openChat(user) {
    const chatArea = document.getElementById("chatArea");
    // Ապահովում ենք, որ զրույցի տարածքում կլինի նախնական ողջույնի հաղորդագրություն տվյալ օգտագործողին
    chatArea.innerHTML = `<div class="message received">Hello, ${user}!</div>`;
    // Որոնման արդյունքները դատարկում ենք, քանի որ զրույցը բացվեց
    document.getElementById("searchResults").innerHTML = "";
}

// Կապում ենք որոնման դաշտի փոփոխման իրադարձությունը, որը սկսում է օգտագործողների որոնումը
document.getElementById("searchInput").addEventListener("input", searchUser);

// Կապում ենք "փակել" կոճակի սեղմման իրադարձությունը՝ փակելու պատուհանը
document.getElementById("closeMessenger").addEventListener("click", function() {
    window.close();
});

// Ֆունկցիա՝ օգտագործողներ որոնելու համար ըստ մուտքագրված տեքստի
function searchUser() {
    const input = document.getElementById("searchInput").value.trim(); // Ստանում ենք մուտքագրված տեքստը
    const resultsContainer = document.getElementById("searchResults");
    resultsContainer.innerHTML = ""; // Ապահովում ենք, որ նախորդ որոնման արդյունքները մաքրվեն

    if (input !== "") { // Եթե տեքստը դատարկ չէ
        // Վարող fetch կանչ `messenger.php` սերվերին, փոխանցելով որոնման տերմինը
        fetch(`messenger.php?search=${encodeURIComponent(input)}`)
        .then(response => response.json()) // Վերադարձված JSON տվյալները վերածում ենք օբյեկտի
        .then(users => {
            // Ամեն օգտագործողի համար ստեղծում ենք ցուցակային տարր (li)
            users.forEach(user => {
                const li = document.createElement("li");
                // Հավելում ենք նկարը և անունը
                li.innerHTML = `
                    <img src="${user.image}" alt="${user.username}" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                    <strong>${user.username}</strong> (${user.name_surname})
                `;
                // Ստիլավորում ենք li տարրը
                li.style.display = "flex";
                li.style.alignItems = "center";
                li.style.gap = "10px";
                // Սեղմման ժամանակ բացում ենք զրույց տվյալ օգտվողի հետ
                li.addEventListener("click", () => openChat(user.username));
                // Ավելացնում ենք li-ն որոնման արդյունքների ցուցակին
                resultsContainer.appendChild(li);
            });
        })
        .catch(error => {
            console.error("Search error:", error);
        });
    }
}

// DOM Loaded իրադարձության ընթացքում կարգավորում ենք թեման՝ ըստ նախընտրած պարամետրերի
document.addEventListener("DOMContentLoaded", () => {
    // Վերցնում ենք նախորդից պահպանված թեման localStorage-ից, եթե չկա՝ օգտագործում "default"
    const theme = localStorage.getItem("selectedTheme") || "default";
    console.log("Messenger loaded theme:", theme);

    // Առանցքում ջնջում ենք բոլոր թեմաների դասերը
    document.body.classList.remove("default-mode", "light-mode", "dark-mode");
  
    // Ավելացնում ենք համապատասխան դասը ըստ ընտրված թեմայի
    if (theme === "light") {
      document.body.classList.add("light-mode");
    } else if (theme === "dark") {
      document.body.classList.add("dark-mode");
    } else {
      document.body.classList.add("default-mode");
    }
  });