<div>
    <label class="block text-sm font-medium text-gray-700">Name</label>
    <input type="text" name="name" value="{{ old('name', $lead->name ?? '') }}"
           class="mt-1 block w-full border-gray-300 rounded-md">
    @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Email</label>
    <input type="email" name="email" value="{{ old('email', $lead->email ?? '') }}"
           class="mt-1 block w-full border-gray-300 rounded-md">
    @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Phone</label>
    <input type="text" name="phone" value="{{ old('phone', $lead->phone ?? '') }}"
           class="mt-1 block w-full border-gray-300 rounded-md">
    @error('phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Company Name</label>
    <input type="text" name="company_name" value="{{ old('company_name', $lead->company_name ?? '') }}"
           class="mt-1 block w-full border-gray-300 rounded-md">
    @error('company_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <select name="status" class="mt-1 block w-full border-gray-300 rounded-md">
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(old('status', $lead->status ?? 'new') === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
        @error('status') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Source</label>
        <select name="source" class="mt-1 block w-full border-gray-300 rounded-md">
            @foreach ($sources as $source)
                <option value="{{ $source }}" @selected(old('source', $lead->source ?? 'website') === $source)>
                    {{ ucfirst(str_replace('_', ' ', $source)) }}
                </option>
            @endforeach
        </select>
        @error('source') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Assign To</label>
    <select name="assigned_to" class="mt-1 block w-full border-gray-300 rounded-md">
        <option value="">— Unassigned —</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" @selected((string) old('assigned_to', $lead->assigned_to ?? '') === (string) $user->id)>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
    @error('assigned_to') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Notes</label>
    <textarea name="notes" rows="4" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('notes', $lead->notes ?? '') }}</textarea>
    @error('notes') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>