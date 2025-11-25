<div>
    <div>
        Counter: {{ $count }}
    </div>
    <button wire:click="decrement" @disabled($count == -5)>-</button>
    <button wire:click="resetCount">Reset</button>
    <button wire:click="increment" @disabled($count == 10)>+</button>
    <div>
        {{ $msg }}
    </div>
</div>
