<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <h1 class="text-2xl font-bold mb-4">New item</h1>
    <input wire:model.live="newTodo" type="text" placeholder="new item">
    <button wire:click="addTodo" @disabled(empty($newTodo)) class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Add</button>
    <br><br>

    <h2 class="text-xl font-semibold mt-6 mb-2">Todo List:</h2>
    @foreach($todos as $index => $todo)
    <li class="mb-2">
        {{ $todo }}
        <button wire:click="removeTodo({{ $loop->index }})" class="ml-2 px-2 py-1 bg-red-500 text-white rounded">Remove</button>
    </li>
    @endforeach
</div>
