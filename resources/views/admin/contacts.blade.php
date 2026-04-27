@extends('layouts.admin')
@section('title', 'Messages')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black tracking-tight uppercase">Communications</h2>
    <p class="text-[10px] text-gray-600 uppercase tracking-widest font-bold mt-1">Direct inquiries from the public gateway</p>
</div>

<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/5 bg-white/[0.01]">
                    <th class="text-left text-[10px] text-gray-500 font-black uppercase tracking-widest px-8 py-5">Origin</th>
                    <th class="text-left text-[10px] text-gray-500 font-black uppercase tracking-widest px-8 py-5">Objective</th>
                    <th class="text-left text-[10px] text-gray-500 font-black uppercase tracking-widest px-8 py-5">Transmission</th>
                    <th class="text-left text-[10px] text-gray-500 font-black uppercase tracking-widest px-8 py-5">Timestamp</th>
                    <th class="text-right text-[10px] text-gray-500 font-black uppercase tracking-widest px-8 py-5">Operations</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($contacts as $contact)
                    <tr class="hover:bg-white/[0.02] transition-colors {{ !$contact->is_read ? 'bg-purple-600/5' : '' }} group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                @if(!$contact->is_read)
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500 flex-none animate-pulse"></span>
                                @endif
                                <div class="min-w-0">
                                    <p class="text-sm font-bold {{ !$contact->is_read ? 'text-white' : 'text-gray-400' }} truncate">{{ $contact->name }}</p>
                                    <p class="text-[10px] text-gray-600 font-medium truncate">{{ $contact->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-[10px] font-black uppercase tracking-widest {{ !$contact->is_read ? 'text-purple-400' : 'text-gray-600' }}">
                                {{ $contact->subject ?: 'General Inquiry' }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-[11px] text-gray-500 max-w-xs truncate font-medium">{{ $contact->message }}</p>
                        </td>
                        <td class="px-8 py-5 text-[10px] font-bold text-gray-700 whitespace-nowrap uppercase tracking-tighter">
                            {{ $contact->created_at->format('d M Y // H:i') }}
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                @if(!$contact->is_read)
                                    <form action="{{ route('admin.contacts.read', $contact) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="w-10 h-10 bg-white/5 flex items-center justify-center text-gray-500 hover:text-white hover:bg-green-600 transition-all" title="Archive as read">
                                            <i class="fas fa-check text-[10px]"></i>
                                        </button>
                                    </form>
                                @endif
                                <button onclick="alert('Message from {{ $contact->name }}:\n\n{{ addslashes($contact->message) }}')" class="w-10 h-10 bg-white/5 flex items-center justify-center text-gray-500 hover:text-white hover:bg-purple-600 transition-all">
                                    <i class="fas fa-eye text-[10px]"></i>
                                </button>
                                <form action="{{ route('admin.contacts.delete', $contact) }}" method="POST" onsubmit="return confirm('Erase this transmission?')">
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
                        <td colspan="5" class="px-8 py-20 text-center opacity-20">
                            <i class="fas fa-inbox text-5xl mb-4 block"></i>
                            <p class="text-[10px] font-black uppercase tracking-widest">No Incoming Transmissions</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($contacts->hasPages())
        <div class="px-8 py-6 border-t border-white/5 bg-white/[0.01]">
            {{ $contacts->links() }}
        </div>
    @endif
</div>
@endsection
