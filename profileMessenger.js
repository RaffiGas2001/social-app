// Ընտրված օգտատեր չկա սկզբում
let selectedUser = null;
// Էլեմենտների զրուցաչաթի պատմությունը պահելու օբյեկտ
let chatHistory = {};

// Ցուցադրել կամ թաքցնել մեսենջերի պատյանը
function messenger() {
  const wrap = document.getElementById("wrapper");
  wrap.style.display = wrap.style.display === "block" ? "none" : "block";
}

// Բացել մեսենջերը մոդալ պատուհանում
function openMessengerPopup() {
  document.getElementById("messengerModal").style.display = "flex";
}

// Բացել մեսենջերը նույն էջում
function openMessengerHere() {
  document.getElementById("messengerModal").style.display = "none";
  messenger();
}

// Բացել մեսենջերը նոր թաբում
function openMessengerNewTab() {
  window.open("Messenger/messenger.php", "_blank");
  document.getElementById("messengerModal").style.display = "none";
}

// Եթե սեղմել են մոդալից դուրս, փակել մոդալ պատուհանը
window.onclick = function(event) {
  const modal = document.getElementById("messengerModal");
  if (event.target === modal) {
    modal.style.display = "none";
  }
}

// Որոնել օգտատերերին ըստ մուտքագրված տեքստի
function searchUser() {
  const query = document.getElementById('searchInput').value.toLowerCase();
  const resultBox = document.getElementById('searchResults');

  console.log("Search query: " + query);

  // XHR հարցում ուղարկել index.php ֆայլին `search` պարբերակով
  const xhr = new XMLHttpRequest();
  xhr.open("GET", `index.php?search=${encodeURIComponent(query)}`, true);
  xhr.onload = function() {
    if (xhr.status === 200) {
      console.log(xhr.responseText);
      try {
        // Ստանալ JSON պատասխանն ու վերածել օբյեկտի
        const users = JSON.parse(xhr.responseText);
        const resultBox = document.getElementById('searchResults');
        resultBox.innerHTML = ""; // Մաքրել արդյունքների ցուցակը
        // Չափնջել յուրաքանչյուր օգտատիրոջ վրա
        users.forEach(user => {
          const li = document.createElement('li');
          li.textContent = `${user.name_surname} (${user.username})`;
          // Քլիք դեպքում ընտրել այս օգտատիրոջ ID–ն ու username–ը
          li.onclick = () => selectUser(user.id, user.username);
          resultBox.appendChild(li);
        });
      } catch (e) {
        console.error("Error parsing JSON:", e);
      }
    }
  };
  xhr.send(); // Ուղարկել հարցումը
}

// Ընկեր ընտրելու ֆունկցիա՝ բացում է զրուցափողը այդ օգտագործողի հետ
function selectUser(id, username) {
  selectedUser = id; // Պահպանել ընտրված օգտատիրոջ ID–ն
  const chatArea = document.getElementById("chatArea");
  chatArea.innerHTML = ""; // Մաքրել նախորդ զրույցները

  // Սարքավորել համակարգային հաղորդագրություն, որ զրուցում ենք username–ի հետ
  const header = document.createElement("div");
  header.className = "system";
  header.textContent = `Նամակ ${username}-ին`;
  chatArea.appendChild(header);

  // Եթե կան նախորդ հաղորդագրություններ, ցուցադրել դրանք
  if (chatHistory[id]) {
    chatHistory[id].forEach(msg => {
      appendMessage(msg.text, msg.type);
    });
  }
}

// Զրուցափողի հաղորդագրություն ավելացնելու ֆունկցիա
function appendMessage(message, type) {
  const chatArea = document.getElementById("chatArea");
  const messageDiv = document.createElement("div");

  // Ուղարկված («sent») կամ ստացված («received») կարգավիճակով կոճակ
  messageDiv.className = `message ${type}`;
  messageDiv.textContent = message;
  chatArea.appendChild(messageDiv);

    // Ավազելու դեպքում ավտոմատ սքրոլ անել վերջին հաղորդագրության վրա
  chatArea.scrollTop = chatArea.scrollHeight;
}

// Հաղորդագրություն ուղարկելու ֆունկցիա
function sendMessage(event) {
  event.preventDefault();

  // Եթե չէ ընտրված օգտատեր, զգուշացնել
  if (!selectedUser) {
    alert("Նախ ընտրեք օգտատեր");
    return;
  }

  const messageInput = document.getElementById("messageInput");
  const message = messageInput.value.trim();
  if (message === "") return; // Եթե հաղորդագրությունն դատարկ է՝ ոչինչ չանել

  // Ստեղծել նոր զանգված, եթե դեռ չկայ պատմություն
  if (!chatHistory[selectedUser]) {
    chatHistory[selectedUser] = [];
  }

  // Պահպանել ուղարկված հաղորդագրությունը պատմությունում
  chatHistory[selectedUser].push({ text: message, type: "sent" });
  appendMessage(message, "sent");
  messageInput.value = "";
}

// Կապել "փակել մեսենջերը" կոճակը՝ թաքցնելու ամբողջ պատյանը
document.getElementById("closeMessenger").addEventListener("click", function() {
  document.getElementById("wrapper").style.display = "none";
});