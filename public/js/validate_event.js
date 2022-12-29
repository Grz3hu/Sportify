const form = document.querySelector("form");
const dateInput = form.querySelector('input[name="date"]');

function markValidation(element, condition) {
    return !condition ? element.classList.add('invalid') : element.classList.remove('invalid');
}
function isDateFuture(date){
    let date_var = Date.parse(date)
    return date_var > Date.now();
}

function validateDate(){
    setTimeout(markValidation(dateInput, isDateFuture(dateInput.value)), 1000);
}
dateInput.addEventListener('keyup', validateDate);