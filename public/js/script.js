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

// Quand le DOM est ready alors je crée une function :
$(document).ready(function() {
    // Qui crée un événement sur le click de la div ".question_faq"
    $('.question_faq').click(function() {
        // Qui va récupéré le parent de .question_faq (this) et slideToggle .answer_faq
        $(this).parent('.faq').find('.answer_faq').slideToggle('slow');
        $(this).find('.fa-chevron-down').toggleClass('active_faq');
    });
});