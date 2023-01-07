// queried element for login
const hidePassword = document.querySelector('.hide-password'),
    form = document.querySelector(".login form"),
    continueBtn = document.querySelector(".button input"),
    errorText = document.querySelector(".error-txt");

form.onsubmit = (e) => {
    e.preventDefault();

}

// sending login details 
continueBtn.onclick = async (e) => {
    const formData = new FormData(form)
    let error = false;

    const fetchData = await fetch("./php/login.php", {
        method: 'POST',
        body: formData
    })
    if (fetchData.status > 200) error = true
    const data = await fetchData.json()
    if (error) {
        errorText.style.visibility = "visible"
        errorText.innerHTML = data.result
        error = false;
        setTimeout(() => {
            errorText.style.visibility = "hidden"
        }, 5000)
    } else {
        location.href = "users.php";
    }

}