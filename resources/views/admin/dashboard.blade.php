@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-5 hover:border-purple-500/20 transition-all duration-300">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center">
                <i class="fas fa-folder text-purple-400 text-sm"></i>
            </div>
            <span class="text-2xl font-bold">{{ $stats['projects'] }}</span>
        </div>
        <p class="text-gray-500 text-xs">Total Projects</p>
    </div>

    <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-5 hover:border-purple-500/20 transition-all duration-300">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center">
                <i class="fas fa-star text-blue-400 text-sm"></i>
            </div>
            <span class="text-2xl font-bold">{{ $stats['skills'] }}</span>
        </div>
        <p class="text-gray-500 text-xs">Skills</p>
    </div>

    <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-5 hover:border-purple-500/20 transition-all duration-300">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-500/10 flex items-center justify-center">
                <i class="fas fa-briefcase text-green-400 text-sm"></i>
            </div>
            <span class="text-2xl font-bold">{{ $stats['experiences'] }}</span>
        </div>
        <p class="text-gray-500 text-xs">Experiences</p>
    </div>

    <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-5 hover:border-purple-500/20 transition-all duration-300">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center">
                <i class="fas fa-envelope text-amber-400 text-sm"></i>
            </div>
            <span class="text-2xl font-bold">{{ $stats['messages'] }}</span>
        </div>
        <p class="text-gray-500 text-xs">Messages <span class="text-purple-400">({{ $stats['unread'] }} unread)</span></p>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    {{-- Quick Actions --}}
    <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-6">
        <h3 class="text-sm font-semibold text-gray-300 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('admin.projects.create') }}" class="flex items-center gap-3 bg-purple-600/10 border border-purple-500/20 rounded-xl px-4 py-3 text-sm text-purple-400 hover:bg-purple-600/20 transition-all duration-200">
                <i class="fas fa-plus text-xs"></i>
                <span>New Project</span>
            </a>
            <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-400 hover:bg-white/10 transition-all duration-200">
                <i class="fas fa-pen text-xs"></i>
                <span>Edit Profile</span>
            </a>
            <a href="{{ route('admin.skills') }}" class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-400 hover:bg-white/10 transition-all duration-200">
                <i class="fas fa-star text-xs"></i>
                <span>Add Skill</span>
            </a>
            <a href="{{ route('admin.contacts') }}" class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-400 hover:bg-white/10 transition-all duration-200">
                <i class="fas fa-envelope text-xs"></i>
                <span>View Messages</span>
            </a>
        </div>
    </div>

    {{-- Recent Messages --}}
    <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-gray-300">Recent Messages</h3>
            <a href="{{ route('admin.contacts') }}" class="text-xs text-purple-400 hover:text-purple-300 transition-colors">View All</a>
        </div>
        <div class="space-y-3">
            @forelse($recentMessages as $msg)
                <div class="flex items-start gap-3 p-3 rounded-xl {{ $msg->is_read ? 'bg-transparent' : 'bg-purple-500/5 border border-purple-500/10' }}">
                    <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center flex-none mt-0.5">
                        <span class="text-purple-400 text-xs font-bold">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-medium truncate">{{ $msg->name }}</p>
                            @if(!$msg->is_read)
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500 flex-none"></span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 truncate">{{ $msg->message }}</p>
                        <p class="text-[10px] text-gray-600 mt-1">{{ $msg->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-600 text-sm text-center py-6">No messages yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
