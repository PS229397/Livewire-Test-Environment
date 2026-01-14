<div class="fixed w-full">
    <!-- Succes message -->
    @if ($succesMsg)
    <div
        wire:poll.4s="clearMsg"
        class="fixed mx-auto max-w-sm bg-green-500 text-white text-center px-4 py-2 rounded-lg shadow animate-slide-down">
        Successfully {{ $succesMsg }} item
    </div>
    @endif

    <!-- Add/edit modal -->
    @if ($currentModal === 'add' OR $currentModal === 'edit')
    <!-- <div wire:click="closeModal" class="fixed inset-0 flex items-center justify-center bg-green-500 bg-opacity-50 z-50"></div> -->
    <div wire:click="closeModal" wire:keydown.escape.window="closeModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" style="z-index: 1; cursor: pointer;">
        <div wire:click.stop class="relative inset-0 rounded-lg p-6 w-full max-w-lg bg-white shadow-lg z-60" style="z-index: 10; cursor: default;">
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
                    @error('category')<span class="text-red-500">{{ $message }}</span>@enderror
                    <label class="block mb-1">Category:</label>
                    <select wire:model="category_id" class="p-2 border rounded w-full">
                        <option value="" selected hidden>-- Please select a category --</option>

                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    @error('description')<span class="text-red-500">{{ $message }}</span>@enderror
                    <label class="block mb-1">Description:</label>
                    <textarea wire:model="description" class="p-2 border rounded w-full"></textarea>
                </div>
                <div>
                    @error('price')<span class="text-red-500">{{ $message }}</span>@enderror
                    <label class="block mb-1">Price:</label>
                    <input type="number" wire:model="price" step="0.01" class="p-2 border rounded w-full" />
                </div>

                <div class="space-x-2 mt-4 w-full flex justify-end">
                    <button wire:click="closeModal()" type="button" class="deleteBtn text-white px-4 py-2 rounded">cancel</button>
                    <!-- visually changes submit button from add to edit -->
                    @if ($editingId !== null)
                    <button wire:click="openModal('update', {{ $editingId }})" type="button" class="editBtn text-white px-4 py-2 rounded">Update Item</button>
                    @else
                    <button type="submit" class="addBtn text-white px-4 py-2 rounded">Add Item</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- confirmation modal -->
    @if ($currentModal === 'update' OR $currentModal === 'delete')
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" style="cursor: not-allowed;">
        <div class="relative inset-0 rounded-lg p-6 w-full max-w-lg bg-white shadow-lg" style="cursor: default;">
            <h2 class="text-xl font-semibold mb-4">Confirm {{ $currentModal }}?</h2>
            <p class="mb-4">Are you sure you want to {{ $currentModal }} this item?</p>
            <p class="mb-6 text-red-500 font-bold">This action cannot be undone.</p>
            <div class="flex justify-end space-x-2">
                <button wire:click="closeModal()" class="cancelBtn text-black px-4 py-2 rounded">Cancel</button>
                @if ($currentModal === 'update')
                <button wire:click="updateItem({{ $editingId }})" class="editBtn text-white px-4 py-2 rounded">Update</button>
                @else
                <button wire:click="deleteItem({{ $deletingId }})" class="deleteBtn text-white px-4 py-2 rounded">Delete</button>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Table UI -->
    <div class="p-4 w-full">
        <h1 class="text-4xl font-bold mb-4">Item Manager</h1>
        <div class="mb-6 w-full overflow-x-auto">
            <table class="border rounded-lg shadow-lg" style="width: 70%;"><!-- find a way to fix the tailwind width 70% error -->
                <thead>
                    <!-- searchbar ui -->
                    <tr class="bg-gray-500">
                        <td colspan="5" class="p-2">
                            <input wire:model.live="search" type="text" placeholder="search..." class="px-2 rounded w-full" />
                        </td>
                        <td colspan="1" class="p-2 flex justify-end">
                            <button wire:click="clearSearch" class="cancelBtn text-black font-bold px-2 rounded w-full">Clear search</button>
                        </td>
                    </tr>

                    <!-- colum names and create controll -->
                    <tr class="bg-gray-500 text-white">
                        <th class="border text-center" style="width: 50px;"><button wire:click="sortBy('id')" class="w-full h-full">ID {{ $sortIndicator['id'] ?? '-' }}</button></th>
                        <th class="border" style="width: 250px;"><button wire:click="sortBy('name')" class="w-full h-full">Name {{ $sortIndicator['name'] ?? '-' }}</button></th>
                        <th class="border" style="width: 200px;"><button wire:click="sortBy('category')" class="w-full h-full">Category {{ $sortIndicator['category'] ?? '-' }}</button></th>
                        <th class="border p-2">Description</th>
                        <th class="border text-center" style="width: 100px;"><button wire:click="sortBy('price')" class="w-full h-full">Price {{ $sortIndicator['price'] ?? '-' }}</button></th>
                        <th class="border" style="width: 140px;"> <button wire:click="openModal('add', null)" type="button" class="addBtn text-white px-4 rounded">New item +</button></th>
                    </tr>
                </thead>

                <!-- DB data -->
                <tbody class="overflow-y-scroll">
                    <!-- for each item load data and crud controlls -->
                    @forelse ($items as $item)
                    <tr class=" odd:bg-gray-200 even:bg-gray-400">
                        <td class="border p-2">{{ $item->id }}</td>
                        <td class="border p-2">{{ $item->name }}</td>
                        <td class="border p-2">{{ $item->category->name }}</td>
                        <td class="border p-2">{{ $item->description }}</td>
                        <td class="border p-2">€{{ $item->price }}</td>
                        <td class="border p-2">
                            <button wire:click="openModal('edit', {{ $item->id }})"
                                class="editBtn text-white font-bold px-2 rounded mr-2">
                                Edit
                            </button>
                            <button wire:click="openModal('delete', {{ $item->id }})"
                                class="deleteBtn text-white font-bold px-2 rounded">
                                Delete
                            </button>
                        </td>
                    </tr>

                    <!-- if list empty let the user know in the ui -->
                    @empty
                    <tr>
                        <td colspan="6" class="border p-2 text-center bg-gray-200">
                            No items yet.
                        </td>
                    </tr>
                    @endforelse

                    <!-- filler rows to prevent layout shift -->
                    @for ($i = 0; $i < $fillerRows; $i++ )
                        <tr class=" odd:bg-gray-200 even:bg-gray-400">
                        <td class="border p-2">&nbsp;</td>
                        <td class="border p-2">&nbsp;</td>
                        <td class="border p-2">&nbsp;</td>
                        <td class="border p-2">&nbsp;</td>
                        <td class="border p-2">&nbsp;</td>
                        <td class="border p-2">&nbsp;</td>
                        </tr>
                        @endfor

                        <!-- page controlls -->
                        <tr>
                            <td colspan="6" class="border p-2 text-center bg-gray-200">
                                {{ $items->links() }}
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
