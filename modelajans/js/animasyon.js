/* 
 * Scroll (Kaydırma) Animasyonları
 * Sayfa aşağı kaydırıldıkça öğelerin (başlıklar, kartlar vb.) yavaşça görünmesini sağlar.
 */

document.addEventListener('DOMContentLoaded', () => {
    // Animasyonu izleyeceğimiz elemanları belirleyelim
    const revealElements = document.querySelectorAll('.section-title, .section-subtitle, .service-card, .form-group, .form-submit-btn');

    function checkReveal() {
        // Pencerenin yüksekliğini ve kırılma noktasını al
        const windowHeight = window.innerHeight;
        const revealPoint = 150; // Eleman ekranın 150px içine girdiğinde tetikle

        revealElements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;

            if (elementTop < windowHeight - revealPoint) {
                element.classList.add('reveal'); // Görünür yap
            }
        });
    }

    // Sayfa kaydırıldığında kontrol et
    window.addEventListener('scroll', checkReveal);

    // Yükleme sonrası başlangıç kontrolü (Sayfa ortasında yenilenirse diye)
    checkReveal();
});
