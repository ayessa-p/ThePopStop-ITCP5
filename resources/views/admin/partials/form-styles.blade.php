<style>
    /* ── Layout ─────────────────────────────────────── */
    .admin-container { display: flex; gap: 2rem; padding: 2rem 0; }
    .admin-main      { flex: 1; min-width: 0; }

    /* ── Sidebar (shared reset so each page doesn't need it) ── */
    .admin-sidebar { width: 280px; background: #fff; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,.05); height: fit-content; position: sticky; top: 90px; }
    .admin-sidebar h2 { color: var(--primary); font-size: 1.1rem; margin-bottom: 1.75rem; font-weight: 800; letter-spacing: .3px; }
    .sidebar-nav { display: flex; flex-direction: column; gap: .35rem; }
    .sidebar-link { display: flex; align-items: center; gap: .85rem; padding: .85rem 1.1rem; text-decoration: none; color: #777; border-radius: 10px; transition: all .18s; font-weight: 600; font-size: .88rem; }
    .sidebar-link svg { flex-shrink: 0; }
    .sidebar-link:hover { background: var(--bg); color: var(--primary); }
    .sidebar-link.active { background: var(--primary); color: #fff; }

    /* ── Page header ─────────────────────────────────── */
    .af-page-header { margin-bottom: 1.75rem; }
    .af-page-header h1 { font-size: 1.65rem; font-weight: 800; color: var(--dark-brown); margin: 0 0 .2rem 0; }
    .af-page-header p  { font-size: .85rem; color: #aaa; margin: 0; }

    .af-back-link {
        display: inline-flex; align-items: center; gap: .4rem;
        color: #aaa; text-decoration: none; font-size: .82rem; font-weight: 600;
        margin-bottom: 1.5rem; transition: color .2s;
    }
    .af-back-link:hover { color: var(--primary); }

    /* ── Form card ───────────────────────────────────── */
    .af-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
        padding: 1.75rem;
        margin-bottom: 1.25rem;
    }
    .af-card:last-child { margin-bottom: 0; }

    .af-card-title {
        display: flex; align-items: center; gap: .6rem;
        font-size: .72rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: .9px;
        color: #bbb;
        margin: 0 0 1.4rem 0;
        padding-bottom: .9rem;
        border-bottom: 1.5px solid #f0ede6;
    }
    .af-card-title svg { color: var(--primary); flex-shrink: 0; }

    /* ── Grid helpers ────────────────────────────────── */
    .af-grid-2 { display: grid; grid-template-columns: 1fr 1fr;     gap: 1rem 1.25rem; }
    .af-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem 1.25rem; }
    .af-grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem 1.25rem; }
    .af-span-2 { grid-column: span 2; }
    .af-span-3 { grid-column: span 3; }
    .af-span-all { grid-column: 1 / -1; }

    /* ── Field wrapper ───────────────────────────────── */
    .af-field { display: flex; flex-direction: column; gap: .35rem; }

    .af-label {
        font-size: .73rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .6px;
        color: #999;
    }
    .af-required { color: var(--primary); margin-left: .15rem; }

    /* ── Core input/select/textarea ──────────────────── */
    .af-input,
    .af-select,
    .af-textarea {
        width: 100%;
        padding: .75rem 1rem;
        border: 2px solid #e8e4dc;
        border-radius: 10px;
        font-size: .92rem;
        color: #333;
        background: #fff;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        font-family: inherit;
        box-sizing: border-box;
    }
    .af-input:focus,
    .af-select:focus,
    .af-textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(139,0,0,.09);
    }
    .af-input::placeholder,
    .af-textarea::placeholder { color: #ccc; }

    .af-textarea {
        resize: vertical;
        min-height: 90px;
        line-height: 1.6;
    }

    .af-select {
        appearance: none; -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%238B0000'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .85rem center;
        background-size: 1.1rem;
        padding-right: 2.5rem;
        cursor: pointer;
    }

    /* ── Input with leading prefix (₱, %, #) ─────────── */
    .af-prefix-wrap { position: relative; display: flex; align-items: center; }
    .af-prefix {
        position: absolute; left: .9rem;
        font-size: .88rem; font-weight: 700; color: #bbb;
        pointer-events: none; user-select: none;
    }
    .af-prefix-wrap .af-input { padding-left: 1.85rem; }

    /* ── Hint & error ────────────────────────────────── */
    .af-hint  { font-size: .73rem; color: #c0b8a8; line-height: 1.4; }
    .af-error { font-size: .76rem; color: #c0392b; display: flex; align-items: center; gap: .3rem; }

    /* ── File upload drop zone ───────────────────────── */
    .af-file-zone {
        position: relative;
        border: 2px dashed #e0dbd2;
        border-radius: 10px;
        padding: 1.75rem 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .2s, background .2s;
        background: #fdfcfa;
    }
    .af-file-zone:hover { border-color: var(--primary); background: rgba(139,0,0,.02); }
    .af-file-zone input[type="file"] {
        position: absolute; inset: 0; opacity: 0;
        cursor: pointer; width: 100%; height: 100%;
    }
    .af-file-icon { color: #d5cfc4; margin-bottom: .65rem; }
    .af-file-title { font-size: .88rem; font-weight: 600; color: #888; margin-bottom: .2rem; }
    .af-file-title span { color: var(--primary); }
    .af-file-sub   { font-size: .75rem; color: #bbb; }
    .af-file-preview-name {
        display: none; margin-top: .65rem;
        font-size: .8rem; font-weight: 700; color: var(--primary);
        background: rgba(139,0,0,.07); border-radius: 6px;
        padding: .3rem .7rem; display: inline-block;
    }

    /* ── Image preview (edit pages) ─────────────────── */
    .af-img-preview {
        width: 100%; max-height: 180px;
        object-fit: contain;
        border-radius: 10px;
        border: 2px solid #f0ede6;
        background: #faf8f4;
        display: block;
        margin-bottom: .75rem;
    }

    /* ── Toggle switch ───────────────────────────────── */
    .af-toggle-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: .85rem 1rem;
        border: 2px solid #e8e4dc;
        border-radius: 10px;
        cursor: pointer;
        transition: border-color .2s, background .2s;
        user-select: none;
    }
    .af-toggle-row:has(input:checked) { border-color: var(--primary); background: rgba(139,0,0,.03); }
    .af-toggle-info { display: flex; flex-direction: column; gap: .15rem; }
    .af-toggle-title { font-size: .88rem; font-weight: 700; color: #444; }
    .af-toggle-sub   { font-size: .75rem; color: #bbb; }
    .af-toggle-row:has(input:checked) .af-toggle-title { color: var(--primary); }

    .af-switch { position: relative; width: 42px; height: 24px; flex-shrink: 0; }
    .af-switch input { opacity: 0; width: 0; height: 0; }
    .af-switch-track {
        position: absolute; inset: 0;
        background: #ddd; border-radius: 999px;
        cursor: pointer; transition: background .2s;
    }
    .af-switch-track::before {
        content: '';
        position: absolute; left: 3px; top: 3px;
        width: 18px; height: 18px;
        background: #fff; border-radius: 50%;
        transition: transform .2s;
        box-shadow: 0 1px 4px rgba(0,0,0,.2);
    }
    .af-switch input:checked ~ .af-switch-track { background: var(--primary); }
    .af-switch input:checked ~ .af-switch-track::before { transform: translateX(18px); }

    /* ── Section divider label ───────────────────────── */
    .af-section-sep {
        font-size: .68rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: 1px;
        color: #ccc;
        display: flex; align-items: center; gap: .75rem;
        margin: 1.5rem 0 1.1rem;
    }
    .af-section-sep::after { content: ''; flex: 1; height: 1px; background: #f0ede6; }

    /* ── Action buttons ──────────────────────────────── */
    .af-btn-row {
        display: flex; align-items: center; gap: .75rem;
        margin-top: 1.5rem; flex-wrap: wrap;
    }
    .af-btn-submit {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .82rem 2rem;
        background: var(--primary); color: #fff;
        border: none; border-radius: 10px;
        font-size: .92rem; font-weight: 700;
        cursor: pointer; letter-spacing: .2px;
        font-family: inherit;
        transition: background .2s, transform .1s;
    }
    .af-btn-submit:hover { background: var(--accent); transform: translateY(-1px); }
    .af-btn-submit:active { transform: translateY(0); }

    .af-btn-cancel {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .82rem 1.5rem;
        background: #f5f2eb; color: #666;
        border: 2px solid #e8e4dc; border-radius: 10px;
        font-size: .88rem; font-weight: 600;
        text-decoration: none; cursor: pointer;
        font-family: inherit;
        transition: all .2s;
    }
    .af-btn-cancel:hover { background: #ede9df; color: #444; border-color: #d8d3c8; }

    .af-btn-danger {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .82rem 1.5rem;
        background: #fff1f2; color: #be123c;
        border: 2px solid #fecdd3; border-radius: 10px;
        font-size: .88rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        transition: all .2s;
    }
    .af-btn-danger:hover { background: #ffe4e6; border-color: #fda4af; }

    /* ── Info / alert boxes ──────────────────────────── */
    .af-info-box {
        display: flex; gap: .85rem;
        padding: 1rem 1.25rem;
        background: #f5f9ff; border: 1.5px solid #bfdbfe;
        border-radius: 10px; font-size: .85rem;
        color: #1e40af; line-height: 1.55;
    }
    .af-info-box svg { flex-shrink: 0; color: #3b82f6; margin-top: 1px; }

    .af-warning-box {
        display: flex; gap: .85rem;
        padding: 1rem 1.25rem;
        background: #fffbeb; border: 1.5px solid #fde68a;
        border-radius: 10px; font-size: .85rem;
        color: #92400e; line-height: 1.55;
    }
    .af-warning-box svg { flex-shrink: 0; color: #f59e0b; margin-top: 1px; }

    /* ── PO item rows ────────────────────────────────── */
    .po-item-row {
        display: grid;
        grid-template-columns: 1fr 100px 140px 44px;
        gap: .75rem;
        align-items: end;
        padding: 1rem;
        background: #fdfcfa;
        border: 1.5px solid #f0ede6;
        border-radius: 10px;
        margin-bottom: .75rem;
    }
    .po-item-row:last-child { margin-bottom: 0; }
    .btn-po-remove {
        display: flex; align-items: center; justify-content: center;
        width: 44px; height: 44px;
        background: #fff1f2; color: #be123c;
        border: 1.5px solid #fecdd3; border-radius: 8px;
        cursor: pointer; transition: all .2s; flex-shrink: 0;
        align-self: flex-end;
    }
    .btn-po-remove:hover { background: #ffe4e6; border-color: #fda4af; }
    .btn-po-add {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .6rem 1.1rem;
        background: #f5f2eb; color: #666;
        border: 2px dashed #d5cfc4; border-radius: 8px;
        font-size: .82rem; font-weight: 700;
        cursor: pointer; transition: all .2s; font-family: inherit;
        margin-top: .25rem;
    }
    .btn-po-add:hover { border-color: var(--primary); color: var(--primary); background: rgba(139,0,0,.03); }

    /* ── Responsive ──────────────────────────────────── */
    @media (max-width: 900px) {
        .admin-container { flex-direction: column; }
        .admin-sidebar   { width: 100%; position: static; }
        .af-grid-2, .af-grid-3, .af-grid-4 { grid-template-columns: 1fr 1fr; }
        .af-span-2, .af-span-3, .af-span-all { grid-column: 1 / -1; }
    }
    @media (max-width: 560px) {
        .af-grid-2, .af-grid-3, .af-grid-4 { grid-template-columns: 1fr; }
        .po-item-row { grid-template-columns: 1fr 1fr; }
        .po-item-row > *:nth-child(3) { grid-column: 1 / -1; }
        .po-item-row > *:nth-child(4) { grid-column: 1 / -1; }
    }
</style>
