const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const confirmPasswordInput = form.querySelector('input[name="password2"]');

function markValidation(element, condition) {
    return !condition ? element.classList.add('invalid') : element.classList.remove('invalid');
}

function isEmailValid (email) {
    return /\S+@\S+\.\S/.test(email);
}

function doPasswordsMatch (password, password2) {
   return password === password2;
}

function validateEmail(){
    setTimeout(markValidation(emailInput, isEmailValid(emailInput.value)), 1000);
}
emailInput.addEventListener('keyup', validateEmail);

function validateConfirmPasword(){
    setTimeout(
        function (){
            const condition = doPasswordsMatch(confirmPasswordInput.previousElementSibling.value, confirmPasswordInput.value);
            markValidation(confirmPasswordInput, condition);
        },
        1000);
}
confirmPasswordInput.addEventListener('keyup', validateConfirmPasword);