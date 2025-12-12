/* 
 * Sayfa Yükleme Animasyonları
 * Sitenin açılışındaki logo animasyonu, yükleme barı ve perde efekti burada.
 */

document.addEventListener('DOMContentLoaded', () => {
    // Gerekli elemanları seçelim
    const preloader = document.querySelector('.preloader');
    const loadingBar = document.getElementById('loading-bar');
    const loadingText = document.getElementById('loading-text');
    const loadingPercentage = document.getElementById('loading-percentage');
    const curtainTop = document.getElementById('curtain-top');
    const curtainBottom = document.getElementById('curtain-bottom');
    const mainContent = document.getElementById('main-content');
    const topBar = document.getElementById('top-bar');

    // Kullanıcıya göstereceğimiz mesajlar
    const messages = [
        "Işıklar ayarlanıyor...",
        "Kamera açıları kontrol ediliyor...",
        "Modeller hazırlanıyor...",
        "Sahne kuruluyor...",
        "Büyük açılış için geri sayım..."
    ];

    let progress = 0;
    let messageIndex = 0;

    // Mesaj değişimini ayarlayalım
    const messageInterval = setInterval(() => {
        messageIndex = (messageIndex + 1) % messages.length;
        // Yumuşak geçiş için önce opaklığı sıfırlıyoruz
        loadingText.style.opacity = 0;

        setTimeout(() => {
            loadingText.textContent = messages[messageIndex];
            loadingText.style.opacity = 1;
        }, 500);
    }, 2000);

    // Yükleme çubuğunu simüle edelim
    const interval = setInterval(() => {
        // Rastgele artış miktarı ile daha doğal bir yükleme hissi verelim
        progress += Math.random() * 5;

        if (progress > 100) {
            progress = 100;
            clearInterval(interval);
            clearInterval(messageInterval);
            finishLoading(); // Yükleme bitti, sahneye geçelim
        }

        // Değerleri güncelleyelim
        loadingBar.style.width = `${progress}%`;
        loadingPercentage.textContent = `${Math.floor(progress)}%`;
    }, 150); // Her 150ms'de bir artır

    function finishLoading() {
        setTimeout(() => {
            // Yükleme ekranını gizle
            preloader.classList.add('hidden');

            // Perdeleri aç
            curtainTop.classList.add('open');
            curtainBottom.classList.add('open');

            // Ana içeriği göster
            setTimeout(() => {
                mainContent.classList.add('visible');

                // Üst bar animasyonu
                setTimeout(() => {
                    topBar.style.maxHeight = "50px";
                    topBar.style.opacity = "1";
                }, 800);

            }, 500);

        }, 800);
    }
});
