export const initPopup = () => {
    const run = () => {
        const dialogs = document.querySelectorAll('dialog.popup-dialog');
        if (!dialogs.length) return;

        dialogs.forEach((dialog) => {
            const popupId = dialog.id.replace('popup-', '');
            if (!popupId) return;

            const cookieName = `popup_shown_${popupId}`;
            const cookieDays = parseInt(dialog.dataset.cookieDuration, 10) || 7;
            const cookieDelay = parseInt(dialog.dataset.popupDelay, 10) >= 0 
                ? parseInt(dialog.dataset.popupDelay, 10) 
                : 3;

            // Check if already shown
            if (getCookie(cookieName)) {
                return;
            }

            const closeDialog = () => {
                if (dialog.open) {
                    dialog.close();
                }
                setCookie(cookieName, '1', cookieDays);
            };

            // Delay before opening dialog
            setTimeout(() => {
                if (!getCookie(cookieName) && typeof dialog.showModal === 'function') {
                    try {
                        dialog.showModal();
                    } catch {
                        dialog.setAttribute('open', '');
                    }
                }
            }, cookieDelay * 1000);

            // Close button
            dialog.querySelector('.popup-close')?.addEventListener('click', (e) => {
                e.preventDefault();
                closeDialog();
            });

            // Action buttons
            dialog.querySelectorAll('.popup-btn').forEach((btn) => {
                btn.addEventListener('click', () => {
                    closeDialog();
                });
            });

            // Backdrop click: close only when clicking directly on dialog backdrop outside dialog box
            dialog.addEventListener('click', (e) => {
                const rect = dialog.getBoundingClientRect();
                const isInDialog = (
                    rect.top <= e.clientY &&
                    e.clientY <= rect.top + rect.height &&
                    rect.left <= e.clientX &&
                    e.clientX <= rect.left + rect.width
                );
                if (!isInDialog) {
                    closeDialog();
                }
            });

            // Escape key handler
            dialog.addEventListener('cancel', () => {
                setCookie(cookieName, '1', cookieDays);
            });
        });
    };

    function setCookie(name, value, days) {
        const d = new Date();
        d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = `${name}=${value};path=/;expires=${d.toUTCString()};SameSite=Lax`;
    }

    function getCookie(name) {
        return document.cookie
            .split('; ')
            .find((row) => row.startsWith(`${name}=`))
            ?.split('=')[1];
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run);
    } else {
        run();
    }
};

