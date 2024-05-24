$(document).ready(function(){
    $('.faq-question').click(function() {
        $(this).next('.faq-answer').slideToggle();
        $('.faq-answer').not($(this).next()).slideUp();
    });
});