function switchTab(panel, btn) {
    document.querySelectorAll('.settings-tab')
        .forEach(t => t.classList.remove('active'));

    btn.classList.add('active');

    ['business', 'whatsapp', 'number', 'legal', 'bank']
        .forEach(id => {
            const el = document.getElementById('panel-' + id);

            if (el) {
                el.style.display = id === panel ? '' : 'none';
            }
        });
}

function triggerUpload(inputId) {
    document.getElementById(inputId).click();
}

function handleUpload(input, cardId) {

    const file = input.files[0];

    if (!file) return;

    const card = document.getElementById(cardId);
    const suffix = cardId.split('-')[1];

    const fnameEl = document.getElementById('fname-' + suffix);
    const sizeEl = document.getElementById('size-' + suffix);
    const removeEl = document.getElementById('remove-' + suffix);
    const iconEl = document.getElementById('icon-' + suffix);

    const kb = (file.size / 1024).toFixed(0);

    const sizeStr = kb > 1024
        ? (kb / 1024).toFixed(1) + ' MB'
        : kb + ' KB';

    card.classList.add('uploaded');

    fnameEl.textContent = file.name;
    fnameEl.style.display = 'block';

    sizeEl.textContent = sizeStr;

    removeEl.style.display = 'inline-block';

    iconEl.innerHTML = `
        <svg width="16" height="16" viewBox="0 0 24 24"
            fill="none"
            stroke="white"
            stroke-width="2.5"
            stroke-linecap="round">
            <path d="M20 6L9 17l-5-5"/>
        </svg>
    `;
}

function removeUpload(
    e,
    inputId,
    cardId,
    iconId,
    sizeId,
    fnameId,
    removeId
) {
    e.stopPropagation();

    document.getElementById(inputId).value = '';

    const card = document.getElementById(cardId);
    const suffix = cardId.split('-')[1];

    const fnameEl = document.getElementById(fnameId);
    const sizeEl = document.getElementById(sizeId);
    const removeEl = document.getElementById(removeId);
    const iconEl = document.getElementById(iconId);

    card.classList.remove('uploaded');

    fnameEl.textContent = '';
    fnameEl.style.display = 'none';

    removeEl.style.display = 'none';

    sizeEl.textContent = 'PDF, JPG · 50 - 200KB';

    const icons = {
        gst: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>`,

        pan: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>`,

        biz: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>`,

        addr: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>`
    };

    iconEl.innerHTML = icons[suffix] || '';
}

function markDocumentForRemoval(fieldName) {

    let removedInput = document.getElementById('removed_documents');

    if (!removedInput) {
        console.error('removed_documents hidden field not found');
        return;
    }

    let values = removedInput.value
        ? removedInput.value.split(',')
        : [];

    if (!values.includes(fieldName)) {
        values.push(fieldName);
    }

    removedInput.value = values.join(',');

    console.log('Removed Documents:', removedInput.value);
}

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('documentForm');

    if (!form) return;

    form.addEventListener('submit', function (e) {

        const hasFile =
            document.getElementById('input-gst').files.length > 0 ||
            document.getElementById('input-pan').files.length > 0 ||
            document.getElementById('input-biz').files.length > 0 ||
            document.getElementById('input-addr').files.length > 0;

        const removedDocuments =
            document.getElementById('removed_documents')?.value || '';

        if (!hasFile && !removedDocuments) {
            e.preventDefault();
            alert('Please upload or remove at least one document.');
            return;
        }

        if (!document.getElementById('legalCheck').checked) {
            e.preventDefault();
            alert('Please accept the declaration.');
            return;
        }
    });
});

function deleteDocument(field)
{
    fetch('/seller/setting/documents/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .content
        },
        body: JSON.stringify({
            field: field
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);

        if (data.success) {
            location.reload();
        }
    });
}

function previewDocuments(url, inputId){
    if(url){
        const file = document.getElementById(inputId).files[0];

    }else{
        const file = document.getElementById(inputId).files[0];
    }
}