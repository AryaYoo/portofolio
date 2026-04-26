@extends('layouts.admin')
@section('title', 'Projects')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500 text-sm">Manage your portfolio projects</p>
    <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-500 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300">
        <i class="fas fa-plus text-xs"></i>
        <span>Add Project</span>
    </a>
</div>

{{-- Projects Table --}}
<div class="bg-white/[0.03] border border-white/10 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/5">
                    <th class="text-left text-xs text-gray-500 font-medium uppercase tracking-wider px-6 py-4">#</th>
                    <th class="text-left text-xs text-gray-500 font-medium uppercase tracking-wider px-6 py-4">Project</th>
                    <th class="text-left text-xs text-gray-500 font-medium uppercase tracking-wider px-6 py-4">Category</th>
                    <th class="text-left text-xs text-gray-500 font-medium uppercase tracking-wider px-6 py-4">Status</th>
                    <th class="text-left text-xs text-gray-500 font-medium uppercase tracking-wider px-6 py-4">Order</th>
                    <th class="text-right text-xs text-gray-500 font-medium uppercase tracking-wider px-6 py-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr class="border-b border-white/5 hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg overflow-hidden bg-purple-500/10 flex items-center justify-center flex-none">
                                    @if($project->screenshot)
                                        <img src="{{ asset('storage/' . $project->screenshot) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-lg">{{ $project->icon ?? '📁' }}</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium">{{ $project->title }}</p>
                                    <p class="text-xs text-gray-500 truncate max-w-[200px]">{{ $project->subtitle }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-semibold uppercase tracking-wider {{ $project->category === 'best' ? 'bg-purple-500/20 text-purple-400' : 'bg-gray-500/20 text-gray-400' }}">
                                {{ $project->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 text-xs {{ $project->is_active ? 'text-green-400' : 'text-gray-500' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $project->is_active ? 'bg-green-400' : 'bg-gray-600' }}"></span>
                                {{ $project->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $project->sort_order }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-gray-400 hover:text-purple-400 hover:bg-purple-500/10 transition-all duration-200">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('admin.projects.delete', $project) }}" method="POST" onsubmit="return confirm('Delete this project?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-gray-400 hover:text-red-400 hover:bg-red-500/10 transition-all duration-200">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-600">
                            <i class="fas fa-folder-open text-3xl mb-3 block"></i>
                            <p>No projects yet</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
