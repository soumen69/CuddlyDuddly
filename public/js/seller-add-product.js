(function () {

    $(document).ready(init);

    function init() {
        initAccordion();
    }

    /* =======================
       ACCORDION
    ======================= */
    function initAccordion() {
        const headers = document.querySelectorAll('.product-accordion-header');
        const contents = document.querySelectorAll('.product-accordion-content');
        const items = document.querySelectorAll('.product-accordion-item');

        // 🔒 Force ALL accordions closed on load
        contents.forEach(content => {
            content.style.maxHeight = '0px';
            content.dataset.open = 'false';
        });

        // 🚩 Track if we opened any section due to errors
        let errorOpened = false;

        // ✅ Open only accordions that really have validation errors
        items.forEach(item => {
            const hasError = item.querySelector('.form-error');
            if (hasError) {
                const content = item.querySelector('.product-accordion-content');
                const header = item.querySelector('.product-accordion-header');
                const icon = header.querySelector('.icon i');

                content.style.maxHeight = content.scrollHeight + 'px';
                content.dataset.open = 'true';
                if (icon) icon.style.transform = 'rotate(180deg)';
                errorOpened = true;
            }
        });

        headers.forEach(header => {
            header.addEventListener('click', () => {
                const item = header.closest('.product-accordion-item');
                const content = item.querySelector('.product-accordion-content');
                const icon = header.querySelector('.icon i');

                const isOpen = content.dataset.open === 'true';

                // Close all
                contents.forEach(c => {
                    c.style.maxHeight = '0px';
                    c.dataset.open = 'false';
                });

                document.querySelectorAll('.product-accordion-header .icon i')
                    .forEach(i => i.style.transform = 'rotate(0deg)');

                // Open clicked one
                if (!isOpen) {
                    content.style.maxHeight = content.scrollHeight + 'px';
                    content.dataset.open = 'true';
                    if (icon) icon.style.transform = 'rotate(180deg)';
                }
            });
        });

        // ✅ Open first accordion only if no errors were found
        if (!errorOpened && contents.length > 0 && headers.length > 0) {
            contents[0].style.maxHeight = contents[0].scrollHeight + 'px';
            contents[0].dataset.open = 'true';
            const firstIcon = headers[0].querySelector('.icon i');
            if (firstIcon) firstIcon.style.transform = 'rotate(180deg)';
        }
    }
})();
