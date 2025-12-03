<div>
    <!-- UI for new item input -->
    <h1 class="text-2xl font-bold mb-4">New item</h1>
    <input wire:model.live="newTodo" type="text" placeholder="new item">
    <!-- disable btn if input is empty, any error msgs are diplayed or item is detected as duplicate-->
    <button wire:click="addTodo" @disabled(empty($newTodo) || !empty($errorMessage) || $isDuplicate) class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Add</button>
    <p class="mt-2">Total Items: {{ $totalCount }} | To Do: {{ $todoCount }} | Done: {{ $doneCount }}</p>
    <h3 style="color: red;">{{ $errorMessage }}</h3>

    <!-- UI for task to do -->
    <h2 class="text-xl font-semibold mt-6 mb-2">Todo List:</h2>
    <!-- for each item in todo array where completed is false create a list item and populate it -->
    @foreach($todos as $index => $todo)
    @if ($todo['completed'] == false)
    <li class="mb-2">
        <span>
            <!-- if editingIndex is not equal to current index display the todo with a completion and edit btn -->
            @if ($editingIndex !== $index)
            {{ $todo['text'] }}
            <button wire:click="editTodo({{ $index }})">Edit</button>
            <button wire:click="toggleCompleted({{ $index }})">Done</button>
            @endif

            <!-- if editingIndex is equal to current index replace completion/edit btns with the edit input and save/cancel btns -->
            @if ($editingIndex === $index)
            <input wire:model.live="editedText" type="text">
            <button wire:click="saveEdit({{ $index }})" @disabled(empty($editedText) || !empty($errorMessage) || $isDuplicate === true)>Save</button>
            <button wire:click="cancelEdit">Cancel</button>
            @endif
        </span>
    </li>
    @endif
    @endforeach

    <!-- UI for completed tasks -->
    <h2 class="text-xl font-semibold mt-6 mb-2">Done:</h2>
    <!-- for each item in todo array where completed is true create a list item and populate it -->
    @foreach($todos as $index => $todo)
    @if ($todo['completed'] === true)
    <li class="mb-2">
        <span style="text-decoration: line-through; font-style: italic; color: green;">
            {{ $todo['text'] }}
            <button wire:click="removeTodo({{ $index }})">Remove</button>
        </span>
    </li>
    @endif
    @endforeach
    <br>

    <!-- btn to delete all dones at once, disable btn if doneCount is 0 -->
    <button wire:click="removeAllDone" @disabled($doneCount==0) class="mt-4 px-4 py-2 bg-red-600 text-white rounded">Remove All Done</button>
</div>
