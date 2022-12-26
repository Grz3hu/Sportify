const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const phoneNumberInput = form.querySelector('input[name="phone_number"]');
const confirmPasswordInput = form.querySelector('input[name="password2"]');

function markValidation(element, condition) {
    return !condition ? element.classList.add('invalid') : element.classList.remove('invalid');
}

function isEmailValid (email) {
    return /\S+@\S+\.\S/.test(email);
}

function isPhoneNumberValid (phone_number) {
    return /^[0-9]{11}$/.test(phone_number);
}

function doPasswordsMatch (password, password2) {
   return password === password2;
}

function validateEmail(){
    setTimeout(markValidation(emailInput, isEmailValid(emailInput.value)), 1000);
}
emailInput.addEventListener('keyup', validateEmail);

function validatePhoneNumber(){
    setTimeout(markValidation(phoneNumberInput, isPhoneNumberValid(phoneNumberInput.value)), 1000);
}
phoneNumberInput.addEventListener('keyup', validatePhoneNumber);

function validateConfirmPassword(){
    setTimeout(
        function (){
            const condition = doPasswordsMatch(confirmPasswordInput.previousElementSibling.value, confirmPasswordInput.value);
            markValidation(confirmPasswordInput, condition);
        },
        1000);
}
confirmPasswordInput.addEventListener('keyup', validateConfirmPassword);