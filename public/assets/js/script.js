// simple example
console.log("JavaScript is loaded :D");


// Press enter to submit form
const form = document.querySelector('form');

form.addEventListener('keypress', function (event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        form.submit();
    }
});