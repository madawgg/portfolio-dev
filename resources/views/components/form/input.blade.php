@props(['label', 'name', 'type' => 'text', 'value' => null])

<div>
    <label for="{{ $name }}" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">{{ $label }}</label>
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
           @if ($type !== 'password' && $type !== 'file') value="{{ old($name, $value) }}" @endif
           {{ $attributes->merge(['class' => 'w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-2.5 text-slate-900 dark:text-white outline-none focus:border-emerald-500']) }}>
    @error($name)
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
