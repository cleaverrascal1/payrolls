@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div class="w-full h-full grid grid-cols-15 grid-rows-[auto_auto_auto_288px] gap-4">
        <div class="col-span-3 p-4 rounded-xl bg-white border border-neutral-200 space-y-3">
            <div class="h-3 w-1/2 bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-6 w-3/4 bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-3 w-1/3 bg-neutral-200 rounded animate-pulse"></div>
        </div>
        <div class="col-span-3 p-4 rounded-xl bg-white border border-neutral-200 space-y-3">
            <div class="h-3 w-1/2 bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-6 w-3/4 bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-3 w-1/3 bg-neutral-200 rounded animate-pulse"></div>
        </div>
        <div class="col-span-3 p-4 rounded-xl bg-white border border-neutral-200 space-y-3">
            <div class="h-3 w-1/2 bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-6 w-3/4 bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-3 w-1/3 bg-neutral-200 rounded animate-pulse"></div>
        </div>
        <div class="col-span-3 p-4 rounded-xl bg-white border border-neutral-200 space-y-3">
            <div class="h-3 w-1/2 bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-6 w-3/4 bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-3 w-1/3 bg-neutral-200 rounded animate-pulse"></div>
        </div>
        <div class="col-span-3 p-4 rounded-xl bg-white border border-neutral-200 space-y-3">
            <div class="h-3 w-1/2 bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-6 w-3/4 bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-3 w-1/3 bg-neutral-200 rounded animate-pulse"></div>
        </div>

        <div class="col-span-9 row-span-2 p-4 rounded-xl bg-white border border-neutral-200 space-y-3">
            <div class="h-4 w-1/4 bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-3 w-full bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-3 w-5/6 bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-3 w-4/6 bg-neutral-200 rounded animate-pulse"></div>
            <div class="mt-4 h-24 w-full bg-neutral-200 rounded animate-pulse"></div>
        </div>
        <div class="col-span-6 row-span-2 p-4 rounded-xl bg-white border border-neutral-200 space-y-3">
            <div class="h-4 w-1/3 bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-3 w-full bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-3 w-5/6 bg-neutral-200 rounded animate-pulse"></div>
            <div class="mt-4 h-24 w-full bg-neutral-200 rounded animate-pulse"></div>
        </div>

        <div class="col-span-15 row-span-3 p-4 rounded-xl bg-white border border-neutral-200 space-y-3">
            <div class="h-4 w-1/5 bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-3 w-full bg-neutral-200 rounded animate-pulse"></div>
            <div class="h-3 w-11/12 bg-neutral-200 rounded animate-pulse"></div>
            <div class="mt-4 h-40 w-full bg-neutral-200 rounded animate-pulse"></div>
        </div>
    </div>
@endsection
