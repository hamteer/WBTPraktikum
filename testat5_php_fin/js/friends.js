function selectChat(username) {
    const li = document.getElementById("chatList");
    const form = document.createElement("form");
    form.setAttribute("action", "chat.php");
    form.setAttribute("method", "get");
    const input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("value", username);
    input.setAttribute("name", "chatpartner");
    form.appendChild(input);
    li.appendChild(form);
    form.submit();
}

function updateWindow() {
    const li = document.getElementById("chatList");
    const form = document.createElement("form");
    form.setAttribute("action", "friends.php");
    form.setAttribute("method", "post");
    li.appendChild(form);
    form.submit();
}

window.setInterval(updateWindow, 5000);