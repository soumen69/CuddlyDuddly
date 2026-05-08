(function () {

    $(document).ready(init);

    function init() {
        initAccordion();
        initEditors();
        initShortDescriptionCounter();
        initSkuToggle();
        initImageDropzone();
        initSelect2();
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

    /* =======================
       SELECT2
    ======================= */
    function initSelect2() {
        const $select = $('.category-select');
        if ($select.length === 0) return;

        if (typeof $.fn.select2 !== 'undefined') {
            $select.select2({
                placeholder: 'Select category',
                allowClear: false,
                width: '100%',
                dropdownParent: $select.closest('.relative') || $(document.body)
            });
        } else {
            console.warn('Select2 library not loaded yet. Retrying in 200ms...');
            setTimeout(initSelect2, 200);
        }
    }



    /* =======================
       CKEDITOR
    ======================= */
    function initEditors() {

        const editors = [
            {
                id: '#description',
                toolbar: [
                    'heading', '|', 'bold', 'italic', '|',
                    'bulletedList', 'numberedList', '|',
                    'link', 'blockQuote', '|',
                    'undo', 'redo'
                ]
            },
            {
                id: '#brand_info',
                toolbar: [
                    'heading', '|', 'bold', 'italic', '|',
                    'bulletedList', 'numberedList', '|',
                    'link', 'blockQuote', '|', 'imageUpload',
                    'undo', 'redo'
                ]
            }
        ];


        editors.forEach(editor => {
            const el = document.querySelector(editor.id);
            if (el && window.ClassicEditor) {
                ClassicEditor.create(el, {
                    toolbar: editor.toolbar,
                    ckfinder: { uploadUrl: window.CKEDITOR_UPLOAD_URL }
                }).catch(console.error);
            }
        });
    }


    /* =======================
       SHORT DESCRIPTION COUNTER
    ======================= */
    function initShortDescriptionCounter() {

        const textareas = document.querySelectorAll('[data-maxlength]');

        textareas.forEach(textarea => {

            const maxLength = parseInt(textarea.dataset.maxlength);
            const counter = textarea.nextElementSibling;

            if (!counter) return;

            const updateCounter = () => {
                textarea.value = textarea.value.substring(0, maxLength);
                counter.textContent = `${textarea.value.length}/${maxLength}`;
                counter.classList.toggle('text-red-500', textarea.value.length >= maxLength);
            };

            textarea.addEventListener('input', updateCounter);
            updateCounter();
        });

    }



    /* =======================
       SKU TOGGLE
    ======================= */
    function initSkuToggle() {
        const autoToggle = $('#autoSkuToggle');
        const skuInput = $('#skuInput');

        const generateSKU = () => {
            const sellerId = $('#sellerId').val();
            const randomId = Math.floor(Math.random() * 99999999);
            return `SLR${sellerId}-${String(randomId).padStart(8, '0')}`;
        };

        autoToggle.on('change', function () {
            if (this.checked) {
                skuInput.prop('disabled', true).val(generateSKU());
            } else {
                skuInput.prop('disabled', false).val('');
            }
        });

        if (autoToggle.is(':checked')) {
            skuInput.prop('disabled', true).val(generateSKU());
        }
    }



    /* =======================
       ADVANCED IMAGE DROPZONE
       ======================= */

    // function initImageDropzone() {

    //     const dropZone = document.getElementById('dropZone');
    //     if (!dropZone || dropZone.dataset.init === "1") return;
    //     dropZone.dataset.init = "1";

    //     const imageInput = document.getElementById('imageInput');
    //     const dropzoneContent = document.getElementById('dropzoneContent');
    //     const imagePreviews = document.getElementById('imagePreviews');
    //     const errorMessage = document.getElementById('errorMessage');

    //     const dataTransfer = new DataTransfer();
    //     const MAX_IMAGES = 5;
    //     const MAX_DIMENSION = 2000;
    //     const QUALITY = 0.88;

    //     const picaInstance = window.pica();

    //     /* -----------------------
    //        LOADER
    //     ----------------------- */
    //     const loader = document.createElement('div');
    //     loader.className = "absolute inset-0 bg-white/70 flex items-center justify-center text-sm font-medium hidden z-50";
    //     loader.innerHTML = `<div class="animate-spin rounded-full h-8 w-8 border-4 border-blue-500 border-t-transparent"></div>`;
    //     dropZone.style.position = "relative";
    //     dropZone.appendChild(loader);

    //     function showLoader() { loader.classList.remove("hidden"); }
    //     function hideLoader() { loader.classList.add("hidden"); }

    //     /* -----------------------
    //        DRAG EVENTS
    //     ----------------------- */
    //     ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(evt => {
    //         dropZone.addEventListener(evt, e => {
    //             e.preventDefault(); e.stopPropagation();
    //         });
    //     });

    //     dropZone.addEventListener('click', e => {
    //         if (e.target.closest('.remove-existing-image')) {
    //             e.preventDefault();
    //             e.stopPropagation();
    //             e.target.closest('.existing-image-container').remove();
    //             updateUI();
    //             return;
    //         }

    //         if (e.target.closest('.preview-image-container')) return;
    //         imageInput.click();
    //     });

    //     imageInput.addEventListener('change', e => handleFiles(e.target.files));
    //     dropZone.addEventListener('drop', e => handleFiles(e.dataTransfer.files));

    //     /* -----------------------
    //        MAIN HANDLER
    //     ----------------------- */

    //     async function handleFiles(files) {
    //         errorMessage.classList.add('d-none');

    //         for (let file of files) {

    //             const currentCount = dataTransfer.files.length + $('.existing-image-container').length;
    //             if (currentCount >= MAX_IMAGES) {
    //                 showError("Only 5 images allowed.");
    //                 break;
    //             }

    //             if (!file.type.startsWith('image/')) {
    //                 showError("Only image files are allowed.");
    //                 continue;
    //             }

    //             try {
    //                 showLoader();

    //                 const processedFile = await processImage(file);

    //                 dataTransfer.items.add(processedFile);
    //                 imageInput.files = dataTransfer.files;
    //                 previewFile(processedFile);

    //             } catch (err) {
    //                 console.error(err);
    //                 showError("Image processing failed.");
    //             } finally {
    //                 hideLoader();
    //             }
    //         }

    //         updateUI();
    //     }

    //     /* -----------------------
    //        IMAGE PROCESSING PIPELINE
    //     ----------------------- */

    //     async function processImage(file) {

    //         // 1️⃣ Decode + auto-fix orientation
    //         const bitmap = await createImageBitmap(file, {
    //             imageOrientation: "from-image"
    //         });

    //         // 2️⃣ Resize calculation
    //         let { width, height } = bitmap;

    //         if (width > MAX_DIMENSION || height > MAX_DIMENSION) {
    //             const ratio = Math.min(MAX_DIMENSION / width, MAX_DIMENSION / height);
    //             width = Math.round(width * ratio);
    //             height = Math.round(height * ratio);
    //         }

    //         const srcCanvas = document.createElement('canvas');
    //         srcCanvas.width = bitmap.width;
    //         srcCanvas.height = bitmap.height;
    //         srcCanvas.getContext('2d').drawImage(bitmap, 0, 0);

    //         const destCanvas = document.createElement('canvas');
    //         destCanvas.width = width;
    //         destCanvas.height = height;

    //         // 3️⃣ High-quality resize with sharpening
    //         await picaInstance.resize(srcCanvas, destCanvas, {
    //             unsharpAmount: 140,
    //             unsharpRadius: 0.6,
    //             unsharpThreshold: 1
    //         });

    //         // 4️⃣ Light enhancement
    //         const ctx = destCanvas.getContext('2d');
    //         ctx.filter = "contrast(1.05) brightness(1.03) saturate(1.05)";
    //         ctx.drawImage(destCanvas, 0, 0);

    //         // 6️⃣ Convert to WebP (fallback to JPEG if not supported)
    //         const blob = await canvasToOptimizedBlob(destCanvas);

    //         return new File([blob], generateFileName(file.name), {
    //             type: blob.type,
    //             lastModified: Date.now()
    //         });
    //     }

    //     async function canvasToOptimizedBlob(canvas) {
    //         return new Promise(resolve => {
    //             if (canvas.toBlob) {
    //                 canvas.toBlob(blob => {
    //                     if (!blob) {
    //                         canvas.toBlob(resolve, "image/jpeg", QUALITY);
    //                     } else {
    //                         resolve(blob);
    //                     }
    //                 }, "image/webp", QUALITY);
    //             }
    //         });
    //     }

    //     function generateFileName(original) {
    //         return original.replace(/\.[^/.]+$/, "") + ".webp";
    //     }

    //     /* -----------------------
    //        PREVIEW
    //     ----------------------- */

    //     function previewFile(file) {
    //         const reader = new FileReader();
    //         reader.onload = () => {
    //             const wrap = document.createElement('div');
    //             wrap.className = 'relative w-24 h-24 m-2 preview-image-container';

    //             const img = document.createElement('img');
    //             img.src = reader.result;
    //             img.className = 'w-full h-full object-cover rounded border';

    //             const btn = document.createElement('button');
    //             btn.type = 'button';
    //             btn.className = 'absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm shadow-md hover:bg-red-700 transition-colors z-10';
    //             btn.textContent = '✕';
    //             btn.onclick = e => {
    //                 e.preventDefault();
    //                 e.stopPropagation();
    //                 removeFile(file, wrap);
    //             };

    //             wrap.append(img, btn);
    //             imagePreviews.appendChild(wrap);
    //         };
    //         reader.readAsDataURL(file);
    //     }

    //     /* -----------------------
    //        REMOVE FILE
    //     ----------------------- */

    //     function removeFile(file, preview) {
    //         const dt = new DataTransfer();

    //         [...dataTransfer.files].forEach(f => {
    //             if (f.name !== file.name || f.size !== file.size) {
    //                 dt.items.add(f);
    //             }
    //         });

    //         dataTransfer.items.clear();
    //         [...dt.files].forEach(f => dataTransfer.items.add(f));

    //         imageInput.files = dataTransfer.files;
    //         preview.remove();
    //         updateUI();
    //     }

    //     /* -----------------------
    //        UI HELPERS
    //     ----------------------- */

    //     function updateUI() {
    //         const hasImages = dataTransfer.files.length > 0 || $('.existing-image-container').length > 0;
    //         dropzoneContent.classList.toggle('hidden', hasImages);
    //     }

    //     function showError(msg) {
    //         errorMessage.textContent = msg;
    //         errorMessage.classList.remove('d-none');
    //     }

    //     updateUI();
    // }

    /* =======================
       IMAGE DROPZONE
    ======================= */
    function initImageDropzone() {

        const dropZone = document.getElementById('dropZone');
        if (!dropZone || dropZone.dataset.init === "1") return;
        dropZone.dataset.init = "1";

        const imageInput = document.getElementById('imageInput');
        const dropzoneContent = document.getElementById('dropzoneContent');
        const imagePreviews = document.getElementById('imagePreviews');
        const errorMessage = document.getElementById('errorMessage');

        const dataTransfer = new DataTransfer();
        const MAX_IMAGES = 5;

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(evt => {
            dropZone.addEventListener(evt, e => {
                e.preventDefault(); e.stopPropagation();
            });
        });

        dropZone.addEventListener('click', e => {
            // Check for removal of existing images
            const removeExisting = e.target.closest('.remove-existing-image');
            if (removeExisting) {
                e.preventDefault();
                e.stopPropagation();
                removeExisting.closest('.existing-image-container').remove();
                updateUI();
                return;
            }

            // Check for removal of new previews
            const removePreview = e.target.closest('.remove-preview-image');
            if (removePreview) {
                // This will be handled by the button's own onclick which has stopPropagation
                // But we include it here just in case for consistency
                return;
            }

            // If we didn't click a button or an image container, open file picker
            if (e.target.closest('.existing-image-container') || e.target.closest('.preview-image-container')) {
                return;
            }
            imageInput.click();
        });

        imageInput.addEventListener('change', e => handleFiles(e.target.files));
        dropZone.addEventListener('drop', e => handleFiles(e.dataTransfer.files));

        // Note: No more $(document).on for removals, handled natively or by inline onclick

        function handleFiles(files) {
            errorMessage.classList.add('d-none');

            for (let file of files) {
                const currentFilesCount = dataTransfer.files.length + $('.existing-image-container').length;

                if (currentFilesCount >= MAX_IMAGES) {
                    showError("Only 5 images allowed.");
                    break;
                }

                if (!file.type.startsWith('image/')) {
                    showError("Only image files allowed.");
                    continue;
                }

                if (file.size > 20 * 1024 * 1024) {
                    showError("Each image must be less than 20MB.");
                    continue;
                }

                dataTransfer.items.add(file);
                previewFile(file);
                imageInput.files = dataTransfer.files;
                updateUI();
            }
        }



        function previewFile(file) {
            const reader = new FileReader();
            reader.onload = () => {
                const wrap = document.createElement('div');
                wrap.className = 'relative w-24 h-24 m-2 preview-image-container';

                const img = document.createElement('img');
                img.src = reader.result;
                img.className = 'w-full h-full object-cover rounded border';

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm shadow-md hover:bg-red-700 transition-colors z-10 remove-preview-image';
                btn.textContent = '✕';
                btn.title = 'Remove image';
                btn.onclick = e => {
                    e.preventDefault();
                    e.stopPropagation();
                    removeFile(file, wrap);
                };

                wrap.append(img, btn);
                imagePreviews.appendChild(wrap);
            };
            reader.readAsDataURL(file);
        }

        function removeFile(file, preview) {
            const dt = new DataTransfer();
            [...dataTransfer.files].forEach(f => {
                // Use multiple properties for safer matching after compression/modification
                if (f.name !== file.name || f.size !== file.size || f.type !== file.type) {
                    dt.items.add(f);
                }
            });
            dataTransfer.items.clear();
            [...dt.files].forEach(f => dataTransfer.items.add(f));
            imageInput.files = dataTransfer.files;
            preview.remove();
            updateUI();
        }

        function updateUI() {
            const hasImages = dataTransfer.files.length > 0 || $('.existing-image-container').length > 0;
            dropzoneContent.classList.toggle('hidden', hasImages);
        }

        // Run once on load to set initial UI state
        updateUI();

        function showError(msg) {
            errorMessage.textContent = msg;
            errorMessage.classList.remove('d-none');
        }
    }

})();
