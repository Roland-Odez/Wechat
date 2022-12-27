
const hidePassword = document.querySelector('.hide-password'),
    form = document.querySelector(".signup form"),
    continueBtn = document.querySelector(".button input"),
    errorText = document.querySelector(".error-txt");


form.onsubmit = (e) => {
    e.preventDefault();

}

continueBtn.onclick = async (e) => {
    const formData = new FormData(form)
    let error = false;

    const fetchData = await fetch("./php/signup.php", {
        method: 'POST',
        body: formData
    })
    if (fetchData.status > 200) error = true
    const data = await fetchData.json()
    if (error) {
        errorText.innerHTML = data.result
        errorText.style.visibility = "visible"
        error = false;
        setTimeout(() => {
            errorText.style.visibility = "hidden"
        }, 5000)
    } else {
        location.href = "users.php";
    }

}