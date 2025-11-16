<div class="min-h-screen bg-gray-50 py-6">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Header con Información del Proyecto -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('projects') }}"
                            class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Projects
                        </a>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $project->name }}</h1>
                    <div class="mt-2 flex flex-wrap items-center gap-4">
                        <span
                            class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800">
                            {{ $project->pda_code }}
                        </span>
                        <span class="text-gray-600">{{ $project->company->name }}</span>
                        @php
                            $stateColors = [
                                'Planification' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'Execution' => 'bg-green-100 text-green-800 border-green-200',
                                'Finished' => 'bg-gray-100 text-gray-800 border-gray-200',
                            ];
                        @endphp
                        <span
                            class="inline-flex items-center rounded-full border px-3 py-1 text-sm font-medium {{ $stateColors[$project->state] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $project->state }}
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Rate: <span
                            class="font-mono font-semibold">{{ number_format($project->rate, 3) }}</span></p>
                    <p class="text-sm text-gray-600">Created: {{ $project->created_at->format('m/d/Y') }}</p>
                </div>
            </div>

            <!-- Información Adicional del Proyecto -->
            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-lg bg-white p-4 shadow-sm border">
                    <h3 class="text-sm font-medium text-gray-500">Investment Type</h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $project->investments }}</p>
                </div>
                <div class="rounded-lg bg-white p-4 shadow-sm border">
                    <h3 class="text-sm font-medium text-gray-500">Classification</h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $project->classification_of_investments }}
                    </p>
                </div>
                <div class="rounded-lg bg-white p-4 shadow-sm border">
                    <h3 class="text-sm font-medium text-gray-500">Justification</h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $project->justification }}</p>
                </div>
            </div>
        </div>

        <!-- Resumen de Totales -->
        <div class="mb-6 grid grid-cols-2 gap-4 md:grid-cols-4">
            <div class="rounded-lg bg-blue-50 p-4 border border-blue-200">
                <h3 class="text-sm font-medium text-blue-800">Total Global Price</h3>
                <p class="mt-1 text-2xl font-bold text-blue-900">${{ number_format($totals['global_price'], 2) }}</p>
                <p class="text-sm text-blue-700">€{{ number_format($totals['global_price_euros'], 2) }}</p>
            </div>
            <div class="rounded-lg bg-green-50 p-4 border border-green-200">
                <h3 class="text-sm font-medium text-green-800">Total Executed</h3>
                <p class="mt-1 text-2xl font-bold text-green-900">${{ number_format($totals['executed_dollars'], 2) }}
                </p>
                <p class="text-sm text-green-700">€{{ number_format($totals['executed_euros'], 2) }}</p>
            </div>
            <div class="rounded-lg bg-orange-50 p-4 border border-orange-200">
                <h3 class="text-sm font-medium text-orange-800">Total Real Value</h3>
                <p class="mt-1 text-2xl font-bold text-orange-900">${{ number_format($totals['real_value'], 2) }}</p>
            </div>
            <div class="rounded-lg bg-purple-50 p-4 border border-purple-200">
                <h3 class="text-sm font-medium text-purple-800">Total Booked</h3>
                <p class="mt-1 text-2xl font-bold text-purple-900">${{ number_format($totals['booked'], 2) }}</p>
            </div>
        </div>

        <!-- Búsqueda y Filtros -->
        <div class="mb-6 rounded-lg bg-white p-4 shadow-sm border">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex-1">
                    <div class="relative max-w-md">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" wire:model.live="search" placeholder="Search data records..."
                            class="block w-full rounded-lg border border-gray-300 pl-10 pr-4 py-2 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <select wire:model.live="perPage"
                    class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="10">10 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                    <option value="100">100 per page</option>
                </select>
            </div>
        </div>

        <!-- Tabla de Datos -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden border">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Project Data Records</h3>
                <p class="mt-1 text-sm text-gray-500">Detailed information for all data entries in this project.</p>
            </div>

            @if ($dataRecords->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th wire:click="sortBy('area')"
                                    class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Area
                                </th>
                                <th wire:click="sortBy('group_1')"
                                    class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Group 1
                                </th>
                                <th wire:click="sortBy('group_2')"
                                    class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Group 2
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th wire:click="sortBy('qty')"
                                    class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Qty
                                </th>
                                <th wire:click="sortBy('unit_price')"
                                    class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Unit Price
                                </th>
                                <th wire:click="sortBy('global_price')"
                                    class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Global Price
                                </th>
                                <th wire:click="sortBy('percentage')"
                                    class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    %
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($dataRecords as $record)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->area }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $record->group_1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $record->group_2 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate"
                                        title="{{ $record->description }}">
                                        {{ Str::limit($record->description, 50) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->qty }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($record->unit_price, 2) }}</td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium 
                                        {{ $record->global_price > 10000 ? 'text-green-600' : 'text-gray-900' }}">
                                        ${{ number_format($record->global_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full"
                                                    style="width: {{ $record->percentage }}%"></div>
                                            </div>
                                            <span class="ml-2 text-gray-600">{{ $record->percentage }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
                    {{ $dataRecords->links() }}
                </div>
            @else
                <div class="px-4 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No data records found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if ($search)
                            Try adjusting your search terms
                        @else
                            No data has been uploaded for this project yet
                        @endif
                    </p>
                </div>
            @endif
        </div>

        <!-- Contador de Resultados -->
        @if ($dataRecords->count() > 0)
            <div class="mt-4 text-sm text-gray-600">
                Showing {{ $dataRecords->firstItem() }} - {{ $dataRecords->lastItem() }} of
                {{ $dataRecords->total() }} data records
            </div>
        @endif
    </div>
</div>
