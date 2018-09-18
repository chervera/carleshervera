const menu = document.getElementById('main-menu');
const toggler = document.getElementById('toggle-nav');

function togglerNav() {
    console.log("togglerNav");
    toggler.classList.toggle('pressed');

    const target = document.getElementById(toggler.getAttribute('data-target'));
    if (target) {
        target.classList.toggle('opened');
    } else {
        console.error("No target found");
    }
}

toggler.addEventListener('click', togglerNav);
menu.addEventListener('click', togglerNav);