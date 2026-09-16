<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Lead</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form method="POST" action="{{ route('leads.store') }}" class="space-y-4">
                    @csrf
                    @include('leads._form', ['lead' => null])
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm">Save Lead</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>