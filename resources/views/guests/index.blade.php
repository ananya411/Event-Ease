@extends('layouts.app')

@section('title', 'Guests — ' . $event->title)

@section('content')
<div class="ee-page">
    <div class="ee-container">
        <x-page-header :title="$event->title . ' — Guest List'" subtitle="Invite guests, copy RSVP links, and track invitation acceptances.">
            <x-slot name="actions">
                <a href="{{ route('events.index') }}" class="ee-btn-secondary ee-btn-sm">← Events</a>
                <a href="{{ route('guests.create', $event->_id) }}" class="ee-btn-primary ee-btn-sm">+ Add Guest</a>
            </x-slot>
        </x-page-header>

        <div class="mb-8 p-6 rounded-3xl border border-indigo-100/80 bg-indigo-50/40 backdrop-blur-sm shadow-sm flex gap-4 items-start">
            <div class="p-2 bg-indigo-100/70 text-indigo-700 rounded-xl mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider">How to manage RSVPs & invitations:</h4>
                <p class="mt-1 text-sm text-slate-600 leading-relaxed">
                    You can easily manage invitation statuses in two ways:
                </p>
                <ul class="mt-2 list-disc list-inside space-y-1 text-sm text-slate-600">
                    <li>Copy the unique <strong class="text-indigo-600">RSVP link</strong> next to a guest and send it to them. They can view the invitation details and accept/decline online.</li>
                    <li>Or, click the <strong class="text-emerald-600">Confirm</strong> or <strong class="text-slate-500">Decline</strong> buttons below to manually record their response immediately.</li>
                </ul>
            </div>
        </div>

        @php
            $confirmed = $guests->where('status', 'confirmed')->sum('members');
            $pending = $guests->where('status', 'pending')->sum('members');
            $declined = $guests->where('status', 'declined')->sum('members');
            $totalInvited = $confirmed + $pending + $declined;

            // Auto-swap local IP address with your active public HTTPS localhost.run tunnel link!
            $baseUrl = request()->getSchemeAndHttpHost();
            if (str_contains($baseUrl, '127.0.0.1') || str_contains($baseUrl, 'localhost')) {
                $baseUrl = config('app.tunnel_url') ?: 'https://6c046dbfd10603.lhr.life';
            }
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-5 mb-8">
            <div class="ee-stat border-l-slate-400">
                <p class="ee-stat-label">Total Invited</p>
                <p class="ee-stat-value text-slate-800">{{ $totalInvited }}</p>
            </div>
            <div class="ee-stat border-l-emerald-500">
                <p class="ee-stat-label">Confirmed Attending</p>
                <p class="ee-stat-value text-emerald-600">{{ $confirmed }}</p>
            </div>
            <div class="ee-stat border-l-amber-500">
                <p class="ee-stat-label">Pending Invitations</p>
                <p class="ee-stat-value text-amber-600">{{ $pending }}</p>
            </div>
            <div class="ee-stat border-l-rose-500">
                <p class="ee-stat-label">Declined</p>
                <p class="ee-stat-value text-rose-600">{{ $declined }}</p>
            </div>
        </div>

        <div class="ee-card">
            <div class="ee-table-wrap">
                <table class="ee-table">
                    <thead>
                        <tr>
                            <th>Guest Name</th>
                            <th>Email Address</th>
                            <th>Party Size</th>
                            <th>RSVP Status</th>
                            <th>Invitation RSVP Link</th>
                            <th class="text-right">Manage Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guests as $guest)
                        <tr>
                            <td class="font-bold text-slate-900">{{ $guest->name }}</td>
                            <td class="text-slate-500">{{ $guest->email ?? '—' }}</td>
                            <td class="font-semibold text-slate-700">{{ $guest->members }} {{ $guest->members === 1 ? 'member' : 'members' }}</td>
                            <td><span class="ee-badge-{{ $guest->status }}">{{ ucfirst($guest->status) }}</span></td>
                            <td>
                                @if($guest->rsvp_token)
                                    <div class="flex items-center gap-1.5 max-w-[280px]">
                                        <input type="text" readonly value="{{ $baseUrl . '/rsvp/' . $guest->rsvp_token }}"
                                               id="rsvp-{{ $guest->_id }}"
                                               class="ee-input py-1.5 text-xs truncate bg-slate-50 focus:bg-white select-all">
                                        <button type="button"
                                                onclick="navigator.clipboard.writeText(document.getElementById('rsvp-{{ $guest->_id }}').value); this.textContent='Copied!'; this.classList.remove('bg-white'); this.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-200'); setTimeout(() => { this.textContent='Copy'; this.className='ee-btn-secondary ee-btn-sm shrink-0' }, 1500)"
                                                class="ee-btn-secondary ee-btn-sm shrink-0">Copy</button>
                                        <a href="https://api.whatsapp.com/send?text=Hello%20{{ urlencode($guest->name) }}!%20You%20are%20cordially%20invited%20to%20{{ urlencode($event->title) }}.%20Please%20confirm%20your%20attendance%20by%20clicking%20on%20this%20RSVP%20link:%20{{ urlencode($baseUrl . '/rsvp/' . $guest->rsvp_token) }}"
                                           target="_blank"
                                           class="ee-btn-success ee-btn-sm shrink-0 flex items-center justify-center p-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 hover:shadow-emerald-500/20"
                                           title="Share on WhatsApp">
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.513 2.262 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.73-1.455L0 24zm6.59-4.846c1.66.986 3.288 1.488 4.96 1.489 5.485 0 9.948-4.468 9.95-9.953.002-2.657-1.02-5.155-2.88-7.019C16.818 1.808 14.322.787 11.663.787c-5.489 0-9.954 4.468-9.957 9.958-.001 1.784.477 3.528 1.385 5.06l-.995 3.637 3.73-.978c1.51.823 3.01 1.258 4.816 1.258zm12.352-7.11c-.33-.165-1.951-.963-2.251-1.072-.3-.11-.518-.165-.736.165-.218.33-.844 1.072-1.036 1.29-.19.217-.382.244-.711.079-.33-.165-1.391-.512-2.65-1.635-.979-.873-1.639-1.95-1.831-2.28-.19-.33-.02-.507.144-.671.149-.148.33-.384.496-.576.165-.192.22-.33.33-.55.11-.22.054-.412-.027-.577-.08-.165-.736-1.774-1.009-2.434-.267-.641-.539-.553-.736-.563-.19-.01-.409-.01-.628-.01s-.573.082-.873.412c-.3.33-1.145 1.118-1.145 2.727 0 1.608 1.172 3.16 1.336 3.38.164.22 2.307 3.522 5.59 4.942.78.337 1.39.539 1.86.688.784.249 1.497.214 2.062.13.629-.094 1.951-.797 2.225-1.568.273-.77.273-1.43.19-1.567-.083-.139-.3-.221-.63-.386z"/>
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex flex-wrap justify-end gap-1.5">
                                    @if($guest->status !== 'confirmed')
                                    <form action="{{ route('guests.status', $guest->_id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="ee-btn-success ee-btn-sm">Confirm</button>
                                    </form>
                                    @endif
                                    @if($guest->status !== 'declined')
                                    <form action="{{ route('guests.status', $guest->_id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="declined">
                                        <button type="submit" class="ee-btn-secondary ee-btn-sm">Decline</button>
                                    </form>
                                    @endif
                                    <form action="{{ route('guests.destroy', $guest->_id) }}" method="POST" class="inline" onsubmit="return confirm('Remove this guest from the invitation list?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="ee-btn-danger ee-btn-sm">Remove</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="ee-empty">
                                <svg class="w-12 h-12 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                No guests invited to this event yet.
                                <a href="{{ route('guests.create', $event->_id) }}" class="text-brand-600 font-bold hover:underline mt-1 block">Add the first guest</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
