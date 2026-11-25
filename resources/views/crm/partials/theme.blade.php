{{-- Shared CRM visual identity: black + brand blue (single source of truth) --}}
<style>
    body.crm-app,
    body.crm-app button,
    body.crm-app input,
    body.crm-app select,
    body.crm-app textarea,
    body.crm-app h1,
    body.crm-app h2,
    body.crm-app h3,
    body.crm-app h4,
    body.crm-app h5,
    body.crm-app h6,
    body.crm-app p,
    body.crm-app span,
    body.crm-app a,
    body.crm-app td,
    body.crm-app th,
    body.crm-app label,
    body.crm-app small {
        font-family: 'Thmanya', 'IBM Plex Sans Arabic', sans-serif !important;
    }

    body.crm-app {
        --crm-brand: #4a5cff;
        --crm-ink: #0b0c10;
        --crm-muted: #6b7080;
        --crm-border: #e7e8ee;
        --crm-card: #fff;
        --crm-chip: #f1f2f5;
        --crm-track: #eef0f4;
        --crm-bg: #f6f7fb;
        background: var(--crm-bg);
        color: var(--crm-ink);
    }

    body.crm-app[data-pc-theme="dark"] {
        --crm-ink: #f3f4f7;
        --crm-muted: #9a9fb0;
        --crm-border: rgba(255, 255, 255, .08);
        --crm-card: #1b1d26;
        --crm-chip: rgba(255, 255, 255, .07);
        --crm-track: rgba(255, 255, 255, .08);
        --crm-bg: #14151c;
    }

    body.crm-app[data-pc-theme="color"] {
        --crm-brand: #203df4;
    }

    /* Layout */
    body.crm-app .pc-container,
    body.crm-app .pc-content {
        background: transparent;
    }
    body.crm-app .pc-content {
        color: var(--crm-ink);
    }
    body.crm-app .text-muted,
    body.crm-app small.text-muted {
        color: var(--crm-muted) !important;
    }

    /* Page headers */
    body.crm-app .pc-content h4,
    body.crm-app [id$="-root"] > .row > .col-12:first-child h5,
    body.crm-app .pc-content > .row > .col-12:first-child h5 {
        font-size: 1.85rem;
        font-weight: 800;
        letter-spacing: -.02em;
        color: var(--crm-ink);
    }
    body.crm-app [id$="-root"] > .row > .col-12:first-child small.text-muted,
    body.crm-app .pc-content > .row > .col-12:first-child small.text-muted {
        font-size: .95rem;
        color: var(--crm-muted);
    }

    /* Cards / panels */
    body.crm-app .card {
        background: var(--crm-card);
        border: 1px solid var(--crm-border) !important;
        border-radius: 20px;
        box-shadow: none !important;
        color: var(--crm-ink);
    }
    body.crm-app .card-header,
    body.crm-app .card-footer {
        background: transparent;
        border-color: var(--crm-border);
    }
    body.crm-app .dropdown-menu,
    body.crm-app .modal-content {
        background: var(--crm-card);
        border: 1px solid var(--crm-border);
        border-radius: 16px;
        box-shadow: 0 18px 40px -24px rgba(11, 12, 16, .35);
        color: var(--crm-ink);
    }
    body.crm-app .dropdown-item:hover,
    body.crm-app .dropdown-item:focus {
        background: var(--crm-chip);
        color: var(--crm-ink);
    }
    body.crm-app .dropdown-item.active,
    body.crm-app .dropdown-item:active {
        background: rgba(74, 92, 255, .1);
        color: var(--crm-brand);
    }

    /* Buttons */
    body.crm-app .btn {
        border-radius: 14px;
        font-weight: 600;
    }
    body.crm-app .btn-sm {
        border-radius: 10px;
    }
    /* Neutralize the bundled tiny-slider [data-action] rule leaking onto CRM action buttons */
    body.crm-app .btn[data-action] {
        display: inline-flex;
        margin: 0;
        min-width: 0;
        border: var(--bs-btn-border-width) solid var(--bs-btn-border-color);
    }
    body.crm-app .btn-success,
    body.crm-app .btn-danger,
    body.crm-app .btn-info,
    body.crm-app .btn-warning,
    body.crm-app .btn-secondary {
        background: var(--bs-btn-bg);
        border-color: var(--bs-btn-border-color);
        color: var(--bs-btn-color);
    }
    body.crm-app .btn-primary,
    body.crm-app .btn-dark {
        background: var(--crm-ink);
        border-color: var(--crm-ink);
        color: #fff;
    }
    body.crm-app .btn-primary:hover,
    body.crm-app .btn-primary:focus,
    body.crm-app .btn-primary:active,
    body.crm-app .btn-dark:hover,
    body.crm-app .btn-dark:focus,
    body.crm-app .btn-dark:active {
        background: #1c1e27;
        border-color: #1c1e27;
        color: #fff;
        box-shadow: none;
    }
    body.crm-app .btn-light,
    body.crm-app .btn-outline-secondary,
    body.crm-app .btn-default {
        background: var(--crm-card);
        border: 1px solid var(--crm-border);
        color: var(--crm-ink);
    }
    body.crm-app .btn-light:hover,
    body.crm-app .btn-outline-secondary:hover,
    body.crm-app .btn-default:hover {
        background: var(--crm-chip);
        border-color: var(--crm-border);
        color: var(--crm-ink);
    }
    body.crm-app .btn-outline-primary {
        color: var(--crm-brand);
        border-color: var(--crm-brand);
        background: transparent;
    }
    body.crm-app .btn-outline-primary:hover {
        background: var(--crm-brand);
        border-color: var(--crm-brand);
        color: #fff;
    }
    body.crm-app .btn-link {
        color: var(--crm-brand);
    }

    /* Links / accents */
    body.crm-app a {
        color: var(--crm-brand);
    }
    body.crm-app a.card,
    body.crm-app a.btn,
    body.crm-app .pc-head-link,
    body.crm-app .pc-link,
    body.crm-app .dropdown-item {
        color: inherit;
    }
    body.crm-app .text-primary {
        color: var(--crm-brand) !important;
    }
    body.crm-app .bg-primary {
        background-color: var(--crm-brand) !important;
    }

    /* Forms */
    body.crm-app .form-control,
    body.crm-app .form-select,
    body.crm-app .form-check-input {
        background-color: var(--crm-card);
        border-color: var(--crm-border);
        color: var(--crm-ink);
    }
    body.crm-app .form-control,
    body.crm-app .form-select {
        border-radius: 12px;
    }
    body.crm-app .form-control:focus,
    body.crm-app .form-select:focus {
        border-color: var(--crm-brand);
        box-shadow: 0 0 0 3px rgba(74, 92, 255, .14);
    }
    body.crm-app .form-check-input:checked,
    body.crm-app .form-check-input:indeterminate {
        background-color: var(--crm-brand);
        border-color: var(--crm-brand);
    }
    body.crm-app .form-check-input:focus {
        border-color: var(--crm-brand);
        box-shadow: 0 0 0 3px rgba(74, 92, 255, .14);
    }
    body.crm-app .form-switch .form-check-input:checked {
        background-color: var(--crm-brand);
    }
    body.crm-app .form-label {
        color: var(--crm-ink);
        font-weight: 600;
    }

    /* Tables */
    body.crm-app .table {
        --bs-table-bg: transparent;
        --bs-table-color: var(--crm-ink);
        --bs-table-border-color: var(--crm-border);
        color: var(--crm-ink);
        border-color: var(--crm-border);
    }
    body.crm-app .table > :not(caption) > * > * {
        border-bottom: 1px solid var(--crm-border);
        box-shadow: none;
    }
    body.crm-app .table thead th {
        background: var(--crm-chip);
        color: var(--crm-muted);
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .02em;
        text-transform: uppercase;
        border-bottom: 1px solid var(--crm-border);
    }
    body.crm-app .table-hover > tbody > tr:hover > * {
        background: var(--crm-chip);
    }
    body.crm-app .table-striped > tbody > tr:nth-of-type(odd) > * {
        background: transparent;
        color: var(--crm-ink);
    }

    /* Badges / pills */
    body.crm-app .badge {
        background: var(--crm-chip);
        color: var(--crm-ink);
        border-radius: 999px;
        font-weight: 600;
        padding: .4em .7em;
    }
    body.crm-app .badge.bg-success,
    body.crm-app .badge.bg-danger,
    body.crm-app .badge.bg-warning,
    body.crm-app .badge.bg-info,
    body.crm-app .badge.bg-primary {
        color: #fff;
    }

    /* Progress / pagination / tabs */
    body.crm-app .progress {
        background: var(--crm-track);
        border-radius: 999px;
    }
    body.crm-app .progress-bar {
        background-color: var(--crm-brand);
    }
    body.crm-app .pagination .page-item.active .page-link,
    body.crm-app .page-item.active .page-link {
        background: var(--crm-brand);
        border-color: var(--crm-brand);
        color: #fff;
    }
    body.crm-app .page-link {
        color: var(--crm-ink);
        background: var(--crm-card);
        border-color: var(--crm-border);
        border-radius: 10px;
    }
    body.crm-app .page-link:hover {
        color: var(--crm-brand);
        background: var(--crm-chip);
    }
    body.crm-app .nav-tabs .nav-link.active {
        color: var(--crm-brand);
        border-color: transparent transparent var(--crm-brand);
    }
    body.crm-app .nav-tabs .nav-link {
        color: var(--crm-muted);
    }

    /* Plugins (DateTables / SweetAlert / toast) */
    body.crm-app .dataTables_wrapper .dataTables_filter input,
    body.crm-app .dataTables_wrapper .dataTables_length select {
        border: 1px solid var(--crm-border);
        border-radius: 10px;
        background: var(--crm-card);
        color: var(--crm-ink);
    }
    body.crm-app .swal2-popup {
        background: var(--crm-card);
        color: var(--crm-ink);
        border-radius: 20px;
    }
    body.crm-app .swal2-title,
    body.crm-app .swal2-content {
        color: var(--crm-ink);
    }

    /* Dark theme accents */
    body.crm-app[data-pc-theme="dark"] .card,
    body.crm-app[data-pc-theme="dark"] .modal-content,
    body.crm-app[data-pc-theme="dark"] .dropdown-menu {
        background: var(--crm-card);
    }
    body.crm-app[data-pc-theme="dark"] .btn-primary,
    body.crm-app[data-pc-theme="dark"] .btn-dark {
        background: var(--crm-brand);
        border-color: var(--crm-brand);
    }
    body.crm-app[data-pc-theme="dark"] .btn-primary:hover,
    body.crm-app[data-pc-theme="dark"] .btn-dark:hover {
        background: #6272ff;
        border-color: #6272ff;
    }

    /* Blue sidebar mode uses the selected brand blue for primary and dark actions. */
    body.crm-app[data-pc-theme="color"] .btn-primary,
    body.crm-app[data-pc-theme="color"] .btn-dark {
        background: #203df4;
        border-color: #203df4;
        color: #fff;
    }
    body.crm-app[data-pc-theme="color"] .btn-primary:hover,
    body.crm-app[data-pc-theme="color"] .btn-primary:focus,
    body.crm-app[data-pc-theme="color"] .btn-primary:active,
    body.crm-app[data-pc-theme="color"] .btn-dark:hover,
    body.crm-app[data-pc-theme="color"] .btn-dark:focus,
    body.crm-app[data-pc-theme="color"] .btn-dark:active {
        background: #1934d8;
        border-color: #1934d8;
        color: #fff;
    }
</style>
