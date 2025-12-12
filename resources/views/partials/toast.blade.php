<!-- Elegant Toast Notification Container -->
<div id="toastContainer"
    style="position: fixed; top: 24px; right: 24px; z-index: 100000; display: flex; flex-direction: column; gap: 16px; pointer-events: none;">
</div>

<style>
    .premium-toast {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 16px;
        box-shadow:
            0 4px 6px -1px rgba(0, 0, 0, 0.05),
            0 10px 15px -3px rgba(0, 0, 0, 0.05),
            0 20px 40px -4px rgba(0, 0, 0, 0.08);
        /* Deep, soft shadow */
        padding: 16px;
        width: 380px;
        max-width: calc(100vw - 48px);
        pointer-events: auto;
        transform-origin: top right;
        animation: toastEnter 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
        display: flex;
        gap: 16px;
        position: relative;
        overflow: hidden;
    }

    .premium-toast.hiding {
        animation: toastExit 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    /* Accent Line */
    .premium-toast::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #0F1111;
        /* Default dark accent */
    }

    .premium-toast.success::before {
        background: #10B981;
    }

    /* Emerald */
    .premium-toast.warning::before {
        background: #F59E0B;
    }

    /* Amber */
    .premium-toast.error::before {
        background: #EF4444;
    }

    /* Red */
    .premium-toast.info::before {
        background: #3B82F6;
    }

    /* Blue */

    /* Image Container */
    .toast-image-wrapper {
        width: 56px;
        height: 56px;
        flex-shrink: 0;
        border-radius: 12px;
        background: #F8FAFC;
        border: 1px solid rgba(0, 0, 0, 0.03);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .toast-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 4px;
        transition: transform 0.3s ease;
    }

    .premium-toast:hover .toast-image {
        transform: scale(1.05);
    }

    /* Icon Fallback */
    .toast-icon-wrapper {
        width: 56px;
        height: 56px;
        flex-shrink: 0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .premium-toast.success .toast-icon-wrapper {
        background: rgba(16, 185, 129, 0.1);
        color: #10B981;
    }

    .premium-toast.warning .toast-icon-wrapper {
        background: rgba(245, 158, 11, 0.1);
        color: #F59E0B;
    }

    .premium-toast.error .toast-icon-wrapper {
        background: rgba(239, 68, 68, 0.1);
        color: #EF4444;
    }

    /* Content */
    .toast-content {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .toast-title {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        font-weight: 600;
        font-size: 15px;
        color: #0F172A;
        margin-bottom: 2px;
        line-height: 1.4;
    }

    .toast-message {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        font-size: 14px;
        color: #64748B;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Action Link */
    .toast-action {
        display: inline-flex;
        align-items: center;
        margin-top: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #0F172A;
        text-decoration: none;
        transition: all 0.2s;
        width: fit-content;
    }

    .toast-action i {
        font-size: 10px;
        margin-left: 4px;
        transition: transform 0.2s;
    }

    .toast-action:hover {
        color: #4F46E5;
        /* Indigo accent on hover */
    }

    .toast-action:hover i {
        transform: translateX(4px);
    }

    /* Close Button */
    .toast-close {
        position: absolute;
        top: 12px;
        right: 12px;
        background: transparent;
        border: none;
        color: #94A3B8;
        cursor: pointer;
        padding: 4px;
        border-radius: 50%;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .toast-close:hover {
        background: rgba(0, 0, 0, 0.04);
        color: #475569;
    }

    @keyframes toastEnter {
        0% {
            opacity: 0;
            transform: translateX(20px) scale(0.95);
        }

        100% {
            opacity: 1;
            transform: translateX(0) scale(1);
        }
    }

    @keyframes toastExit {
        0% {
            opacity: 1;
            transform: translateX(0) scale(1);
        }

        100% {
            opacity: 0;
            transform: translateX(20px) scale(0.95);
        }
    }
</style>

<script>
    window.showEezepcToast = function (options) {
        // Support legacy calls
        const opts = typeof options === 'string' ? { title: options } : options;

        const {
            type = 'success',
            title = 'Notification',
            message = '',
            image = '',
            duration = 5000,
            actionUrl = '',
            actionText = 'View'
        } = opts;

        const container = document.getElementById('toastContainer');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = `premium-toast ${type}`;

        // Icon mapping for fallback
        const icons = {
            success: 'fa-check',
            warning: 'fa-exclamation',
            error: 'fa-times',
            info: 'fa-info'
        };

        // Determine if this is a Wishlist action to show specific link
        const isWishlist = title.toLowerCase().includes('wishlist') && type === 'success';
        const finalActionUrl = isWishlist ? '/wishlist' : actionUrl;
        const finalActionText = isWishlist ? 'View Wishlist' : actionText;

        const mediaHtml = image
            ? `<div class="toast-image-wrapper"><img src="${image}" class="toast-image" alt="Product"></div>`
            : `<div class="toast-icon-wrapper"><i class="fas ${icons[type]}"></i></div>`;

        toast.innerHTML = `
            ${mediaHtml}
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                ${message ? `<div class="toast-message">${message}</div>` : ''}
                ${finalActionUrl ? `
                    <a href="${finalActionUrl}" class="toast-action">
                        ${finalActionText} <i class="fas fa-arrow-right"></i>
                    </a>
                ` : ''}
            </div>
            <button class="toast-close" onclick="closePremiumToast(this)">
                <i class="fas fa-times"></i>
            </button>
        `;

        // Add to top (newest first)
        container.insertBefore(toast, container.firstChild);

        // Auto remove
        if (duration > 0) {
            setTimeout(() => {
                closePremiumToast(toast.querySelector('.toast-close'));
            }, duration);
        }
    };

    function closePremiumToast(btn) {
        const toast = btn.closest('.premium-toast');
        if (toast && !toast.classList.contains('hiding')) {
            toast.classList.add('hiding');
            toast.addEventListener('animationend', () => toast.remove());
        }
    }

    // Compatibility
    window.showToast = function (message, type = 'success') {
        showEezepcToast({
            type: type,
            title: type === 'success' ? 'Success' : 'Notice',
            message: message
        });
    };
</script>