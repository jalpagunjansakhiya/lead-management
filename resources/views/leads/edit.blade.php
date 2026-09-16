<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Lead</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form method="POST" action="{{ route('leads.update', $lead) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    @include('leads._form', ['lead' => $lead])
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm">Update Lead</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>