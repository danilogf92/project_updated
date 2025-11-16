<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 py-2">

    <!-- Total Projects -->
    <div class="rounded-lg border bg-white p-4 shadow-sm">
        <p class="text-sm text-gray-500">Total Projects</p>
        <p class="mt-2 text-2xl font-bold text-gray-900">{{ $metrics['total_projects'] }}</p>
    </div>

    <!-- Budgeted -->
    <div class="rounded-lg border bg-white p-4 shadow-sm">
        <p class="text-sm text-gray-500">Budgeted</p>
        <p class="mt-2 text-2xl font-bold text-gray-900">
            {{ number_format($metrics['budgeted'], 2) }} {{ $metrics['currency'] === 'euro' ? '€' : '$' }}
        </p>
    </div>

    <!-- Booked -->
    <div class="rounded-lg border bg-white p-4 shadow-sm">
        <p class="text-sm text-gray-500">Booked</p>
        <p class="mt-2 text-2xl font-bold text-gray-900">
            {{ number_format($metrics['booked'], 2) }} {{ $metrics['currency'] === 'euro' ? '€' : '$' }}
        </p>
    </div>

    <!-- Executed -->
    <div class="rounded-lg border bg-white p-4 shadow-sm">
        <p class="text-sm text-gray-500">Executed</p>
        <p class="mt-2 text-2xl font-bold text-gray-900">
            {{ number_format($metrics['executed'], 2) }} {{ $metrics['currency'] === 'euro' ? '€' : '$' }}
        </p>
    </div>

    <!-- Capex Percentage -->
    <div class="rounded-lg border bg-white p-4 shadow-sm">
        <p class="text-sm text-gray-500">Capex Percentage</p>
        <p class="mt-2 text-2xl font-bold text-gray-900">{{ $metrics['capex_percentage'] }}%</p>
    </div>

</div>
