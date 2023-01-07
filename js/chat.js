// all element selectors
const form = document.querySelector(".chat-area form"),
    submitBtn = document.querySelector(".chat-area .typing-area button"),
    hiddenInput = document.querySelectorAll(".chat-area form input[type='hidden']"),
    messageInput = document.querySelector(".chat-area form input[type='text']"),
    statusTag = document.querySelector(".chat-area .content .details p"),
    chat_box = document.querySelector(".chat-area .chat-box"),
    downBtn = document.querySelector(".chat-area p.down");

// function to scroll to the bottom of the chat
function scrollToBottom() {
    chat_box.scrollTo(0, chat_box.scrollHeight);
}


form.onsubmit = (e) => {
    e.preventDefault();
}

// send message
submitBtn.onclick = async (e) => {
    const formData = new FormData(form);
    let error = false;

    const fetchData = await fetch("./php/chat.php", {
        method: 'POST',
        body: formData
    })

    if (fetchData.status > 200) error = true;
    if (!error) {
        messageInput.value = "";
        chat_box.classList.remove("scrolled");
    }
}
// scroll down on down button 
downBtn.onclick = () => {
    scrollToBottom();
}

// hide and show scroll down button on scroll 
chat_box.onscroll = () => {
    let maxScrollHeight = chat_box.scrollHeight,
        currentScrollHeight = 620 + chat_box.scrollTop;
    chat_box.classList.add("scrolled")
    if (currentScrollHeight === maxScrollHeight) {
        downBtn.style.display = "none"
    } else {
        downBtn.style.display = "flex"
    }
}

// fetching chat messages every 4ms
setInterval(async () => {
    const fetchData = await fetch("./php/get_chat_msg.php", {
        method: 'POST',
        body: JSON.stringify({
            incoming_id: hiddenInput[0].value,
            outgoing_id: hiddenInput[1].value
        })
    })
    if (fetchData.status <= 200) {
        const data = await fetchData.json()
        console.log(data)
        chat_box.innerHTML = data.result;
        if (data.status === "online") {
            if (!statusTag.classList.contains("online")) {
                statusTag.classList.add("online");
                statusTag.innerHTML = "online";
            }
        } else {
            statusTag.classList.remove("online")
            statusTag.innerHTML = "offline"
        }
    }
    if (!chat_box.classList.contains("scrolled")) {
        scrollToBottom()
    }
}, 400)

