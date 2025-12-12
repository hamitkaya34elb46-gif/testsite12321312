
document.addEventListener('DOMContentLoaded', () => {
    const preloader = document.querySelector('.preloader');
    const loadingBar = document.getElementById('loading-bar');
    const loadingText = document.getElementById('loading-text');
    const loadingPercentage = document.getElementById('loading-percentage');
    const curtainTop = document.getElementById('curtain-top');
    const curtainBottom = document.getElementById('curtain-bottom');
    const mainContent = document.getElementById('main-content');
    const topBar = document.getElementById('top-bar');

    const messages = [
        "Işıklar ayarlanıyor...",
        "Kamera açıları kontrol ediliyor...",
        "Modeller hazırlanıyor...",
        "Sahne kuruluyor...",
        "Büyük açılış için geri sayım..."
    ];

    let progress = 0;
    let messageIndex = 0;

    const messageInterval = setInterval(() => {
        messageIndex = (messageIndex + 1) % messages.length;
        loadingText.style.opacity = 0;

        setTimeout(() => {
            loadingText.textContent = messages[messageIndex];
            loadingText.style.opacity = 1;
        }, 500);
    }, 2000);

    const interval = setInterval(() => {
        progress += Math.random() * 5;

        if (progress > 100) {
            progress = 100;
            clearInterval(interval);
            clearInterval(messageInterval);
            finishLoading();
        }

        loadingBar.style.width = `${progress}%`;
        loadingPercentage.textContent = `${Math.floor(progress)}%`;
    }, 150);

    function finishLoading() {
        setTimeout(() => {
            preloader.classList.add('hidden');

            curtainTop.classList.add('open');
            curtainBottom.classList.add('open');

            setTimeout(() => {
                mainContent.classList.add('visible');

                setTimeout(() => {
                    topBar.style.maxHeight = "50px";
                    topBar.style.opacity = "1";
                }, 800);

            }, 500);

        }, 800);
    }
});
