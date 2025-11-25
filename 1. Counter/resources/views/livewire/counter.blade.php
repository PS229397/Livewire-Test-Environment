<div>
    <div>
        Counter: {{ $count }}
    </div>
    <button wire:click="decrement">-</button>
    <button wire:click="resetCount">Reset</button>
    <button wire:click="increment">+</button>
    <div>
        {{ $msg }}
    </div>
</div>
