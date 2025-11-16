<div class="min-h-screen bg-blue-50 py-4 rounded-sm">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-4">
            <h1 class="text-3xl font-bold text-gray-900 text-center">Projects</h1>
            <div class="flex justify-between items-center">
                <p class="mt-2 text-gray-600">Manage and view all projects in the system</p>

                <div class="mt-6">
                    <button
                        class="cursor-pointer inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Create Project
                    </button>
                </div>
            </div>

        </div>

        <!-- Filters and Search -->
        <div class="mb-6 rounded-lg bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <!-- Search -->
                <div class="flex-1">
                    <div class="relative max-w-md">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" wire:model.live="search" placeholder="Search projects..."
                            class="block w-full rounded-lg border border-gray-300 pl-10 pr-4 py-2 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Filters -->
                <div class="flex flex-wrap gap-3">
                    <!-- Year Filter -->
                    <select wire:model.live="yearFilter"
                        class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All years</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>

                    <!-- Status Filter -->
                    <select wire:model.live="stateFilter"
                        class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All statuses</option>
                        @foreach ($states as $state)
                            <option value="{{ $state }}">{{ $state }}</option>
                        @endforeach
                    </select>

                    <!-- Company Filter -->
                    <select wire:model.live="companyFilter"
                        class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All companies</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>

                    <!-- Investment Filter -->
                    <select wire:model.live="investmentFilter"
                        class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All types</option>
                        @foreach ($investments as $investment)
                            <option value="{{ $investment }}">{{ $investment }}</option>
                        @endforeach
                    </select>

                    <!-- Clear Filters Button -->
                    <button wire:click="clearFilters" x-data
                        @click="
        const el = $el;
        setTimeout(() => el.blur(), 2000);
    "
                        class="cursor-pointer inline-flex items-center gap-2 rounded-lg 
           border border-yellow-500 bg-yellow-400 
           px-4 py-2 text-sm font-medium text-gray-800 
           shadow-sm transition-all duration-200 
           hover:bg-yellow-300 hover:shadow-md 
           focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear
                    </button>


                </div>
            </div>
        </div>

        <!-- Results Counter -->
        <div class="mb-4 flex items-center justify-between">
            <p class="text-sm text-gray-600">
                Showing {{ $projects->firstItem() ?: 0 }} - {{ $projects->lastItem() ?: 0 }} of
                {{ $projects->total() }} projects
                @if ($yearFilter)
                    in {{ $yearFilter }}
                @endif
            </p>

            <!-- Items per page -->
            <select wire:model.live="perPage"
                class="rounded-lg border border-gray-300 px-3 py-1 text-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="6">6 per page</option>
                <option value="12">12 per page</option>
                <option value="24">24 per page</option>
                <option value="48">48 per page</option>
            </select>
        </div>

        <!-- Projects Grid -->
        @if ($projects->count() > 0)
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $project)
                    <div
                        class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm transition-all duration-200 hover:shadow-md">
                        <!-- Header -->
                        <div class="border-b border-gray-100 bg-gray-50 px-4 py-3">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <h3 class="truncate text-lg font-semibold text-gray-900"
                                        title="{{ $project->name }}">
                                        {{ $project->name }}
                                    </h3>
                                    <div class="mt-1 flex items-center gap-2">
                                        <span
                                            class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800">
                                            {{ $project->pda_code }}
                                        </span>
                                        <span class="text-xs text-gray-500 truncate"
                                            title="{{ $project->company->name }}">
                                            {{ $project->company->name }}
                                        </span>
                                    </div>
                                </div>
                                @php
                                    $stateColors = [
                                        'Planification' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'Execution' => 'bg-green-100 text-green-800 border-green-200',
                                        'Finished' => 'bg-gray-100 text-gray-800 border-gray-200',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-medium {{ $stateColors[$project->state] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $project->state }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <div class="space-y-3">
                                <!-- Basic Information -->
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="font-medium text-gray-500">Type:</span>
                                        <p class="text-gray-900 truncate" title="{{ $project->investments }}">
                                            {{ $project->investments }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-500">Classification:</span>
                                        <p class="text-gray-900 truncate"
                                            title="{{ $project->classification_of_investments }}">
                                            {{ $project->classification_of_investments }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Rate and Justification -->
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="font-medium text-gray-500">Rate:</span>
                                        <p class="text-gray-900 font-mono">{{ number_format($project->rate, 3) }}</p>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-500">Justification:</span>
                                        <p class="text-gray-900">{{ $project->justification }}</p>
                                    </div>
                                </div>

                                <!-- Dates -->
                                <div class="border-t border-gray-100 pt-3">
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="font-medium text-gray-500">Start:</span>
                                            <p class="text-gray-900">{{ $project->start_date->diffForHumans() }}</p>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-500">End:</span>
                                            <p class="text-gray-900">{{ $project->finish_date->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Data Status -->
                                <div class="flex items-center justify-between border-t border-gray-100 pt-3">
                                    <span class="text-sm font-medium text-gray-500">Data uploaded:</span>
                                    <span class="inline-flex items-center">
                                        @if ($project->data_uploaded)
                                            <svg class="h-5 w-5 text-green-500" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="border-t border-gray-100 bg-gray-50 px-4 py-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">
                                    Created: {{ $project->created_at->format('m/d/Y') }}
                                </span>
                                <button
                                    class="rounded-md bg-blue-600 px-3 py-1.5 text-xs font-medium text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $projects->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="rounded-lg border-2 border-dashed border-gray-300 bg-white p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No projects found</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if ($search || $stateFilter || $companyFilter || $investmentFilter || $yearFilter)
                        Try adjusting your search filters
                    @else
                        There are no projects registered in the system
                    @endif
                </p>
                <div class="mt-6">
                    <button
                        class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Create Project
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
