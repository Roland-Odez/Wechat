hidePassword.addEventListener('click', () => {
    const password = document.querySelector('.password');
    if (password.getAttribute('type') === "password") {
        password.setAttribute('type', 'text');
        hidePassword.classList.remove('fa-eye')
        hidePassword.classList.add('fa-eye-slash')
    } else {
        password.setAttribute('type', 'password');
        hidePassword.classList.remove('fa-eye-slash')
        hidePassword.classList.add('fa-eye')
    }
})