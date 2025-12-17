<div>
    <!-- Add/edit modal -->
    @if ($inputModal === true)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        {{-- Item Form --}}
        <div class="relative inset-0 rounded-lg p-6 w-full max-w-lg bg-white shadow-lg">
            <!-- switch the h2 between add and edit -->
            @if ($editingId !== null)
            <h2 class="text-xl font-semibold mb-2">Edit Existing Item</h2>
            @else
            <h2 class="text-xl font-semibold mb-2">Create New Item</h2>
            @endif

            <!-- switches the form submit action between the add and edit -->
            <form wire:submit.prevent="{{ $editingId === null ? 'createItem' : 'updateItem' }}" class="space-y-4 w-full h-fit">
                <div>
                    @error('name')<span class="text-red-500">{{ $message }}</span>@enderror
                    <label class="block mb-1">Name:</label>
                    <input type="text" wire:model="name" class="p-2 border rounded w-full" />
                </div>
                <div>
                    @error('description')<span class="text-red-500">{{ $message }}</span>@enderror
                    <label class="block mb-1">Description:</label>
                    <textarea wire:model="description" class="p-2 border rounded w-full"></textarea>
                </div>
                <div>
                    @error('price')<span class="text-red-500">{{ $message }}</span>@enderror
                    <label class="block mb-1">Price:</label>
                    <input type="number" wire:model="price" class="p-2 border rounded w-full" />
                </div>

                <div class="space-x-2 mt-4 w-full flex justify-end">
                    <button wire:click="closeModal()" type="button" class="bg-red-500 text-white px-4 py-2 rounded">cancel</button>
                    <!-- visually changes submit button from add to edit -->
                    @if ($editingId !== null)
                    <button wire:click="openModal('update', {{ $editingId }})" type="button" class="bg-blue-500 text-white px-4 py-2 rounded">Update Item</button>
                    @else
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Add Item</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Update Confirmation Modal -->
    @if ($confirmUpdate === true)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="relative inset-0 rounded-lg p-6 w-full max-w-lg bg-white shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Confirm Update</h2>
            <p class="mb-4">Are you sure you want to update this item? {{ $editingId }}</p>
            <p class="mb-6 text-red-500 font-bold">This action cannot be undone.</p>
            <div class="flex justify-end space-x-2">
                <button wire:click="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                <button wire:click="updateItem({{ $editingId }})" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if ($confirmDelete === true)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="relative inset-0 rounded-lg p-6 w-full max-w-lg bg-white shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Confirm Deletion</h2>
            <p class="mb-4">Are you sure you want to delete this item? {{ $deletingId }}</p>
            <p class="mb-6 text-red-500 font-bold">This action cannot be undone.</p>
            <div class="flex justify-end space-x-2">
                <button wire:click="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                <button wire:click="deleteItem({{ $deletingId }})" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
            </div>
        </div>
    </div>
    @endif

    <!-- Table UI -->
    <div class="p-4">
        <h1 class="text-4xl font-bold mb-4">Item Manager</h1>
        <p>{{ $tstMsg }}</p>
        {{-- Item List --}}
        <div class="mb-6">
            <table class=" border rounded-lg shadow-lg">
                <thead>
                    <tr class="bg-gray-500 text-white">
                        <th class="border p-2">ID</th>
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Description</th>
                        <th class="border p-2">Price</th>
                        <th class="border p-2"> <button wire:click="openModal('add', null)" type="button" class="bg-green-500 text-white px-4 rounded">New item +</button></th>
                    </tr>
                </thead>
                <tbody class="overflow-y-scroll">
                    @forelse ($items as $item)
                    <tr class=" odd:bg-gray-200 even:bg-gray-400">
                        <td class="border p-2">{{ $item->id }}</td>
                        <td class="border p-2">{{ $item->name }}</td>
                        <td class="border p-2">{{ $item->description }}</td>
                        <td class="border p-2">{{ $item->price }}</td>
                        <td class="border p-2">
                            <button wire:click="openModal('edit', {{ $item->id }})"
                                class="bg-blue-500 text-white font-bold px-2 rounded mr-2">
                                Edit
                            </button>
                            <button wire:click="openModal('delete', {{ $item->id }})"
                                class="bg-red-500 text-white font-bold px-2 rounded">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="border p-2 text-center bg-gray-200">
                            No items yet.
                        </td>
                    </tr>
                    @endforelse
                    <tr>
                        <td colspan="5" class="border p-2 text-center text-white font-bold bg-gray-500">
                            page 1 >
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
