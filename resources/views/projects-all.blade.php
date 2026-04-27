@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center text-center p-8">
    <div class="mb-8 text-purple-500">
        <i class="fas fa-hammer text-6xl"></i>
    </div>
    <h1 class="text-4xl font-bold font-['Playfair_Display'] mb-4">All Projects</h1>
    <p class="text-gray-400 max-w-lg mb-8">This page is currently under construction. A complete list of all projects, experiments, and case studies will be displayed here.</p>
    
    <a href="{{ route('portfolio') }}" class="inline-flex items-center gap-3 bg-purple-600 hover:bg-purple-500 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300">
        <i class="fas fa-arrow-left text-sm"></i>
        <span>Back to Portfolio</span>
    </a>
</div>
@endsection
