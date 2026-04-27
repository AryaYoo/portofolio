@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="admin-card p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-600/10 flex items-center justify-center">
                <i class="fas fa-rocket text-purple-500 text-lg"></i>
            </div>
            <span class="text-3xl font-black tracking-tighter">{{ $stats['projects'] }}</span>
        </div>
        <p class="text-gray-500 text-[10px] uppercase tracking-widest font-bold">Total Projects</p>
    </div>

    <div class="admin-card p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-600/10 flex items-center justify-center">
                <i class="fas fa-brain text-blue-500 text-lg"></i>
            </div>
            <span class="text-3xl font-black tracking-tighter">{{ $stats['skills'] }}</span>
        </div>
        <p class="text-gray-500 text-[10px] uppercase tracking-widest font-bold">Skills & Expertise</p>
    </div>

    <div class="admin-card p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-600/10 flex items-center justify-center">
                <i class="fas fa-history text-green-500 text-lg"></i>
            </div>
            <span class="text-3xl font-black tracking-tighter">{{ $stats['experiences'] }}</span>
        </div>
        <p class="text-gray-500 text-[10px] uppercase tracking-widest font-bold">Work Experiences</p>
    </div>

    <div class="admin-card p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-amber-600/10 flex items-center justify-center">
                <i class="fas fa-inbox text-amber-500 text-lg"></i>
            </div>
            <span class="text-3xl font-black tracking-tighter">{{ $stats['messages'] }}</span>
        </div>
        <p class="text-gray-500 text-[10px] uppercase tracking-widest font-bold">
            Messages <span class="text-purple-500">({{ $stats['unread'] }} New)</span>
        </p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    {{-- Quick Actions --}}
    <div class="admin-card p-8">
        <div class="mb-6">
            <h3 class="text-sm font-bold text-gray-300 uppercase tracking-widest">Quick Actions</h3>
            <p class="text-[10px] text-gray-600 mt-1 uppercase font-bold">Frequently used tasks</p>
        </div>
        <div class="space-y-3">
            <a href="{{ route('admin.projects.create') }}" class="flex items-center justify-between p-4 bg-white/5 border border-white/5 hover:border-purple-500/30 hover:bg-white/10 transition-all group">
                <div class="flex items-center gap-3">
                    <i class="fas fa-plus text-xs text-purple-500"></i>
                    <span class="text-sm font-medium text-gray-400 group-hover:text-white">Create New Project</span>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-700"></i>
            </a>
            <a href="{{ route('admin.profile') }}" class="flex items-center justify-between p-4 bg-white/5 border border-white/5 hover:border-purple-500/30 hover:bg-white/10 transition-all group">
                <div class="flex items-center gap-3">
                    <i class="fas fa-user-edit text-xs text-gray-500"></i>
                    <span class="text-sm font-medium text-gray-400 group-hover:text-white">Update Profile</span>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-700"></i>
            </a>
            <a href="{{ route('admin.skills') }}" class="flex items-center justify-between p-4 bg-white/5 border border-white/5 hover:border-purple-500/30 hover:bg-white/10 transition-all group">
                <div class="flex items-center gap-3">
                    <i class="fas fa-star text-xs text-gray-500"></i>
                    <span class="text-sm font-medium text-gray-400 group-hover:text-white">Manage Expertise</span>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-700"></i>
            </a>
        </div>
    </div>

    {{-- Recent Messages --}}
    <div class="admin-card p-8 lg:col-span-2">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="text-sm font-bold text-gray-300 uppercase tracking-widest">Recent Inquiries</h3>
                <p class="text-[10px] text-gray-600 mt-1 uppercase font-bold">Latest messages from site</p>
            </div>
            <a href="{{ route('admin.contacts') }}" class="text-[10px] font-bold uppercase tracking-widest text-purple-500 hover:text-purple-400 flex items-center gap-2">
                View Inbox <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="space-y-4">
            @forelse($recentMessages as $msg)
                <div class="flex items-center gap-4 p-4 bg-white/5 border-l-2 {{ $msg->is_read ? 'border-white/10' : 'border-purple-600' }}">
                    <div class="w-10 h-10 bg-white/5 flex items-center justify-center flex-none font-black text-xs text-gray-400">
                        {{ strtoupper(substr($msg->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-4 mb-0.5">
                            <p class="text-sm font-bold truncate">{{ $msg->name }}</p>
                            <span class="text-[9px] font-bold text-gray-600 uppercase">{{ $msg->created_at->format('M d, H:i') }}</span>
                        </div>
                        <p class="text-xs text-gray-500 truncate italic">"{{ $msg->message }}"</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 opacity-30">
                    <i class="fas fa-inbox text-4xl mb-4 block"></i>
                    <p class="text-xs font-bold uppercase tracking-widest">No Active Inquiries</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
