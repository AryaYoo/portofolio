@extends('layouts.admin')
@section('title', 'Projects')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-black tracking-tight uppercase">Project Collections</h2>
        <p class="text-[10px] text-gray-600 uppercase tracking-widest font-bold mt-1">Showcase your best work to the world</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="admin-btn-primary inline-flex items-center gap-2 px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-white shadow-lg">
        <i class="fas fa-plus"></i>
        <span>Add New Project</span>
    </a>
</div>

{{-- Projects Table --}}
<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/5 bg-white/[0.01]">
                    <th class="text-left text-[10px] text-gray-500 font-black uppercase tracking-widest px-8 py-5">#</th>
                    <th class="text-left text-[10px] text-gray-500 font-black uppercase tracking-widest px-8 py-5">Identity</th>
                    <th class="text-left text-[10px] text-gray-500 font-black uppercase tracking-widest px-8 py-5">Category</th>
                    <th class="text-left text-[10px] text-gray-500 font-black uppercase tracking-widest px-8 py-5">Visibility</th>
                    <th class="text-left text-[10px] text-gray-500 font-black uppercase tracking-widest px-8 py-5">Priority</th>
                    <th class="text-right text-[10px] text-gray-500 font-black uppercase tracking-widest px-8 py-5">Operations</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($projects as $project)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-8 py-5 text-[10px] font-black text-gray-700">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white/5 border border-white/5 flex items-center justify-center flex-none group-hover:border-purple-500/30 transition-all overflow-hidden">
                                    @if($project->screenshot)
                                        <img src="{{ asset('storage/' . $project->screenshot) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-lg opacity-40">{{ $project->icon ?? '📁' }}</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-gray-200 truncate">{{ $project->title }}</p>
                                    <p class="text-[10px] text-gray-600 font-medium truncate uppercase tracking-tighter">{{ $project->subtitle }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-2 py-1 text-[9px] font-black uppercase tracking-widest {{ $project->category === 'best' ? 'text-purple-500 bg-purple-500/10' : 'text-gray-500 bg-white/5' }}">
                                {{ $project->category }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-2">
                                <div class="w-1 h-1 rounded-full {{ $project->is_active ? 'bg-green-500' : 'bg-gray-700' }}"></div>
                                <span class="text-[10px] font-bold uppercase tracking-widest {{ $project->is_active ? 'text-green-500/80' : 'text-gray-700' }}">
                                    {{ $project->is_active ? 'Public' : 'Draft' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-[10px] font-bold text-gray-600">{{ $project->sort_order }}</span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="w-10 h-10 bg-white/5 flex items-center justify-center text-gray-500 hover:text-white hover:bg-purple-600 transition-all">
                                    <i class="fas fa-pen-nib text-[10px]"></i>
                                </a>
                                <form action="{{ route('admin.projects.delete', $project) }}" method="POST" onsubmit="return confirm('Archive this project?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-10 h-10 bg-white/5 flex items-center justify-center text-gray-500 hover:text-white hover:bg-red-600 transition-all">
                                        <i class="fas fa-trash-alt text-[10px]"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="opacity-20 mb-4">
                                <i class="fas fa-box-open text-5xl"></i>
                            </div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-gray-600">No Projects Found In Workspace</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
