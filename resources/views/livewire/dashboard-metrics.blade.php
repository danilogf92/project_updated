<div class="py-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">

        <!-- Total Projects -->
        <div class="p-4 rounded-xl border bg-white dark:bg-zinc-800 shadow-sm flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Projects</h3>
                <x-heroicon-o-briefcase class="w-5 h-5 text-blue-500" />
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $metrics['total_projects'] ?? 0 }}
            </p>
        </div>

        <!-- Total Budget -->
        <div class="p-4 rounded-xl border bg-white dark:bg-zinc-800 shadow-sm flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Budget</h3>
                <x-heroicon-o-banknotes class="w-5 h-5 text-green-500" />
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                € {{ number_format($metrics['budgeted'] ?? 0, 2) }}
            </p>
        </div>

        <!-- Total Booked -->
        <div class="p-4 rounded-xl border bg-white dark:bg-zinc-800 shadow-sm flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Booked</h3>
                <x-heroicon-o-check-badge class="w-5 h-5 text-indigo-500" />
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                € {{ number_format($metrics['booked'] ?? 0, 2) }}
            </p>
        </div>

        <!-- Total Executed -->
        <div class="p-4 rounded-xl border bg-white dark:bg-zinc-800 shadow-sm flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Executed</h3>
                <x-heroicon-o-rocket-launch class="w-5 h-5 text-purple-500" />
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                € {{ number_format($metrics['executed'] ?? 0, 2) }}
            </p>
        </div>

        <!-- Capex % -->
        <div class="p-4 rounded-xl border bg-white dark:bg-zinc-800 shadow-sm flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Capex %</h3>
                <x-heroicon-o-chart-pie class="w-5 h-5 text-orange-500" />
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $metrics['capex_percentage'] ?? 0 }}%
            </p>
        </div>

    </div>
</div>
