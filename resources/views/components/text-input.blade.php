@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge([
        'class' => 'w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 sm:py-3 text-[14px] sm:text-[15px] text-slate-900 placeholder:text-slate-400 shadow-sm transition duration-150 ease-in-out focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 disabled:cursor-not-allowed disabled:border-slate-100 disabled:bg-slate-50 disabled:text-slate-400'
    ]) }}
>