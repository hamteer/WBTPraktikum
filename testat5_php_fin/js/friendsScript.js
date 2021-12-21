window.onload = function() {
    const input = document.getElementById("addFriendFeld");
    setCaretPosition(input, input.value.length);
};

// set focus and position of the input
function setCaretPosition(ctrl, pos) {
  // Modern browsers
  if (ctrl.setSelectionRange) {
    ctrl.focus();
    ctrl.setSelectionRange(pos, pos);
  }
}

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
    //create safe of input because updating window delets the input
    const input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", "curInput");
    // get current Input
    const curInput = document.getElementById("addFriendFeld");
    input.setAttribute("value", curInput.value);

    const form = document.createElement("form");
    form.setAttribute("action", "friends.php");
    form.setAttribute("method", "post");
    form.appendChild(input);
    li.appendChild(form);
    form.submit();
}

window.setInterval(updateWindow, 5000);