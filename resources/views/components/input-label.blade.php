@props(['value'])

<label {{ $attributes->merge([
    'class' => 'block text-[13px] sm:text-sm font-semibold text-slate-700 mb-1.5 tracking-tight'
]) }}>
    {{ $value ?? $slot }}
</label>