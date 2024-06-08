// .password .password-toggle

document.addEventListener("DOMContentLoaded", function() {
    const password = document.getElementById("password");
    const passwordToggle = document.getElementById("password-toggle");
    const eye = document.querySelector('#password-toggle > i')
    console.log(password)

    if (password && passwordToggle) {
        passwordToggle.addEventListener("click", function() {
            console.log('asd')
            if (password.type === "password") {
                password.type = "text";

                // change eye icon
                eye.classList.remove("fa-eye");
                eye.classList.add("fa-eye-slash");
            } else {
                password.type = "password";

                // change eye icon
                eye.classList.remove("fa-eye-slash");
                eye.classList.add("fa-eye");
            }
        });
    }
})
