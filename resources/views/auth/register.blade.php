<x-guest-layout>
    <h2 class="text-xl font-bold text-slate-900 mb-1">Create account</h2>
    <p class="text-sm text-slate-600 mb-6">Register as an event planner or service vendor.</p>

    <form method="POST" action="{{ route('register') }}" x-data="{ role: '{{ old('role', 'planner') }}' }">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="role" value="I am registering as" />
            <select id="role" name="role" x-model="role" class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" required>
                <option value="planner">Event Planner</option>
                <option value="vendor">Service Vendor (DJ, Caterer, etc.)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div x-show="role === 'vendor'" x-cloak class="mt-4 space-y-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
            <p class="text-sm font-medium text-slate-700">Vendor profile</p>
            <div>
                <x-input-label for="vendor_type" value="Service type" />
                <input id="vendor_type" type="text" name="vendor_type" value="{{ old('vendor_type') }}"
                       placeholder="e.g. DJ, Caterer, Photographer"
                       class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                <x-input-error :messages="$errors->get('vendor_type')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="city" value="City" />
                <input id="city" type="text" name="city" value="{{ old('city') }}" class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="price" value="Starting price (₹)" />
                <input id="price" type="number" name="price" min="0" value="{{ old('price') }}" class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-brand-600 hover:underline" href="{{ route('login') }}">Already registered?</a>
            <x-primary-button>Register</x-primary-button>
        </div>
    </form>
</x-guest-layout>
