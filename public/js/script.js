const menu = document.querySelector(".menu");
const openMenuBtn = document.querySelector(".open-menu-btn");
const closeMenuBtn = document.querySelector(".close-menu-btn");

[openMenuBtn, closeMenuBtn].forEach((btn) => {
    btn.addEventListener("click", () => {
        menu.classList.toggle("open");
        menu.style.transition = "transform 0.5s ease";
    });
});

menu.querySelector('.dropdown > i').addEventListener("click", function() {
    this.closest(".dropdown").classList.toggle("activeMenu");
})

window.addEventListener('scroll', function() {
    var navbar = document.querySelector('.header');
    if (window.scrollY > 10) { // Ajuste la valeur pour la hauteur souhaitée
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

document.addEventListener('DOMContentLoaded', (event) => {
    // Initialisation de la carte avec les coordonnées de Strasbourg
    var map = L.map('map').setView([48.77696460348389, 7.086264763727594], 14);
    var marker = L.marker([48.77696460348389, 7.086264763727594]).addTo(map);
    marker.bindPopup("NESS PRIMEUR - 30 rue de Sarraltroff 57400 HILBESHEIM").openPopup();

    // Ajout de la couche de tuiles OpenStreetMap
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Vérifie si les tuiles sont chargées
    map.on('tileerror', function(error, tile) {
        console.error('Tile loading error', error, tile);
    });
});


// Quand le DOM est ready alors je crée une function :
$(document).ready(function() {
    // Qui crée un événement sur le click de la div ".question_faq"
    $('.question_faq').click(function() {
        // Qui va récupéré le parent de .question_faq (this) et slideToggle .answer_faq
        $(this).parent('.faq').find('.answer_faq').slideToggle('slow');
        $(this).find('.fa-chevron-down').toggleClass('active_faq');
    });
});