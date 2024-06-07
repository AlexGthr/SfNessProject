// document.getElementById('burger-menu').addEventListener('click', () => {
//     document.getElementById('nav-links').classList.toggle('active');
// });

// Quand le DOM est ready alors je crée une function :
$(document).ready(function() {
    // Qui crée un événement sur le click de la div ".question_faq"
    $('.question_faq').click(function() {
        // Qui va récupéré le parent de .question_faq (this) et slideToggle .answer_faq
        $(this).parent('.faq').find('.answer_faq').slideToggle('slow');
    });
});