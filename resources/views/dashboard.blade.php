<x-layouts.app :title="__('Dashboard')">

    <livewire:dashboard-filters :filterOptions="$dashboardData['filterOptions']" />
    {{-- <x-main-metrics :metrics="$dashboardData['mainMetrics']" /> --}}
    @livewire('dashboard-metrics')

    {{ dd($dashboardData) }}
    {{-- {{ dd($dashboardData['filterOptions']) }} --}}


</x-layouts.app>
