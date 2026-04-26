@extends('layouts.admin')
@section('title', 'Messages')

@section('content')
<p class="text-gray-500 text-sm mb-6">Contact messages from your portfolio visitors</p>

<div class="bg-white/[0.03] border border-white/10 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/5">
                    <th class="text-left text-xs text-gray-500 font-medium uppercase tracking-wider px-6 py-4">From</th>
                    <th class="text-left text-xs text-gray-500 font-medium uppercase tracking-wider px-6 py-4">Subject</th>
                    <th class="text-left text-xs text-gray-500 font-medium uppercase tracking-wider px-6 py-4">Message</th>
                    <th class="text-left text-xs text-gray-500 font-medium uppercase tracking-wider px-6 py-4">Date</th>
                    <th class="text-right text-xs text-gray-500 font-medium uppercase tracking-wider px-6 py-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr class="border-b border-white/5 hover:bg-white/[0.02] transition-colors {{ !$contact->is_read ? 'bg-purple-500/[0.03]' : '' }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if(!$contact->is_read)
                                    <span class="w-2 h-2 rounded-full bg-purple-500 flex-none"></span>
                                @endif
                                <div>
                                    <p class="text-sm font-medium {{ !$contact->is_read ? 'text-white' : 'text-gray-300' }}">{{ $contact->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $contact->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $contact->subject ?: '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-400 max-w-xs truncate">{{ $contact->message }}</td>
                        <td class="px-6 py-4 text-xs text-gray-500 whitespace-nowrap">{{ $contact->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if(!$contact->is_read)
                                    <form action="{{ route('admin.contacts.read', $contact) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-gray-400 hover:text-green-400 hover:bg-green-500/10 transition-all duration-200" title="Mark as read">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.contacts.delete', $contact) }}" method="POST" onsubmit="return confirm('Delete this message?')">
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
                        <td colspan="5" class="px-6 py-12 text-center text-gray-600">
                            <i class="fas fa-envelope-open text-3xl mb-3 block"></i>
                            <p>No messages yet</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($contacts->hasPages())
        <div class="px-6 py-4 border-t border-white/5">
            {{ $contacts->links() }}
        </div>
    @endif
</div>
@endsection
