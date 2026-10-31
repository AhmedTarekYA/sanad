<link rel="icon" href="{{ asset('brand/logo.svg') }}" type="image/svg+xml">
<style>
@font-face{font-family:'IBM Plex Sans Arabic';src:url('{{ asset('brand/fonts/IBMPlexSansArabic-Regular.ttf') }}') format('truetype');font-weight:400;font-style:normal;font-display:swap}
@font-face{font-family:'IBM Plex Sans Arabic';src:url('{{ asset('brand/fonts/IBMPlexSansArabic-Medium.ttf') }}') format('truetype');font-weight:500;font-style:normal;font-display:swap}
@font-face{font-family:'IBM Plex Sans Arabic';src:url('{{ asset('brand/fonts/IBMPlexSansArabic-SemiBold.ttf') }}') format('truetype');font-weight:600;font-style:normal;font-display:swap}
@font-face{font-family:'IBM Plex Sans Arabic';src:url('{{ asset('brand/fonts/IBMPlexSansArabic-Bold.ttf') }}') format('truetype');font-weight:700;font-style:normal;font-display:swap}
@font-face { font-family: 'Thmanya'; src: url('https://framerusercontent.com/assets/x6EBzvXf1Fi35XhsRoHxePDVo.woff2') format('woff2'); font-display: swap; font-style: normal; font-weight: 400; }
@font-face { font-family: 'Thmanya'; src: url('https://framerusercontent.com/assets/Lh8puxCFq405qBv7dKpg9NsHZNk.woff2') format('woff2'); font-display: swap; font-style: normal; font-weight: 300; }
@font-face { font-family: 'Thmanya'; src: url('https://framerusercontent.com/assets/oE98mOPE28KTzUeptOLRIaqW1I.woff2') format('woff2'); font-display: swap; font-style: normal; font-weight: 500; }
@font-face { font-family: 'Thmanya'; src: url('https://framerusercontent.com/assets/LZvgFRUsP7pGWYj3tKxMUrKuhSY.woff2') format('woff2'); font-display: swap; font-style: normal; font-weight: 700; }
@font-face { font-family: 'Thmanya'; src: url('https://framerusercontent.com/assets/ulQLGTktcl2Qq4AmD6RuVgELZKg.woff2') format('woff2'); font-display: swap; font-style: normal; font-weight: 900; }
/* SANAD CX brand defaults — override theme preset before JS loads */
:root{
    --bs-primary:#2D71F0;--bs-primary-rgb:45,113,240;
    --bs-blue:#2D71F0;
    --bs-link-color:#2D71F0;--bs-link-color-rgb:45,113,240;
    --bs-link-hover-color:#1640C6;
    --bs-primary-light:#EAF0F9;
    --bs-primary-dark:#1640C6;
    --sanad-primary-hover:#1640C6;
    --pc-sidebar-active-color:#2D71F0;
}
@php $activeFont = ($settings?->font ?? 'ibm') === 'thmanya' ? "'Thmanya','IBM Plex Sans Arabic'" : "'IBM Plex Sans Arabic','Thmanya'"; @endphp
body{font-family:{{ $activeFont }},sans-serif;}
</style>
<link rel="stylesheet" href="{{ asset('light-able/assets/fonts/phosphor/duotone/style.css') }}">
<link rel="stylesheet" href="{{ asset('light-able/assets/fonts/tabler-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('light-able/assets/fonts/feather.css') }}">
<link rel="stylesheet" href="{{ asset('light-able/assets/fonts/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('light-able/assets/fonts/material.css') }}">
<link rel="stylesheet" href="{{ asset('light-able/assets/css/style.css') }}" id="main-style-link">
<link rel="stylesheet" href="{{ asset('light-able/assets/css/style-preset.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/cssbundle/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/toster/css/jquery.toast.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/css/fancybox.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/cssbundle/dropify.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/cssbundle/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/jquery_validator/form_validator/theme-default.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/css/sanad-ui.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
@if (app()->getLocale() === 'ar')
<style>html, body { direction: rtl; } .pc-sidebar { direction: rtl; } .pc-header, .pc-container { direction: rtl; }</style>
@endif
<style>
    input.error, input.valid, select.error, select.valid { background-repeat: no-repeat; }
    html[dir="rtl"] input.error, html[dir="rtl"] input.valid, html[dir="rtl"] select.error, html[dir="rtl"] select.valid { background-position: left 10px center; padding-left: 34px; padding-right: 12px; }
    html[dir="ltr"] input.error, html[dir="ltr"] input.valid, html[dir="ltr"] select.error, html[dir="ltr"] select.valid { background-position: right 10px center; padding-right: 34px; }
    #global-menu-search .btn-search { display: none !important; }
    #language-menu .dropdown-item { gap: 10px; }
    #language-menu .language-flag { width: 22px; text-align: center; font-size: 18px; line-height: 1; }

    /* Shared DataTables presentation */
    .dataTables_wrapper {
        margin-top: 1rem;
        padding: 1.25rem;
        border: 1px solid #e5ebf2;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(31, 41, 55, .06);
    }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        min-height: 42px;
        display: flex;
        align-items: center;
        gap: .5rem;
        color: #526277;
        font-size: .875rem;
    }
    .dataTables_wrapper .dataTables_filter label,
    .dataTables_wrapper .dataTables_length label {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        margin: 0;
    }
    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        min-height: 38px;
        border: 1px solid #d8e1eb;
        border-radius: 9px;
        background: #f8fafc;
        color: #243247;
        padding: .4rem .75rem;
        outline: none;
        transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
    }
    .dataTables_wrapper .dataTables_filter input {
        min-width: 190px;
        margin-inline-start: .25rem;
    }
    .dataTables_wrapper .dataTables_filter input:focus,
    .dataTables_wrapper .dataTables_length select:focus {
        border-color: #0da9e9;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(13, 169, 233, .14);
    }
    .dataTables_wrapper table.dataTable {
        width: 100% !important;
        margin: 1rem 0 !important;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
    }
    .dataTables_wrapper table.dataTable thead th {
        padding: .9rem 1rem;
        border-top: 1px solid #e5ebf2;
        border-bottom: 1px solid #dce5ee;
        background: #f7f9fc;
        color: #26364d;
        font-size: .78rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .dataTables_wrapper table.dataTable tbody td {
        padding: .85rem 1rem;
        border-bottom: 1px solid #edf1f5;
        color: #40516a;
        vertical-align: middle;
        transition: background-color .18s ease;
    }
    .dataTables_wrapper table.dataTable tbody tr:last-child td { border-bottom: 0; }
    .dataTables_wrapper table.dataTable tbody tr:hover td { background: #f3faff; }
    .dataTables_wrapper table.dataTable tbody tr.selected td { background: #eaf7fd; }
    .dataTables_wrapper .editButton,
    .dataTables_wrapper .deleteButton {
        width: 38px;
        height: 38px;
        padding: 0;
        justify-content: center;
        border: 0;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(31, 41, 55, .1);
        transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
    }
    .dataTables_wrapper .editButton:hover,
    .dataTables_wrapper .deleteButton:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(31, 41, 55, .16);
        filter: saturate(1.08);
    }
    .dataTables_wrapper .editButton .ti,
    .dataTables_wrapper .deleteButton .ti { font-size: 18px; line-height: 1; }
    .dataTables_wrapper .dataTables_info {
        padding-top: .75rem;
        color: #748297;
        font-size: .8rem;
    }
    .dataTables_wrapper .dataTables_paginate { padding-top: .5rem; }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        min-width: 36px;
        height: 36px;
        margin-inline: 2px;
        padding: .45rem .7rem !important;
        border: 1px solid #e0e7ef !important;
        border-radius: 9px !important;
        background: #fff !important;
        color: #53657d !important;
        transition: all .18s ease;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        border-color: #0da9e9 !important;
        background: #0da9e9 !important;
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(13, 169, 233, .2);
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        border-color: #edf1f5 !important;
        background: #f8fafc !important;
        color: #b0bac7 !important;
        box-shadow: none;
    }
    @media (max-width: 767.98px) {
        .dataTables_wrapper { padding: .75rem; border-radius: 12px; }
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            float: none;
            justify-content: space-between;
            width: 100%;
            margin-bottom: .5rem;
        }
        .dataTables_wrapper .dataTables_filter input { min-width: 0; width: 145px; }
        .dataTables_wrapper .dataTables_scrollBody { border: 0; }
        .dataTables_wrapper table.dataTable { min-width: 620px; }
        .dataTables_wrapper > .row:last-child { gap: .5rem; }
    }
    [data-pc-preset] .btn-primary { --bs-btn-bg: var(--bs-primary); --bs-btn-border-color: var(--bs-primary); --bs-btn-hover-bg: var(--sanad-primary-hover, var(--bs-primary)); --bs-btn-hover-border-color: var(--sanad-primary-hover, var(--bs-primary)); --bs-btn-active-bg: var(--sanad-primary-hover, var(--bs-primary)); --bs-btn-active-border-color: var(--sanad-primary-hover, var(--bs-primary)); }
    [data-pc-preset] .bg-light-primary { background: var(--bs-primary-light) !important; color: var(--bs-primary) !important; }
    [data-pc-preset] .link-primary, [data-pc-preset] .text-primary { color: var(--bs-primary) !important; }
    [data-pc-preset] .link-primary:hover, [data-pc-preset] .link-primary:focus { color: var(--sanad-primary-hover, var(--bs-primary)) !important; }
    [data-pc-preset] .form-control:focus, [data-pc-preset] .form-select:focus { border-color: var(--bs-primary) !important; box-shadow: 0 0 0 .2rem color-mix(in srgb, var(--bs-primary) 18%, transparent) !important; }
    [data-pc-preset] .pc-sidebar .pc-item.active > .pc-link, [data-pc-preset] .pc-sidebar .pc-link:hover .pc-micon i { color: var(--bs-primary); }
</style>
