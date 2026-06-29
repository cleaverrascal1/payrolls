<nav class="flex flex-col gap-1 py-1">
    <a href="/dashboard"
       class="flex items-center gap-4 px-4 py-2 rounded-lg transition
       {{ request()->is('dashboard') ? 'bg-[#347839] text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house-icon lucide-house w-4 h-4"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
        <span class="text-sm">Dashboard</span>
    </a>

    <a href="/positions"
       class="flex items-center gap-4 px-4 py-2 rounded-lg transition
       {{ request()->is('positions*') ? 'bg-[#347839] text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-briefcase-icon lucide-briefcase w-4 h-4"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
        <span class="text-sm">Jabatan</span>
    </a>

    <a href="/employees"
       class="flex items-center gap-4 px-4 py-2 rounded-lg transition
       {{ request()->is('employees*') ? 'bg-[#347839] text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users w-4 h-4"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
        <span class="text-sm">Pegawai</span>
    </a>

    <a href="/attendances"
       class="flex items-center gap-4 px-4 py-2 rounded-lg transition
       {{ request()->is('attendances*') ? 'bg-[#347839] text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-check-icon lucide-calendar-check w-4 h-4"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="m9 16 2 2 4-4"/></svg>
        <span class="text-sm">Kehadiran</span>
    </a>

{{--    <a href="/zoho-sales"--}}
{{--       class="flex items-center gap-4 px-4 py-2 rounded-lg transition--}}
{{--       {{ request()->is('zoho-sales*') ? 'bg-[#347839] text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">--}}
{{--        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-no-axes-combined-icon lucide-chart-no-axes-combined w-4 h-4"><path d="M12 16v5"/><path d="M16 14.639V21"/><path d="M20 10.656V21"/><path d="m22 3-8.646 8.646a.5.5 0 0 1-.708 0L9.354 8.354a.5.5 0 0 0-.707 0L2 15"/><path d="M4 18.463V21"/><path d="M8 14.656V21"/></svg>--}}
{{--        <span class="text-sm">Penjualan Zoho</span>--}}
{{--    </a>--}}

{{--    <a href="/cash-advances"--}}
{{--       class="flex items-center gap-4 px-4 py-2 rounded-lg transition--}}
{{--       {{ request()->is('cash-advances*') ? 'bg-[#347839] text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">--}}
{{--        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hand-coins-icon lucide-hand-coins w-4 h-4"><path d="M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17"/><path d="m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"/><path d="m2 16 6 6"/><circle cx="16" cy="9" r="2.9"/><circle cx="6" cy="5" r="3"/></svg>--}}
{{--        <span class="text-sm">Kasbon</span>--}}
{{--    </a>--}}

    <a href="/payrolls"
       class="flex items-center gap-4 px-4 py-2 rounded-lg transition
       {{ request()->is('payrolls*') ? 'bg-[#347839] text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wallet-icon lucide-wallet w-4 h-4"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
        <span class="text-sm">Penggajian</span>
    </a>
</nav>
