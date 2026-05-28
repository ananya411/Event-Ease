@extends('layouts.app')

@section('title', 'Admin — EventEase')

@section('content')
<div class="ee-page">
    <div class="ee-container">
        <x-page-header title="Admin Dashboard" subtitle="Platform overview and recent users." />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="ee-stat"><p class="ee-stat-label">Planners</p><p class="ee-stat-value">{{ $totalPlanners }}</p></div>
            <div class="ee-stat"><p class="ee-stat-label">Vendors</p><p class="ee-stat-value text-blue-600">{{ $totalVendors }}</p></div>
            <div class="ee-stat"><p class="ee-stat-label">Events</p><p class="ee-stat-value text-emerald-600">{{ $totalEvents }}</p></div>
            <div class="ee-stat"><p class="ee-stat-label">Bookings</p><p class="ee-stat-value text-violet-600">{{ $totalBookings }}</p></div>
        </div>

        <div class="ee-card">
            <div class="ee-card-header"><h2 class="font-bold text-slate-900">Recent Users</h2></div>
            <div class="ee-table-wrap">
                <table class="ee-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsers as $user)
                        <tr>
                            <td class="font-medium">{{ $user->name }}</td>
                            <td class="text-slate-500">{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="ee-badge-rejected">Admin</span>
                                @elseif($user->role === 'planner')
                                    <span class="ee-badge-type">Planner</span>
                                @else
                                    <span class="ee-badge-confirmed">Vendor</span>
                                @endif
                            </td>
                            <td class="text-slate-500">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="ee-empty">No users found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
