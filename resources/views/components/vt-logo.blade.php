@props(['size' => 40])

<div {{ $attributes->merge(['class' => 'vt-logo-container']) }} style="height: {{ $size }}px; display: inline-flex; align-items: center; justify-content: center;">
    <img src="{{ asset('images/logo-cropped.png') }}" alt="VT Logo" style="height: 120%; width: auto; max-width: none; object-fit: contain; display: block;" />
</div>
