
document.addEventListener('DOMContentLoaded', () => {
    const revealElements = document.querySelectorAll('.section-title, .section-subtitle, .service-card, .form-group, .form-submit-btn');

    function checkReveal() {
        const windowHeight = window.innerHeight;
        const revealPoint = 150;

        revealElements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;

            if (elementTop < windowHeight - revealPoint) {
                element.classList.add('reveal');
            }
        });
    }

    window.addEventListener('scroll', checkReveal);

    checkReveal();
});
