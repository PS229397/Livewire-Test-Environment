<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <h1 class="text-2xl font-bold mb-4">New item</h1>
    <input wire:model.live="newTodo" type="text" placeholder="new item">
    <button wire:click="addTodo" @disabled(empty($newTodo) || !empty($errorMessage) || $isDuplicate) class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Add</button>
    <h3 style="color: red;">{{ $errorMessage }}</h3>
    <br><br>

    <!-- UI for task to do -->
    <h2 class="text-xl font-semibold mt-6 mb-2">Todo List:</h2>
    @foreach($todos as $index => $todo)
    @if ($todo['completed'] == false)
    <li class="mb-2">
        <span>
            {{ $todo['text'] }}
            <button wire:click="toggleCompleted({{ $index }})" class="ml-2 px-2 py-1 bg-green-500 text-white rounded">Done</button>
        </span>
    </li>
    @endif
    @endforeach

    <!-- UI for completed tasks -->
    <h2 class="text-xl font-semibold mt-6 mb-2">Done:</h2>
    @foreach($todos as $index => $todo)
    @if ($todo['completed'] == true)
    <li class="mb-2">
        <span style="text-decoration: line-through; font-style: italic; color: green;">
            {{ $todo['text'] }}
            <button wire:click="removeTodo({{ $index }})" class="ml-2 px-2 py-1 bg-red-500 text-white rounded">Remove</button>
        </span>
    </li>
    @endif
    @endforeach
</div>
