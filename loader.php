<!-- Loader Start -->
<div id="loader">
    <div class="loader-box">
        <div class="spinner"></div>
        <div class="loading-text">
            Loading
            <span class="dots">
                <span>.</span>
                <span>.</span>
                <span>.</span>
            </span>
        </div>
    </div>
</div>

<style>
#loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #ffffff;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

/* Center content */
.loader-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-family: Arial, sans-serif;
}

/* Smooth full circle */
.spinner {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: conic-gradient(
        #6366f1 0deg,
        #6366f1 120deg,
        #c7d2fe 240deg,
        #6366f1 360deg
    );
    animation: rotate 1.2s linear infinite;
    position: relative;
}

.spinner::before {
    content: "";
    position: absolute;
    top: 8px;
    left: 8px;
    right: 8px;
    bottom: 8px;
    background: #ffffff;
    border-radius: 50%;
}

@keyframes rotate {
    100% { transform: rotate(360deg); }
}

/* Loading text */
.loading-text {
    margin-top: 14px;
    font-size: 16px;
    color: #444;
    letter-spacing: 1px;
}

/* Dots wave animation */
.dots span {
    display: inline-block;
    animation: wave 1.2s infinite;
    font-weight: bold;
}

/* Delay each dot */
.dots span:nth-child(1) { animation-delay: 0s; }
.dots span:nth-child(2) { animation-delay: 0.2s; }
.dots span:nth-child(3) { animation-delay: 0.4s; }

@keyframes wave {
    0%, 60%, 100% {
        transform: translateY(0);
    }
    30% {
        transform: translateY(-6px);
    }
}
</style>
<script>
var loaderTimer;

// Initially hide loader
document.getElementById("loader").style.display = "none";

// Show loader only if page takes time (after 400ms)
loaderTimer = setTimeout(function () {
    var loader = document.getElementById("loader");
    if (loader) {
        loader.style.display = "flex";
    }
}, 400);

// When page fully loads
window.addEventListener("load", function () {
    clearTimeout(loaderTimer); // stop showing loader if fast

    var loader = document.getElementById("loader");
    if (loader) {
        loader.style.opacity = "0";
        loader.style.transition = "opacity 0.4s ease";
        setTimeout(function () {
            loader.style.display = "none";
        }, 400);
    }
});
</script>


<!-- Loader End -->
