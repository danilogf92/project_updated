<div class="grid grid-cols-1 md:grid-cols-7 gap-3 bg-white p-4 rounded-lg shadow">

    <!-- Years -->
    <select wire:model.live="year" class="px-3 py-2 border rounded text-sm text-gray-700">
        <option value="all">Year</option>
        @foreach ($filterOptions['years'] as $year)
            <option value="{{ $year }}">{{ $year }}</option>
        @endforeach
    </select>

    <!-- Project Types -->
    <select wire:model.live="projectType" class="px-3 py-2 border rounded text-sm text-gray-700">
        <option value="all">Type of Project</option>
        @foreach ($filterOptions['projectTypes'] as $type)
            <option value="{{ $type }}">{{ $type }}</option>
        @endforeach
    </select>

    <!-- States -->
    <select wire:model.live="state" class="px-3 py-2 border rounded text-sm text-gray-700">
        <option value="all">State</option>
        @foreach ($filterOptions['states'] as $state)
            <option value="{{ $state }}">{{ $state }}</option>
        @endforeach
    </select>

    <!-- Currency -->
    <select wire:model.live="currency" class="px-3 py-2 border rounded text-sm text-gray-700">
        <option value="euro">Euro €</option>
        <option value="dollar">Dollar $</option>
    </select>

    <!-- Rate -->
    <input type="number" wire:model.live="rateValue" placeholder="Exchange rate"
        class="px-3 py-2 border rounded text-sm text-gray-700" />

    <!-- Justifications -->
    <select wire:model.live="justification" class="px-3 py-2 border rounded text-sm text-gray-700">
        <option value="all">Justification</option>
        @foreach ($filterOptions['justifications'] as $j)
            <option value="{{ $j }}">{{ $j }}</option>
        @endforeach
    </select>

    <!-- Plants -->
    <select wire:model.live="plant" class="px-3 py-2 border rounded text-sm text-gray-700">
        <option value="all">Plants</option>
        @foreach ($filterOptions['plants'] as $key => $label)
            <option value="{{ $key }}">{{ $label }}</option>
        @endforeach
    </select>

</div>
