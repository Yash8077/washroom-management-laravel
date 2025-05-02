{{-- This would contain the navigation links for the admin section --}}
<nav class="mt-5 space-y-1">
    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>
    <x-nav-link :href="route('admin.locations.index')" :active="request()->routeIs('admin.locations.*')">
        {{ __('Locations') }}
    </x-nav-link>
    <x-nav-link :href="route('admin.tasks.index')" :active="request()->routeIs('admin.tasks.*')">
        {{ __('Tasks') }}
    </x-nav-link>
    <x-nav-link :href="route('admin.issues.index')" :active="request()->routeIs('admin.issues.*')">
        {{ __('Issues') }}
    </x-nav-link>
     <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
        {{ __('Users') }}
    </x-nav-link>
     <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
        {{ __('Reports') }}
    </x-nav-link>
    {{-- Add more links as needed --}}
</nav>