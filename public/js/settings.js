// Shared settings JS for all admin settings pages
// Place this file in public/js/settings.js and include it in your blades.
(function () {
    'use strict';

    function ready(fn) {
        if (document.readyState !== 'loading') fn();
        else document.addEventListener('DOMContentLoaded', fn);
    }

    ready(function () {
        // Config: read POST URL and CSRF token from DOM so this file is pure JS and reusable
        const postInput = document.getElementById('__post_url');
        const POST_URL = postInput ? postInput.value : '';
        if (!POST_URL) console.warn('admin-settings.shared.js: no POST URL found in #__post_url');

        const csrfToken = document.getElementById('__csrf')?.value || '';

        // Elements
        const rightInner = document.getElementById('settingsRightInner');
        if (!rightInner) return; // nothing to do

        const navItems = Array.from(document.querySelectorAll('#settingsNavList .list-group-item'));
        const sections = Array.from(rightInner.querySelectorAll('.settings-section'));
        const searchInput = document.getElementById('settingsNavSearch');
        const clearBtn = document.getElementById('settingsNavClear');
        const toast = document.getElementById('settingsToast');

        const MIN_SEARCH_CHARS = 4;
        const DEBOUNCE_MS = 200;
        const MIN_VISIBLE_MS = 220;

        /* ---------- small utilities ---------- */
        const showToast = (msg, type = 'success', ms = 2800) => {
            if (!toast) return;
            toast.textContent = msg;
            toast.className = 'settings-toast ' + (type === 'success' ? 'success' : 'error');
            toast.style.display = 'block';
            // fade in
            setTimeout(() => (toast.style.opacity = '1'), 10);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => (toast.style.display = 'none'), 220);
            }, ms);
        };

        const ajaxSubmit = async (payload) => {
            if (!POST_URL) {
                console.error('No POST_URL configured for settings updates');
                return { ok: false, status: 0, data: null };
            }
            try {
                const res = await fetch(POST_URL, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });
                const isJson = res.headers.get('content-type')?.includes('application/json');
                return { ok: res.ok, status: res.status, data: isJson ? await res.json() : null };
            } catch (err) {
                console.error('ajaxSubmit error', err);
                return { ok: false, status: 0, data: null, error: err };
            }
        };

        const scrollToSection = (target) => {
            if (!target) return;
            const rect = target.getBoundingClientRect();
            const cont = rightInner.getBoundingClientRect();
            const y = (rect.top - cont.top) + rightInner.scrollTop;
            rightInner.scrollTo({ top: Math.max(0, Math.floor(y)), behavior: 'smooth' });
        };

        // Normalize various truthy strings to boolean (also treats "active" as true)
        function normalizeOn(val) {
            if (val === undefined || val === null) return false;
            const s = String(val).trim().toLowerCase();
            return ['1', 'true', 'yes', 'on', 'active'].includes(s);
        }

        // Generic view-updater that maps special maintenance values to friendly labels
        function setViewText(sectionEl, key, value) {
            if (!sectionEl) return;
            const row = sectionEl.querySelector(`.view-row[data-key="${key}"]`);
            if (!row) return;
            const valNode = row.querySelector('.value');
            if (!valNode) return;
            // maintenance-specific mapping
            if (key === 'store_status') {
                // store_status uses 'active' / 'full_maintenance'
                valNode.textContent = (String(value) === 'active' || normalizeOn(value)) ? 'Active' : 'Full Maintenance';
                return;
            }
            if (key === 'frontend_maintenance' || key === 'seller_maintenance') {
                // children use 'active' / 'maintenance'
                valNode.textContent = (String(value) === 'active' || normalizeOn(value)) ? 'Active' : 'Maintenance';
                return;
            }
            // boolean rows
            if (row.getAttribute('data-type') === 'bool') {
                valNode.textContent = (String(value) === '1' || value === 1 || value === true) ? 'Yes' : 'No';
                return;
            }
            // fallback
            valNode.textContent = (value === null || value === undefined) ? '' : String(value);
        }

        /* ---------- loading + no-results UI ---------- */
        const noResultsNode = document.createElement('div');
        noResultsNode.className = 'no-results';
        noResultsNode.innerHTML = `\n      <div class="no-results-title">No results found</div>\n      <div class="no-results-hint">Try different keywords or open one of these sections:</div>\n      <div class="no-results-suggestions" id="noResultsSuggestions"></div>`;
        noResultsNode.style.display = 'none';
        rightInner.appendChild(noResultsNode);
        const suggestionsContainer = noResultsNode.querySelector('#noResultsSuggestions');

        const buildSuggestionChips = () => {
            if (!suggestionsContainer) return;
            suggestionsContainer.innerHTML = '';
            navItems.forEach(item => {
                const label = item.querySelector('.label')?.textContent?.trim();
                const target = item.getAttribute('data-target');
                if (!label || !target) return;
                const chip = document.createElement('button');
                chip.type = 'button';
                chip.className = 'no-results-chip';
                chip.textContent = label;
                chip.setAttribute('data-target', target);
                suggestionsContainer.appendChild(chip);
            });
        };
        buildSuggestionChips();

        const loadingNode = document.createElement('div');
        loadingNode.className = 'settings-loading';
        loadingNode.innerHTML = `<div class="spinner" role="status" aria-hidden="true"></div>`;
        loadingNode.style.display = 'none';
        rightInner.appendChild(loadingNode);

        let loadingTimer = null;
        const showLoading = () => {
            if (loadingTimer) clearTimeout(loadingTimer);
            loadingNode.style.display = 'block';
            // force reflow for transition
            void loadingNode.offsetWidth;
            loadingNode.classList.add('is-visible');
            loadingTimer = setTimeout(() => loadingTimer = null, MIN_VISIBLE_MS);
        };
        const hideLoading = () => {
            const doHide = () => {
                loadingNode.classList.remove('is-visible');
                setTimeout(() => loadingNode.style.display = 'none', 120);
            };
            if (loadingTimer) setTimeout(() => { loadingTimer = null; doHide(); }, MIN_VISIBLE_MS);
            else doHide();
        };

        /* ---------- nav / scrollspy ---------- */
        navItems.forEach(item => item.addEventListener('click', () => {
            const target = document.querySelector(item.getAttribute('data-target'));
            if (!target) return;
            scrollToSection(target);
            navItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
        }));

        let ticking = false;
        rightInner.addEventListener('scroll', () => {
            if (ticking) return;
            window.requestAnimationFrame(() => {
                const containerRect = rightInner.getBoundingClientRect();
                let best = { score: Infinity, id: null };
                sections.forEach(sec => {
                    const rect = sec.getBoundingClientRect();
                    const dist = Math.abs(rect.top - containerRect.top);
                    if ((rect.top <= containerRect.top + 8) && dist < best.score) best = { score: dist, id: '#' + sec.id };
                });
                if (best.id) navItems.forEach(item => item.classList.toggle('active', item.getAttribute('data-target') === best.id));
                ticking = false;
            });
            ticking = true;
        });

        /* ---------- search (debounced) ---------- */
        let searchTimer = null;
        const resetSearchView = () => {
            sections.forEach(s => s.style.display = '');
            navItems.forEach(i => i.style.display = '');
            noResultsNode.style.display = 'none';
        };

        const performSearch = (raw) => {
            const q = (raw || '').trim().toLowerCase();
            if (clearBtn) clearBtn.hidden = !q.length;
            if (!q.length || q.length < MIN_SEARCH_CHARS) { resetSearchView(); hideLoading(); rightInner.dataset.searching = "0"; return; }
            rightInner.dataset.searching = "1";
            showLoading();

            let visibleCount = 0, firstMatchSection = null;
            sections.forEach(section => {
                const ok = section.innerText.toLowerCase().includes(q);
                section.style.display = ok ? '' : 'none';
                if (ok) { visibleCount++; if (!firstMatchSection) firstMatchSection = section; }
            });

            navItems.forEach(item => { const label = item.innerText.toLowerCase(); item.style.display = label.includes(q) ? '' : 'none'; });

            if (!visibleCount) {
                noResultsNode.style.display = 'flex';
                rightInner.scrollTop = 0;
                navItems.forEach(i => i.classList.remove('active'));
            } else {
                noResultsNode.style.display = 'none';
                if (firstMatchSection) {
                    setTimeout(() => scrollToSection(firstMatchSection), 60);
                    navItems.forEach(i => i.classList.toggle('active', i.getAttribute('data-target') === `#${firstMatchSection.id}`));
                }
            }
            hideLoading();
        };

        if (searchInput) {
            searchInput.addEventListener('input', () => { if (searchTimer) clearTimeout(searchTimer); searchTimer = setTimeout(() => performSearch(searchInput.value), DEBOUNCE_MS); });
            searchInput.addEventListener('keydown', (e) => { if (e.key === 'Escape' && searchInput.value) { clearBtn?.click(); e.stopPropagation(); } });
        }

        clearBtn?.addEventListener('click', () => { if (searchInput) searchInput.value = ''; resetSearchView(); noResultsNode.style.display = 'none'; if (clearBtn) clearBtn.hidden = true; searchInput?.focus(); });

        noResultsNode.addEventListener('click', (e) => {
            const chip = e.target.closest('.no-results-chip');
            if (!chip) return;
            const targetSelector = chip.getAttribute('data-target');
            const section = document.querySelector(targetSelector);
            if (!section) return;
            if (searchInput) searchInput.value = '';
            if (clearBtn) clearBtn.hidden = true;
            resetSearchView(); noResultsNode.style.display = 'none';
            scrollToSection(section);
            navItems.forEach(item => item.classList.toggle('active', item.getAttribute('data-target') === targetSelector));
        });

        /* ---------- inline editing (view -> controls) ---------- */
        const findSection = el => el ? el.closest('.settings-section') : null;

        const createActionBar = (sectionEl) => {
            const existing = sectionEl.querySelector('.inline-action-bar');
            if (existing) return existing;
            const bar = document.createElement('div');
            bar.className = 'inline-action-bar mt-3 d-flex justify-content-end gap-2';
            bar.innerHTML = `\n        <button type="button" class="btn btn-light btn-sm btn-inline-cancel">Cancel</button>\n        <button type="button" class="btn btn-primary btn-sm btn-inline-save">\n          <span class="save-text">Save</span>\n          <span class="save-spinner" style="display:none; margin-left:8px;"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></span>\n        </button>`;
            sectionEl.querySelector('.card-body')?.appendChild(bar);
            return bar;
        };

        const markInlineFlag = (sectionEl, yes = true) => { sectionEl.dataset.inlineEditing = yes ? '1' : '0'; sectionEl.classList.toggle('inline-active', yes); };

        const startInlineEdit = (sectionEl) => {
            if (!sectionEl || sectionEl.dataset.inlineEditing === '1') return;
            markInlineFlag(sectionEl, true);
            const originalMap = {}; sectionEl._inlineOriginals = originalMap;

            const editForm = sectionEl.querySelector('.edit-mode');
            let candidates = editForm ? Array.from(editForm.querySelectorAll('[name]')) : [];

            if (!candidates.length) {
                Array.from(sectionEl.querySelectorAll('.view-row')).forEach(r => {
                    const key = r.getAttribute('data-key'); if (!key) return; if (!r.querySelector('.toggle-switch')) candidates.push({ name: key });
                });
            }

            const mapByName = {};
            if (editForm) Array.from(editForm.querySelectorAll('[name]')).forEach(inp => mapByName[inp.name] = inp);

            candidates.forEach(candidate => {
                const name = candidate.name || candidate.getAttribute?.('name'); if (!name) return;
                const row = sectionEl.querySelector(`.view-row[data-key="${name}"]`); if (!row) return;
                if (row.querySelector('.toggle-switch')) return;
                if (row.querySelector('input[name], textarea[name], select[name]')) return;

                const valNode = row.querySelector('.value');
                const origText = valNode ? valNode.textContent.trim() : '';
                originalMap[name] = origText;

                const src = mapByName[name];
                let inputEl;
                if (src) {
                    const tag = src.tagName.toLowerCase();
                    if (tag === 'select') {
                        inputEl = document.createElement('select');
                        inputEl.className = 'form-select form-control'; inputEl.name = name;
                        Array.from(src.options).forEach(o => { const opt = document.createElement('option'); opt.value = o.value; opt.textContent = o.textContent; if (o.selected) opt.selected = true; inputEl.appendChild(opt); });
                        const selectedOpt = Array.from(inputEl.options).find(o => o.text === origText || o.value === origText); if (selectedOpt) inputEl.value = selectedOpt.value;
                    } else if (tag === 'textarea') {
                        inputEl = document.createElement('textarea'); inputEl.className = 'form-control'; inputEl.name = name; inputEl.rows = src.getAttribute('rows') || 2; inputEl.value = origText;
                    } else {
                        inputEl = document.createElement('input'); inputEl.className = 'form-control'; inputEl.type = src.type || 'text'; inputEl.name = name;
                        ['step', 'min', 'max', 'placeholder'].forEach(attr => src.hasAttribute(attr) && inputEl.setAttribute(attr, src.getAttribute(attr)));
                        inputEl.value = origText;
                    }
                } else {
                    inputEl = document.createElement('input'); inputEl.className = 'form-control'; inputEl.type = 'text'; inputEl.name = name; inputEl.value = origText;
                }

                if (valNode) {
                    const wrapper = document.createElement('div'); wrapper.style.minWidth = '180px'; wrapper.setAttribute('data-created', '1'); wrapper.appendChild(inputEl); valNode.replaceWith(wrapper); originalMap[`__node_${name}`] = valNode;
                } else {
                    const wrapper = document.createElement('div'); wrapper.style.minWidth = '180px'; wrapper.setAttribute('data-created', '1'); wrapper.appendChild(inputEl); row.appendChild(wrapper); originalMap[`__node_${name}`] = null;
                }
            });

            createActionBar(sectionEl);
            const firstInput = sectionEl.querySelector('.view-row .form-control, .view-row select, .view-row textarea'); if (firstInput) firstInput.focus();
        };

        const cancelInlineEdit = (sectionEl, overrideValues = null) => {
            if (!sectionEl) return;
            const originalMap = sectionEl._inlineOriginals || {};

            Object.keys(originalMap).forEach(k => {
                if (!k.startsWith('__node_')) return;
                const name = k.replace('__node_', '');
                const oldNode = originalMap[`__node_${name}`];
                const row = sectionEl.querySelector(`.view-row[data-key="${name}"]`); if (!row) return;
                const created = row.querySelector('[data-created="1"]');
                const newValText = overrideValues && (overrideValues[name] !== undefined) ? String(overrideValues[name]) : (originalMap[name] ?? '');
                if (oldNode) { if (created) created.replaceWith(oldNode); }
                else { if (created) { const valDiv = document.createElement('div'); valDiv.className = 'value'; valDiv.textContent = newValText; created.replaceWith(valDiv); } }
            });

            Array.from(sectionEl.querySelectorAll('.view-row [data-created="1"]')).forEach(n => {
                const row = n.closest('.view-row'); const key = row?.getAttribute('data-key'); const valText = overrideValues && (overrideValues[key] !== undefined) ? String(overrideValues[key]) : (sectionEl._inlineOriginals?.[key] ?? ''); const valDiv = document.createElement('div'); valDiv.className = 'value'; valDiv.textContent = valText; n.replaceWith(valDiv);
            });

            const bar = sectionEl.querySelector('.inline-action-bar'); if (bar) bar.remove();
            delete sectionEl._inlineOriginals; markInlineFlag(sectionEl, false);
        };

        /* ---------- helpers & validation ---------- */
        const findInputNode = (sectionEl, key) => sectionEl.querySelector(`[name="${key}"], [name="${key}_edit"]`) || sectionEl.querySelector(`.view-row[data-key="${key}"] [data-created] input[name="${key}"], .view-row[data-key="${key}"] [data-created] textarea[name="${key}"], .view-row[data-key="${key}"] [data-created] select[name="${key}"]`);

        const readViewValue = (sectionEl, key) => sectionEl.querySelector(`.view-row[data-key="${key}"] .value`)?.textContent?.trim() ?? '';

        const isValidIntegerAtLeast = (val, min) => {
            if (val === null || val === undefined) return false; if (String(val).trim() === '') return false; const n = parseInt(String(val).trim(), 10); return !isNaN(n) && n >= min;
        };
        const isValidNumberGreaterThan = (val, minExclusive) => {
            if (val === null || val === undefined) return false; if (String(val).trim() === '') return false; const f = parseFloat(String(val).trim()); return !isNaN(f) && f > minExclusive;
        };

        /* ---------- payload collection & apply returned ---------- */
        const collectInlinePayload = (sectionEl) => {
            const payload = { section: sectionEl.dataset.section || '' };
            Array.from(sectionEl.querySelectorAll('.view-row[data-key]')).forEach(row => {
                const key = row.getAttribute('data-key'); if (!key) return;
                const toggle = row.querySelector('.toggle-switch');
                if (toggle) {
                    // preserve prior logic: omit toggles for maintenance message editing if needed
                    if (sectionEl.dataset.section === 'maintenance') return;
                    payload[key] = toggle.checked ? (toggle.getAttribute('data-active') || '1') : (toggle.getAttribute('data-inactive') || '0');
                    return;
                }
                const control = row.querySelector('input[name], textarea[name], select[name]');
                if (control) { if (control.type === 'checkbox') payload[key] = control.checked ? (control.value || '1') : '0'; else payload[key] = control.value; return; }
                payload[key] = row.querySelector('.value')?.textContent?.trim() ?? '';
            });
            return payload;
        };

        const applyReturnedValuesToView = (sectionEl, returned = {}) => {
            if (!returned || typeof returned !== 'object') return;
            Object.keys(returned).forEach(k => {
                const row = sectionEl.querySelector(`.view-row[data-key="${k}"]`); if (!row) return;
                const rawVal = returned[k]; // raw value can be 'active'/'maintenance','active'/'full_maintenance' or 1/0 etc.
                const valNode = row.querySelector('.value');
                if (valNode) {
                    // use the same mapping as setViewText
                    if (k === 'store_status') valNode.textContent = (String(rawVal) === 'active' || normalizeOn(rawVal)) ? 'Active' : 'Full Maintenance';
                    else if (k === 'frontend_maintenance' || k === 'seller_maintenance') valNode.textContent = (String(rawVal) === 'active' || normalizeOn(rawVal)) ? 'Active' : 'Maintenance';
                    else if (row.getAttribute('data-type') === 'bool') valNode.textContent = (String(rawVal) === '1' || rawVal === 1 || rawVal === true) ? 'Yes' : 'No';
                    else valNode.textContent = (rawVal === null || rawVal === undefined) ? '' : String(rawVal);
                } else {
                    const newVal = document.createElement('div');
                    newVal.className = 'value';
                    newVal.textContent = (rawVal === null || rawVal === undefined) ? '' : String(rawVal);
                    row.appendChild(newVal);
                }

                const viewToggle = row.querySelector('.toggle-switch'); if (viewToggle) {
                    // map string boolean-like values to checked state
                    viewToggle.checked = (String(rawVal) === '1' || rawVal === 1 || rawVal === true || String(rawVal) === 'active');
                }

                const editControl = sectionEl.querySelector(`[name="${k}"], [name="${k}_edit"]`);
                if (editControl) { if (editControl.type === 'checkbox') editControl.checked = (String(rawVal) === '1' || rawVal === 1 || rawVal === true); else editControl.value = (rawVal === null || rawVal === undefined) ? '' : String(rawVal); }

                const createdControl = row.querySelector('[data-created] input[name], [data-created] textarea[name], [data-created] select[name]');
                if (createdControl) { if (createdControl.type === 'checkbox') createdControl.checked = (String(rawVal) === '1' || rawVal === 1 || rawVal === true); else createdControl.value = (rawVal === null || rawVal === undefined) ? '' : String(rawVal); }
            });
        };

        const handleAjaxResult = async ({ ok, status, data }, sectionEl, payload, onOkMsg = 'Updated') => {
            if (ok) {
                const returned = (data && data.updated_settings) ? data.updated_settings : payload;
                applyReturnedValuesToView(sectionEl, returned);
                showToast((data && data.message) ? data.message : onOkMsg, 'success');
                return { ok: true, returned };
            }
            if (status === 422 && data) {
                const editForm = sectionEl.querySelector('.edit-mode');
                if (editForm) {
                    const errors = data.errors || {};
                    Object.keys(errors).forEach(field => {
                        const errNode = editForm.querySelector(`.invalid-feedback-custom[data-error-for="${field}"]`);
                        const input = editForm.querySelector(`[name="${field}"], [name="${field}_edit"]`);
                        if (errNode) { errNode.textContent = Array.isArray(errors[field]) ? errors[field].join(' ') : String(errors[field]); errNode.style.display = ''; }
                        if (input) input.classList.add('is-invalid');
                    });
                }
                showToast((data.message) ? data.message : 'Validation failed. Check inputs.', 'error', 4500);
                return { ok: false, validation: true };
            }
            let msg = 'Failed to save settings.'; if (data && data.message) msg = data.message; showToast(msg, 'error', 3500);
            return { ok: false };
        };

        /* ---------- save inline edits ---------- */
        const saveInlineEdit = async (sectionEl, saveBtn) => {
            const spinner = sectionEl.querySelector('.save-spinner') || saveBtn.querySelector('.save-spinner');
            const saveText = saveBtn.querySelector('.save-text'); if (saveText) saveText.style.display = 'none'; if (spinner) spinner.style.display = '';
            saveBtn.disabled = true;

            const payload = collectInlinePayload(sectionEl);
            // validation (payout/disputes/tax) - same rules preserved
            const section = sectionEl.dataset.section;
            if (section === 'payout' && payload.auto_payout_enabled === '1') {
                if (!isValidIntegerAtLeast(payload.auto_payout_delay_days, 1)) { showToast('Auto Payout requires delay >= 1 day.', 'error', 4500); spinner && (spinner.style.display = 'none'); saveText && (saveText.style.display = ''); saveBtn.disabled = false; return; }
                if (!isValidNumberGreaterThan(payload.minimum_payout_threshold, 0)) { showToast('Minimum payout threshold must be greater than 0.', 'error', 4500); spinner && (spinner.style.display = 'none'); saveText && (saveText.style.display = ''); saveBtn.disabled = false; return; }
            }
            if (section === 'disputes') {
                if ((payload.hold_payout_on_dispute === '1' || payload.hold_payout_on_dispute === 1) && !isValidIntegerAtLeast(payload.dispute_hold_duration_days, 1)) { showToast('When holding payouts on disputes, duration must be at least 1 day.', 'error', 4500); spinner && (spinner.style.display = 'none'); saveText && (saveText.style.display = ''); saveBtn.disabled = false; return; }
            }
            if (section === 'tax') {
                if ((payload.deduct_gst_on_commission === '1' || payload.deduct_gst_on_commission === 1) && !isValidNumberGreaterThan(payload.platform_gst_percent, 0)) { showToast('When GST is enabled, Platform GST % must be at least 1.', 'error', 4500); spinner && (spinner.style.display = 'none'); saveText && (saveText.style.display = ''); saveBtn.disabled = false; return; }
            }

            const result = await ajaxSubmit(payload);
            if (result.ok) {
                const returned = (result.data && result.data.updated_settings) ? result.data.updated_settings : payload;
                cancelInlineEdit(sectionEl, returned);
                applyReturnedValuesToView(sectionEl, returned);
                showToast((result.data && result.data.message) ? result.data.message : 'Settings saved', 'success');
                const editForm = sectionEl.querySelector('.edit-mode');
                if (editForm) {
                    try { editForm.style.display = 'none'; } catch (e) { }
                    Array.from(editForm.querySelectorAll('.is-invalid')).forEach(i => i.classList.remove('is-invalid'));
                    Array.from(editForm.querySelectorAll('.invalid-feedback-custom')).forEach(n => n.style.display = 'none');
                }
                sectionEl.dataset.inlineEditing = '0'; sectionEl.classList.remove('inline-active', 'is-editing');
            } else if (result.status === 422 && result.data) {
                const errors = result.data.errors || {};
                const editForm = sectionEl.querySelector('.edit-mode');
                if (editForm) {
                    Object.keys(errors).forEach(field => {
                        const errNode = editForm.querySelector(`.invalid-feedback-custom[data-error-for="${field}"]`);
                        const input = editForm.querySelector(`[name="${field}"], [name="${field}_edit"]`);
                        if (errNode) { errNode.textContent = Array.isArray(errors[field]) ? errors[field].join(' ') : String(errors[field]); errNode.style.display = ''; }
                        if (input) input.classList.add('is-invalid');
                    });
                }
                showToast((result.data.message) ? result.data.message : 'Validation failed. Check inputs.', 'error', 4500);
            } else {
                let msg = 'Failed to save settings.'; if (result.data && result.data.message) msg = result.data.message; showToast(msg, 'error', 3500);
            }

            if (saveText) saveText.style.display = ''; if (spinner) spinner.style.display = 'none'; saveBtn.disabled = false;
        };

        /* ---------- delegated click handlers (manage/save/cancel) ---------- */
        document.body.addEventListener('click', (ev) => {
            const manageBtn = ev.target.closest('.btn-section-manage');
            if (manageBtn) {
                ev.preventDefault(); const sec = findSection(manageBtn); if (!sec) return; if (sec.dataset.inlineEditing === '1') cancelInlineEdit(sec); else { startInlineEdit(sec); scrollToSection(sec); } return;
            }

            const inlineCancel = ev.target.closest('.btn-inline-cancel');
            if (inlineCancel) { ev.preventDefault(); const sec = findSection(inlineCancel); if (!sec) return; cancelInlineEdit(sec); return; }

            const inlineSave = ev.target.closest('.btn-inline-save');
            if (inlineSave) { ev.preventDefault(); const sec = findSection(inlineSave); if (!sec) return; saveInlineEdit(sec, inlineSave); return; }

            const sectionCancel = ev.target.closest('.btn-section-cancel');
            if (sectionCancel) { ev.preventDefault(); const sec = findSection(sectionCancel); if (!sec) return; cancelInlineEdit(sec); return; }

            const sectionSave = ev.target.closest('.btn-section-save');
            if (sectionSave) {
                ev.preventDefault(); const sec = findSection(sectionSave); if (!sec) return; const editForm = sec.querySelector('.edit-mode'); if (!editForm) return;
                const formData = new FormData(editForm); const payload = { section: sec.dataset.section || '' };
                for (const [k, v] of formData.entries()) {
                    const el = editForm.querySelector(`[name="${k}"]`);
                    if (el && el.type === 'checkbox') payload[k.replace(/_edit$/, '')] = el.checked ? (el.value || '1') : '0'; else payload[k.replace(/_edit$/, '')] = v;
                }
                // client-side validation (preserve same rules)
                const section = sec.dataset.section;
                if (section === 'payout' && payload.auto_payout_enabled === '1') {
                    if (!isValidIntegerAtLeast(payload.auto_payout_delay_days, 1)) { showToast('Auto Payout requires delay >= 1 day.', 'error', 4500); return; }
                    if (!isValidNumberGreaterThan(payload.minimum_payout_threshold, 0)) { showToast('Minimum payout threshold must be greater than 0.', 'error', 4500); return; }
                }
                if (section === 'disputes') {
                    if ((payload.hold_payout_on_dispute === '1') && !isValidIntegerAtLeast(payload.dispute_hold_duration_days, 1)) { showToast('When holding payouts on disputes, duration must be at least 1 day.', 'error', 4500); return; }
                }
                if (section === 'tax') {
                    if ((payload.deduct_gst_on_commission === '1') && !isValidNumberGreaterThan(payload.platform_gst_percent, 0)) { showToast('When GST is enabled, Platform GST % must be at least 1.', 'error', 4500); return; }
                }

                const saveBtn = sectionSave; const spinner = saveBtn.querySelector('.save-spinner'); const saveText = saveBtn.querySelector('.save-text'); if (saveText) saveText.style.display = 'none'; if (spinner) spinner.style.display = ''; saveBtn.disabled = true;

                ajaxSubmit(payload).then(result => handleAjaxResult(result, sec, payload, 'Settings saved').then(res => {
                    if (res && res.ok) { const alertNode = sec.querySelector('.section-alert'); if (alertNode) alertNode.style.display = 'none'; }
                    if (saveText) saveText.style.display = ''; if (spinner) spinner.style.display = 'none'; saveBtn.disabled = false;
                }));
                return;
            }
        });

        /* ---------- toggles: single handler with section-specific rules ---------- */
        const revertUi = (chk, valNode, originalText) => { chk.checked = !chk.checked; if (valNode) valNode.textContent = originalText; };

        document.body.addEventListener('change', async (ev) => {
            const chk = ev.target; if (!chk.classList || !chk.classList.contains('toggle-switch')) return; ev.preventDefault();
            const key = chk.getAttribute('data-for'); const sectionEl = findSection(chk); if (!sectionEl || !key) return; const row = sectionEl.querySelector(`.view-row[data-key="${key}"]`); if (!row) return; const valNode = row.querySelector('.value'); const originalText = valNode ? valNode.textContent : '';
            if (valNode) valNode.textContent = '...';
            const tiny = document.createElement('span'); tiny.className = 'tiny-spinner'; tiny.setAttribute('aria-hidden', 'true'); chk.parentElement.appendChild(tiny);

            const newVal = chk.checked ? (chk.getAttribute('data-active') ?? '1') : (chk.getAttribute('data-inactive') ?? '0');

            const sendPayload = async (payload, revertOnFail = true, onSuccessMsg = 'Updated') => {
                const res = await ajaxSubmit(payload); const handled = await handleAjaxResult(res, sectionEl, payload, onSuccessMsg);
                if (!handled.ok && revertOnFail) { chk.checked = !chk.checked; if (valNode) valNode.textContent = originalText; }
                if (tiny && tiny.parentElement) tiny.remove(); chk.disabled = false; return handled;
            };

            // REFUND: enforce exactly one active -> flip other and submit both keys
            if (sectionEl.dataset.section === 'refund' && (key === 'auto_refund_on_order_rejection' || key === 'refund_needs_admin_approval')) {
                const otherKey = (key === 'auto_refund_on_order_rejection') ? 'refund_needs_admin_approval' : 'auto_refund_on_order_rejection';
                const otherToggle = sectionEl.querySelector(`.view-row[data-key="${otherKey}"] .toggle-switch`);
                if (otherToggle) otherToggle.checked = (newVal === '1') ? false : true;
                const payload = { section: sectionEl.dataset.section || '', [key]: newVal };
                payload[otherKey] = otherToggle ? (otherToggle.checked ? (otherToggle.getAttribute('data-active') ?? '1') : (otherToggle.getAttribute('data-inactive') ?? '0')) : (newVal === '1' ? '0' : '1');
                const result = await ajaxSubmit(payload);
                if (result.ok) { const returned = (result.data && result.data.updated_settings) ? result.data.updated_settings : payload; applyReturnedValuesToView(sectionEl, returned); showToast((result.data && result.data.message) ? result.data.message : 'Updated', 'success'); }
                else { chk.checked = !chk.checked; if (otherToggle) otherToggle.checked = !otherToggle.checked; if (valNode) valNode.textContent = originalText; let msg = 'Failed to update setting'; if (result.data && result.data.message) msg = result.data.message; showToast(msg, 'error', 3500); }
                if (tiny && tiny.parentElement) tiny.remove(); chk.disabled = false; return;
            }

            // PAYOUT: enabling requires delay >=1 and threshold >0 -> include both in payload when enabling
            if (sectionEl.dataset.section === 'payout' && key === 'auto_payout_enabled') {
                const tryingEnable = (newVal === (chk.getAttribute('data-active') ?? '1'));
                if (tryingEnable) {
                    const delayNode = findInputNode(sectionEl, 'auto_payout_delay_days');
                    const threshNode = findInputNode(sectionEl, 'minimum_payout_threshold');
                    let delayVal = delayNode ? delayNode.value : readViewValue(sectionEl, 'auto_payout_delay_days');
                    let threshVal = threshNode ? threshNode.value : readViewValue(sectionEl, 'minimum_payout_threshold');
                    delayVal = String(delayVal ?? '').trim(); threshVal = String(threshVal ?? '').trim();
                    if (!isValidIntegerAtLeast(delayVal, 1) || !isValidNumberGreaterThan(threshVal, 0)) {
                        chk.checked = false; if (valNode) valNode.textContent = originalText; showToast('To enable Auto Payout you must set: delay >= 1 day and minimum payout threshold > 0.', 'error', 4800); if (tiny && tiny.parentElement) tiny.remove(); chk.disabled = false; if (!isValidIntegerAtLeast(delayVal, 1) && delayNode) delayNode.focus(); else if (!isValidNumberGreaterThan(threshVal, 0) && threshNode) threshNode.focus(); return;
                    }
                    const payload = { section: sectionEl.dataset.section || '', auto_payout_enabled: newVal, auto_payout_delay_days: delayVal, minimum_payout_threshold: threshVal };
                    await sendPayload(payload); return;
                } else { const payload = { section: sectionEl.dataset.section || '', auto_payout_enabled: newVal }; await sendPayload(payload); return; }
            }

            // DISPUTES: enabling requires dispute_hold_duration_days >=1
            if (sectionEl.dataset.section === 'disputes' && key === 'hold_payout_on_dispute') {
                const tryingEnable = (newVal === (chk.getAttribute('data-active') ?? '1'));
                if (tryingEnable) {
                    const durationNode = findInputNode(sectionEl, 'dispute_hold_duration_days');
                    let durVal = durationNode ? durationNode.value : readViewValue(sectionEl, 'dispute_hold_duration_days'); durVal = String(durVal ?? '').trim();
                    if (!isValidIntegerAtLeast(durVal, 1)) { chk.checked = false; if (valNode) valNode.textContent = originalText; showToast('To enable dispute hold, set duration >= 1 day.', 'error', 4200); if (tiny && tiny.parentElement) tiny.remove(); chk.disabled = false; if (durationNode) durationNode.focus(); return; }
                    const payload = { section: sectionEl.dataset.section || '', hold_payout_on_dispute: newVal, dispute_hold_duration_days: durVal };
                    await sendPayload(payload); return;
                } else { const payload = { section: sectionEl.dataset.section || '', hold_payout_on_dispute: newVal }; await sendPayload(payload); return; }
            }

            // TAX: enabling requires platform_gst_percent >=1
            if (sectionEl.dataset.section === 'tax' && key === 'deduct_gst_on_commission') {
                const tryingEnable = (newVal === (chk.getAttribute('data-active') ?? '1'));
                if (tryingEnable) {
                    const gstNode = findInputNode(sectionEl, 'platform_gst_percent'); let gstVal = gstNode ? gstNode.value : readViewValue(sectionEl, 'platform_gst_percent'); gstVal = String(gstVal ?? '').trim();
                    if (!isValidNumberGreaterThan(gstVal, 0)) { chk.checked = false; if (valNode) valNode.textContent = originalText; showToast('To enable GST deduction, set Platform GST % >= 1.', 'error', 4200); if (tiny && tiny.parentElement) tiny.remove(); chk.disabled = false; if (gstNode) gstNode.focus(); return; }
                    const payload = { section: sectionEl.dataset.section || '', deduct_gst_on_commission: newVal, platform_gst_percent: gstVal };
                    await sendPayload(payload); return;
                } else { const payload = { section: sectionEl.dataset.section || '', deduct_gst_on_commission: newVal }; await sendPayload(payload); return; }
            }

            /* ---------- MAINTENANCE: NEW, CORRECTED LOGIC ---------- */
            // Behavior summary implemented:
            // - Toggling Master (store_status) forces both children to match immediately (optimistic).
            // - Toggling a child (frontend_maintenance or seller_maintenance) does NOT touch the other child.
            // - Master (M) only updates visually (and in payload) when both children become aligned (both active or both maintenance).
            // - We still send the child change to backend always. When children are aligned we include store_status in the same payload
            //   so backend receives the aligned master state too. On failure we revert all optimistic UI changes.

            if (sectionEl.dataset.section === 'maintenance') {
                const fToggle = sectionEl.querySelector('input[data-for="frontend_maintenance"]');
                const sToggle = sectionEl.querySelector('input[data-for="seller_maintenance"]');
                const gToggle = sectionEl.querySelector('input[data-for="store_status"]');

                // If user toggled master -> force both children to match immediately (optimistic), send master payload
                if (key === 'store_status') {
                    const prevF = fToggle ? fToggle.checked : null;
                    const prevS = sToggle ? sToggle.checked : null;
                    const prevG = gToggle ? gToggle.checked : null;

                    // derive boolean for master on/off
                    const masterOn = (String(newVal) === 'active' || normalizeOn(newVal));
                    // optimistic set children to master
                    if (fToggle) { fToggle.checked = masterOn; setViewText(sectionEl, 'frontend_maintenance', masterOn ? 'active' : 'maintenance'); }
                    if (sToggle) { sToggle.checked = masterOn; setViewText(sectionEl, 'seller_maintenance', masterOn ? 'active' : 'maintenance'); }
                    // update master view text too
                    setViewText(sectionEl, 'store_status', masterOn ? 'active' : 'full_maintenance');

                    // send payload (only master key required, backend may update children)
                    const payload = { section: sectionEl.dataset.section || '', [key]: newVal };
                    const result = await sendPayload(payload);
                    if (!result.ok) {
                        // revert children + master if failure
                        if (fToggle && prevF !== null) { fToggle.checked = prevF; setViewText(sectionEl, 'frontend_maintenance', prevF ? 'active' : 'maintenance'); }
                        if (sToggle && prevS !== null) { sToggle.checked = prevS; setViewText(sectionEl, 'seller_maintenance', prevS ? 'active' : 'maintenance'); }
                        if (gToggle && prevG !== null) { gToggle.checked = prevG; setViewText(sectionEl, 'store_status', prevG ? 'active' : 'full_maintenance'); }
                    }
                    return;
                }

                // If user toggled a child
                if (key === 'frontend_maintenance' || key === 'seller_maintenance') {
                    const otherKey = (key === 'frontend_maintenance') ? 'seller_maintenance' : 'frontend_maintenance';
                    const otherToggle = sectionEl.querySelector(`input[data-for="${otherKey}"]`);
                    const prevG = gToggle ? gToggle.checked : null;
                    const prevChildState = chk.checked ? (chk.getAttribute('data-active') ?? 'active') : (chk.getAttribute('data-inactive') ?? 'maintenance');

                    // Determine current child states immediately (optimistic)
                    const fState = fToggle ? (fToggle.checked ? (fToggle.getAttribute('data-active') ?? 'active') : (fToggle.getAttribute('data-inactive') ?? 'maintenance')) : null;
                    const sState = sToggle ? (sToggle.checked ? (sToggle.getAttribute('data-active') ?? 'active') : (sToggle.getAttribute('data-inactive') ?? 'maintenance')) : null;

                    // If both children are present and aligned now, update master optimistically and include store_status in payload
                    let payload = { section: sectionEl.dataset.section || '' };
                    payload[key] = newVal;

                    if (fState !== null && sState !== null && fState === sState) {
                        // aligned: set master value to match children
                        const masterVal = (fState === 'active') ? (gToggle ? (gToggle.getAttribute('data-active') ?? 'active') : 'active') : (gToggle ? (gToggle.getAttribute('data-inactive') ?? 'full_maintenance') : 'full_maintenance');
                        // optimistic master visual
                        if (gToggle) { gToggle.checked = (masterVal === (gToggle.getAttribute('data-active') ?? 'active')); setViewText(sectionEl, 'store_status', masterVal); }
                        payload['store_status'] = masterVal;
                    } else {
                        // not aligned: do not change master visually nor include it in payload
                        // leave master untouched
                    }

                    // send only child (and master if aligned)
                    const result = await sendPayload(payload);
                    if (!result.ok) {
                        // on failure sendPayload already reverts initiating chk; but if we changed master optimistically we must revert it too
                        if (gToggle && prevG !== null) { gToggle.checked = prevG; setViewText(sectionEl, 'store_status', prevG ? 'active' : 'full_maintenance'); }
                    } else {
                        // success: backend response may include updated settings including store_status — applyReturnedValuesToView handles that
                        // but to be safe/apply friendly labels (in case response is minimal), call applyReturnedValuesToView with result data handled earlier by handleAjaxResult
                        // (handled inside sendPayload/handleAjaxResult)
                    }
                    return;
                }

                // default fallback for maintenance (other keys) -> single-key submit
                const payload = { section: sectionEl.dataset.section || '', [key]: newVal };
                await sendPayload(payload);
                return;
            }

            // DEFAULT: single-key submit for non-maintenance sections
            const payload = { section: sectionEl.dataset.section || '', [key]: newVal };
            await sendPayload(payload);
        });

        /* ---------- escape to cancel inline ---------- */
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { const open = document.querySelector('.settings-section[data-inline-editing="1"], .settings-section.inline-active'); if (open) cancelInlineEdit(open); } });

        // initialize flags
        sections.forEach(sec => { sec.dataset.inlineEditing = '0'; sec.classList.remove('inline-active'); });
    });
})();
