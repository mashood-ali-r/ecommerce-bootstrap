{{-- Amazon-Style Top Loading Bar --}}
<div id="pageLoader" class="page-loader">
    <div class="loader-bar"></div>
</div>

<style>
    .page-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        z-index: 9999;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .page-loader.active {
        opacity: 1;
    }

    .loader-bar {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, #ff9900 0%, #febd69 50%, #ff9900 100%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite linear;
        box-shadow: 0 0 10px rgba(255, 153, 0, 0.5);
        transition: width 0.3s ease;
    }

    .page-loader.active .loader-bar {
        animation: loadProgress 2s ease-out forwards, shimmer 1.5s infinite linear;
    }

    .page-loader.complete .loader-bar {
        width: 100% !important;
        transition: width 0.2s ease;
    }

    @keyframes loadProgress {
        0% {
            width: 0%;
        }

        20% {
            width: 30%;
        }

        50% {
            width: 60%;
        }

        80% {
            width: 80%;
        }

        100% {
            width: 90%;
        }
    }

    @keyframes shimmer {
        0% {
            background-position: 200% 0;
        }

        100% {
            background-position: -200% 0;
        }
    }
</style>

<script>
    (function () {
        const loader = document.getElementById('pageLoader');
        let isNavigating = false;

        // Show loader for all link clicks (internal navigation)
        document.addEventListener('click', function (e) {
            const link = e.target.closest('a');
            if (link && link.href && !link.target && !link.hasAttribute('data-bs-toggle') && !e.defaultPrevented) {
                const url = new URL(link.href, window.location.origin);
                // Only show for same-origin navigation
                if (url.origin === window.location.origin && url.pathname !== window.location.pathname) {
                    isNavigating = true;
                    loader.classList.add('active');
                }
            }
        });

        // Show loader for form submissions
        document.addEventListener('submit', function (e) {
            const form = e.target;
            // Don't show for AJAX forms or search autocomplete
            if (!form.hasAttribute('data-no-loader')) {
                isNavigating = true;
                loader.classList.add('active');
            }
        });

        // Complete and hide on page load
        window.addEventListener('load', function () {
            if (loader.classList.contains('active')) {
                loader.classList.add('complete');
                setTimeout(() => {
                    loader.classList.remove('active', 'complete');
                }, 300);
            }
            isNavigating = false;
        });

        // Handle browser back/forward - using pageshow event instead of beforeunload
        window.addEventListener('pageshow', function (e) {
            // Page was restored from bfcache (back/forward navigation)
            if (e.persisted) {
                loader.classList.remove('active', 'complete');
            }
            isNavigating = false;
        });

        // Clean up on visibility change (handles edge cases)
        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'visible' && !isNavigating) {
                loader.classList.remove('active', 'complete');
            }
        });

        // Global functions for programmatic control
        window.showPageLoader = function () {
            loader.classList.add('active');
            loader.classList.remove('complete');
        };

        window.hidePageLoader = function () {
            loader.classList.add('complete');
            setTimeout(() => {
                loader.classList.remove('active', 'complete');
            }, 300);
        };
    })();
</script>