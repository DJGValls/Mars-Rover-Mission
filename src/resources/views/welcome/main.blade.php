@extends('layouts.main')
@section('content')
<div class="space-background">
    <div class="flex justify-center items-center h-[calc(100vh-16rem)]">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white mb-8">Mars Rover Mission</h1>
            <a href="{{ route('rover.index') }}"
               class="mission-button inline-block px-6 py-3 text-lg font-semibold text-white transition duration-300 ease-in-out transform hover:scale-105">
                Start Mission
            </a>
        </div>
    </div>
</div>
@endsection
