/* 
 * Ana Slider (Slayt) İşlemleri
 * Kahraman (Hero) bölümündeki resimlerin geçişlerini ve typing efektini kontrol eder.
 */

document.addEventListener('DOMContentLoaded', () => {
    // Slider elementlerini seç
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');

    let currentSlide = 0;
    const slideCount = slides.length;
    let slideInterval;

    // Slaytı gösteren fonksiyon
    function showSlide(index) {
        // Index sınırları aşarsa başa veya sona döndür
        if (index >= slideCount) currentSlide = 0;
        else if (index < 0) currentSlide = slideCount - 1;
        else currentSlide = index;

        // Tüm slaytları ve noktaları pasif yap
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        // Seçilen slaytı ve noktayı aktif yap
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }

    // Sonraki slayta geç
    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    // Önceki slayta geç
    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    // Otomatik geçiş başlat
    function startSlideShow() {
        slideInterval = setInterval(nextSlide, 5000); // 5 saniyede bir
    }

    // Otomatik geçişi durdur (Kullanıcı müdahale ettiğinde)
    function stopSlideShow() {
        clearInterval(slideInterval);
        startSlideShow(); // Sayacı sıfırla ve yeniden başlat
    }

    // Buton olaylarını dinle
    nextBtn.addEventListener('click', () => {
        nextSlide();
        stopSlideShow();
    });

    prevBtn.addEventListener('click', () => {
        prevSlide();
        stopSlideShow();
    });

    // Nokta (Dot) tıklamalarını dinle
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
            stopSlideShow();
        });
    });

    // Slider'ı başlat
    startSlideShow();

    // ---------------------------------------------------------------- //

    /* 
     * Yazı Yazma (Typing) Efekti
     * Sırasıyla kelimeleri yazar, biraz bekler ve siler.
     */

    const typingText = document.getElementById('typing-text');
    const words = ["DİZİ OYUNCULUĞU", "KLİP OYUNCULUĞU", "REKLAM YÜZÜ", "PRODÜKSİYON", "MENAJERLİK"];
    let wordIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    let isWaiting = false;

    function typeEffect() {
        const currentWord = words[wordIndex];

        if (isDeleting) {
            // Silme işlemi
            typingText.textContent = currentWord.substring(0, charIndex - 1);
            charIndex--;
        } else {
            // Yazma işlemi
            typingText.textContent = currentWord.substring(0, charIndex + 1);
            charIndex++;
        }

        let typeSpeed = 100; // Yazma hızı

        if (isDeleting) {
            typeSpeed = 50; // Silme hızı daha hızlı olsun
        }

        if (!isDeleting && charIndex === currentWord.length) {
            // Kelime bitti, bekle
            isWaiting = true;
            typeSpeed = 2000; // 2 saniye bekle
            isDeleting = true;
        } else if (isDeleting && charIndex === 0) {
            // Silme bitti, sonraki kelimeye geç
            isDeleting = false;
            wordIndex = (wordIndex + 1) % words.length;
            typeSpeed = 500; // Yeni kelimeye başlamadan önce biraz bekle
        }

        setTimeout(typeEffect, typeSpeed);
    }

    // Yazı efektini başlat
    setTimeout(typeEffect, 1000);
});
