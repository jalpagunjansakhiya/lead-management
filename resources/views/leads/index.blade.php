<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Leads</h2>
            <a href="{{ route('leads.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm">
                + Add Lead
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded">{{ session('error') }}</div>
            @endif

            {{-- Search & filter --}}
            <form method="GET" action="{{ route('leads.index') }}" class="bg-white p-4 rounded shadow flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-sm text-gray-600">Search</label>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                           placeholder="Name, email or phone"
                           class="border-gray-300 rounded-md text-sm">
                </div>
                <div>
                    <label class="block text-sm text-gray-600">Status</label>
                    <select name="status" onchange="this.form.submit()" class="border-gray-300 rounded-md text-sm">                        <option value="">All</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-600">Source</label>
                    <select name="source" onchange="this.form.submit()" class="border-gray-300 rounded-md text-sm">                        <option value="">All</option>
                        @foreach ($sources as $source)
                            <option value="{{ $source }}" @selected(($filters['source'] ?? '') === $source)>
                                {{ ucfirst(str_replace('_', ' ', $source)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded-md text-sm">Filter</button>
                <a href="{{ route('leads.index') }}" class="px-4 py-2 border rounded-md text-sm">Reset</a>

                <a href="{{ route('leads.export', $filters) }}" class="ml-auto px-4 py-2 bg-green-700 text-white rounded-md text-sm">
                    Export to CSV
                </a>
            </form>

            {{-- Table --}}
            <div class="bg-white rounded shadow overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Phone</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Source</th>
                            <th class="px-4 py-2">Assigned To</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($leads as $lead)
                            <tr class="border-t">
                                <td class="px-4 py-2">
                                    <a href="{{ route('leads.show', $lead) }}" class="text-blue-600">{{ $lead->name }}</a>
                                </td>
                                <td class="px-4 py-2">{{ $lead->email }}</td>
                                <td class="px-4 py-2">{{ $lead->phone ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    {{-- Quick status update, no full edit form --}}
                                    <form method="POST" action="{{ route('leads.status', $lead) }}">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="border-gray-300 rounded text-xs">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status }}" @selected($lead->status === $status)>
                                                    {{ ucfirst($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td class="px-4 py-2">{{ ucfirst(str_replace('_', ' ', $lead->source)) }}</td>
                                <td class="px-4 py-2">{{ $lead->assignedTo->name ?? '— unassigned —' }}</td>
                                <td class="px-4 py-2 space-x-2 whitespace-nowrap">
                                    <a href="{{ route('leads.edit', $lead) }}" class="text-indigo-600">Edit</a>
                                    @can('delete', $lead)
                                        <form method="POST" action="{{ route('leads.destroy', $lead) }}" class="inline"
                                              onsubmit="return confirm('Delete this lead? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600">Delete</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">No leads found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $leads->links() }}
        </div>
    </div>
</x-app-layout>