<div class="mb-6 max-w-64">
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <h1 class="text-4xl font-bold mb-4">Item Manager</h1>

    {{-- Item Creation Form --}}
    <div>
        <h2 class="text-xl font-semibold mb-2">Create New Item</h2>
        <form wire:submit.prevent="createItem" class="space-y-4">
            <div>
                <label class="block mb-1">Name:</label>
                <input type="text" wire:model="name" class="w-full p-2 border rounded" />
            </div>
            <div>
                <label class="block mb-1">Description:</label>
                <textarea wire:model="description" class="w-full p-2 border rounded"></textarea>
            </div>
            <div>
                <label class="block mb-1">Price:</label>
                <input type="number" wire:model="price" class="w-full p-2 border rounded" />
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Item</button>
        </form>
    </div>
</div>
