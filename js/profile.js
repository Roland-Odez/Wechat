const pen = document.querySelectorAll(".input-field span.icon"),
    form = document.querySelector(".profile form"),
    wrapper = document.querySelector(".wrapper"),
    inputs = document.querySelectorAll(".input-field input");
pen.forEach((p) => {
    p.addEventListener("click", (e) => {
        document.querySelector(".profile form .update").style.visibility = "visible"
        switch (e.target.title) {
            case "name":
                inputs[1].readOnly = false
                inputs[2].readOnly = true;
                inputs[1].focus();
                console.log("aname", inputs[1].readOnly)
                break;
            case "about":
                inputs[2].readOnly = false;
                inputs[1].readOnly = true;
                inputs[2].focus();
                console.log("abiout", inputs[2].name)
                break;

            default:
                break;
        }
    })
})

form.onsubmit = async (e) => {
    e.preventDefault()
    const formData = new FormData(form);

    const fetchData = await fetch("./php/update_profile.php", {
        method: 'POST',
        body: formData
    })
    if (fetchData.status == 200) {
        wrapper.classList.add("success");
        document.querySelector(".profile form .update").style.visibility = "hidden"
        document.querySelector("input:read-write").readOnly = true

    } else {
        wrapper.classList.add("error")
    }
    setTimeout(() => {
        if (wrapper.classList.contains("success")) {
            wrapper.classList.remove("success")
        } else if (wrapper.classList.contains("error")) {
            wrapper.classList.remove("error")
        }
    }, 3000)
}