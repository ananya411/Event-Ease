<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @if ($user->role === 'vendor')
            @php
                $vendor = $user->vendor ?? new \App\Models\Vendor();
            @endphp
            <div class="mt-8 border-t border-slate-100 pt-8 space-y-6">
                <h3 class="text-md font-semibold text-slate-900 mb-2">Vendor Profile Details</h3>

                <!-- Banner Image Upload and Preview -->
                <div>
                    <label class="ee-label">Profile Banner</label>
                    <div class="mt-2 flex flex-col gap-4">
                        <div class="relative w-full h-48 rounded-2xl overflow-hidden border border-slate-200 shadow-sm bg-slate-50">
                            <img src="{{ $vendor->banner_url }}" id="banner-preview" alt="Banner Preview" class="w-full h-full object-cover">
                        </div>
                        <div class="flex items-center gap-4">
                            <input type="file" name="image" id="image-upload" accept="image/*" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition-all cursor-pointer">
                            @if(!empty($vendor->image))
                                <label class="inline-flex items-center gap-2 text-xs font-semibold text-rose-600 cursor-pointer">
                                    <input type="checkbox" name="remove_image" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                    Remove custom banner
                                </label>
                            @endif
                        </div>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    <p class="text-xs text-slate-400 mt-1">Upload a high-quality JPG, PNG, or WebP banner (max 5MB). If no banner is uploaded, a default picture related to your service type will be shown.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="vendor_type" value="Service Type" />
                        <x-text-input id="vendor_type" name="vendor_type" type="text" class="mt-1 block w-full" :value="old('vendor_type', $vendor->vendor_type)" required placeholder="e.g. DJ, Caterer, Decorator" />
                        <x-input-error class="mt-2" :messages="$errors->get('vendor_type')" />
                    </div>

                    <div>
                        <x-input-label for="city" value="City" />
                        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $vendor->city)" required placeholder="e.g. Mumbai, Delhi" />
                        <x-input-error class="mt-2" :messages="$errors->get('city')" />
                    </div>

                    <div>
                        <x-input-label for="price" value="Starting Price (₹)" />
                        <x-text-input id="price" name="price" type="number" min="0" class="mt-1 block w-full" :value="old('price', $vendor->price)" required placeholder="e.g. 50000" />
                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                    </div>

                    <div>
                        <x-input-label for="phone" value="Phone Number" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $vendor->phone)" placeholder="e.g. 9876543210" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="description" value="Description / About Us" />
                    <textarea id="description" name="description" rows="4" class="ee-input mt-1 block w-full rounded-xl border-slate-300 focus:border-brand-500 focus:ring-brand-500" placeholder="Tell planners about your services, experience, and gear...">{{ old('description', $vendor->description) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>
            </div>

            <script>
                document.getElementById('image-upload').addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            document.getElementById('banner-preview').src = evt.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            </script>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
