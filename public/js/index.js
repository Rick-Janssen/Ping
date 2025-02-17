document.addEventListener("DOMContentLoaded", function(event) {
    var scrollpos = localStorage.getItem('scrollpos');
    if (scrollpos) window.scrollTo(0, scrollpos);
});

window.onbeforeunload = function(e) {
    localStorage.setItem('scrollpos', window.scrollY);
};
document.addEventListener('DOMContentLoaded', function() {
    var menu = document.querySelector('.menu');
    var menuToggle = document.querySelector('.menu-toggle');

    var isMenuOpen = localStorage.getItem('menuOpen') === 'true';

    menu.classList.toggle('show', isMenuOpen);

    menuToggle.addEventListener('click', function() {
        menu.classList.toggle('show');
        isMenuOpen = menu.classList.contains('show');
        localStorage.setItem('menuOpen', isMenuOpen);
    });

    var menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(function(item) {
        item.addEventListener('click', function() {
            menu.classList.remove('show');
            isMenuOpen = false;
            localStorage.setItem('menuOpen', isMenuOpen);
        });
    });
});

const dropdownButton = document.getElementById('account-dropdown');
const dropdownMenu = document.getElementById('account-dropdown-menu');

if(dropdownButton != null){
dropdownButton.addEventListener('click', (event) => {
    dropdownMenus.classList.toggle('hidden');
    event.stopPropagation();
});

document.addEventListener('click', (event) => {
    if (!dropdownMenu.contains(event.target) && event.target !== dropdownButton) {
        dropdownMenu.classList.add('hidden');
    }
});
}

document.querySelectorAll('#account-dropdown-menu a').forEach((item) => {
    item.addEventListener('click', () => {
        dropdownMenu.classList.add('hidden');
    });
});




