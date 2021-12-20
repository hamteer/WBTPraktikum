function removeFriend(chatpartner) {
    const div = document.getElementById("profile");
    const form = document.createElement("form");
    form.setAttribute("action", "friends.php");
    form.setAttribute("method", "post");
    const input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("value", chatpartner);
    input.setAttribute("name", "friendRemoved");
    form.appendChild(input);
    div.appendChild(form);
    form.submit();
}