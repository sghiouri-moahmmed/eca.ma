console.log("This is written from JavaScript");

var nav = document.querySelector('nav'); // Identify target

window.addEventListener('scroll', function(event) { // To listen for event
    event.preventDefault();

    if (window.scrollY <= 150) { // Just an example
        nav.style.backgroundColor = 'white'; // or default color
    } else {
        nav.style.backgroundColor = 'transparent';
    }
});

