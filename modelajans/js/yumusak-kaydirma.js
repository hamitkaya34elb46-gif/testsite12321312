/* 
 * Yumuşak Kaydırma (Smooth Scroll)
 * Menü linklerine tıklandığında ilgili bölüme animasyonlu bir şekilde gitmeyi sağlar.
 */

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault(); // Varsayılan zıplamayı engelle

        const targetId = this.getAttribute('href');
        if (targetId === '#') return; // Boş linkse işlem yapma

        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            // Hedefin pozisyonunu al
            const headerOffset = 80; // Üst menü yüksekliği kadar boşluk bırak
            const elementPosition = targetElement.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

            // Kaydır
            window.scrollTo({
                top: offsetPosition,
                behavior: "smooth"
            });
        }
    });
});

/* 
 * Aşağı Ok Butonu
 * Hero bölümündeki oka tıklayınca bir sonraki bölüme kaydır.
 */
const heroArrow = document.querySelector('.hero-arrow-down');
if (heroArrow) {
    heroArrow.addEventListener('click', () => {
        const firstSection = document.querySelector('section:nth-of-type(2)'); // Hero'dan sonraki ilk bölüm
        if (firstSection) {
            const headerOffset = 80;
            const elementPosition = firstSection.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: "smooth"
            });
        }
    });
}
