<svg class="fikr-wordmark" viewBox="0 300 1714 1414" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
    <defs>
        <filter id="{{ $logoId }}-ink" x="0" y="0" width="100%" height="100%" color-interpolation-filters="sRGB">
            <feColorMatrix type="matrix" values="0 0 0 0 1  0 0 0 0 1  0 0 0 0 1  0 0 0 -1 1" />
        </filter>
        <mask id="{{ $logoId }}-mask" maskUnits="userSpaceOnUse" x="0" y="0" width="1714" height="1714" style="mask-type:alpha">
            <image href="{{ asset('website/assets/image/fkr/brand-source.png') }}" width="1714" height="2000" filter="url(#{{ $logoId }}-ink)" />
        </mask>
    </defs>
    <rect width="1714" height="1710" fill="currentColor" mask="url(#{{ $logoId }}-mask)" />
    <text x="170" y="850" fill="currentColor" font-family="Arial, sans-serif" font-size="90" font-weight="700" direction="ltr">TM</text>
</svg>
