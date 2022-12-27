
const form = document.querySelector(".chat-area form"),
    submitBtn = document.querySelector(".chat-area .typing-area button"),
    hiddenInput = document.querySelectorAll(".chat-area form input[type='hidden']"),
    messageInput = document.querySelector(".chat-area form input[type='text']"),
    statusTag = document.querySelector(".chat-area .content .details p");

form.onsubmit = (e) => {
    e.preventDefault();

}

submitBtn.onclick = async (e) => {
    const formData = new FormData(form)
    let error = false;

    const fetchData = await fetch("./php/chat.php", {
        method: 'POST',
        body: formData
    })
    if (fetchData.status > 200) error = true;
    if (!error) {
        messageInput.value = "";
    }
}

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
}, 400)

