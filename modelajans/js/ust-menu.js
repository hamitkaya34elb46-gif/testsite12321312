/* 
 * Üst Menü İşlemleri
 * Menünün scroll (kaydırma) sırasındaki değişimi ve mobil menü açma/kapama işleri.
 */

document.addEventListener('DOMContentLoaded', () => {
    const headerWrapper = document.getElementById('header-wrapper');
    const topBar = document.getElementById('top-bar');
    const mobileMenuBtn = document.getElementById('mobile-menu');
    const navMenu = document.querySelector('.nav-menu');
    const navLinks = document.querySelectorAll('.nav-link');

    // Scroll (Kaydırma) Olayı
    window.addEventListener('scroll', () => {
        // Eğer kullanıcı 50px'den fazla aşağı indiyse
        if (window.scrollY > 50) {
            headerWrapper.classList.add('scrolled');
            topBar.classList.add('hidden'); // Üst barı gizle
        } else {
            headerWrapper.classList.remove('scrolled');
            topBar.classList.remove('hidden'); // Üst barı geri getir
        }
    });

    // Mobil Menü Açma/Kapama
    mobileMenuBtn.addEventListener('click', () => {
        navMenu.classList.toggle('active'); // Menüyü aç/kapa
        mobileMenuBtn.classList.toggle('active'); // Buton ikonunu değiştir
    });

    // Linke tıklandığında menüyü kapat (Mobil için pratik)
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
            mobileMenuBtn.classList.remove('active');
        });
    });

    // Menü açıkken dışarı tıklanırsa kapatalım
    document.addEventListener('click', (e) => {
        if (!navMenu.contains(e.target) && !mobileMenuBtn.contains(e.target) && navMenu.classList.contains('active')) {
            navMenu.classList.remove('active');
            mobileMenuBtn.classList.remove('active');
        }
    });
});
