<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $lead->name }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow space-y-3">
                <p><strong>Email:</strong> {{ $lead->email }}</p>
                <p><strong>Phone:</strong> {{ $lead->phone ?? '-' }}</p>
                <p><strong>Company:</strong> {{ $lead->company_name ?? '-' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($lead->status) }}</p>
                <p><strong>Source:</strong> {{ ucfirst(str_replace('_', ' ', $lead->source)) }}</p>
                <p><strong>Assigned To:</strong> {{ $lead->assignedTo->name ?? '— unassigned —' }}</p>
                <p><strong>Created By:</strong> {{ $lead->creator->name ?? '-' }}</p>
                <p><strong>Notes:</strong><br>{{ $lead->notes ?? '-' }}</p>

                <div class="pt-4 space-x-3">
                    <a href="{{ route('leads.edit', $lead) }}" class="text-indigo-600">Edit</a>
                    <a href="{{ route('leads.index') }}" class="text-gray-600">← Back to list</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>