<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2.5 bg-brand-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition']) }}>
    {{ $slot }}
</button>
