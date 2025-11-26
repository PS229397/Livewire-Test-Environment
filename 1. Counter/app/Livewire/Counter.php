<?php

namespace App\Livewire;

use Carbon\Traits\ToStringFormat;
use Livewire\Component;

use function Laravel\Prompts\alert;

class Counter extends Component
{
    //public variable storage
    public $count = 0;
    public $msg = "";
    public $history = [];

    //render the livewire component also initializes $history with current $count
    public function render()
    {
        if (empty($this->history)) {
            $this->history[] = $this->count;
        }

        return view('livewire.counter');
    }

    //function to increment until $count hits 10
    public function increment()
    {
        //if $count is not 10 keep adding to counter, removes $msg if needed, stores $count in $history
        if ($this->count != 10) {
            $this->count++;
            $this->msg = "";
        }

        //if $count is exactly 10 let the user know it cant go higher in $msg
        if ($this->count == 10) {
            $this->msg = "Count cant be higher than 10.";
        }

        //calls the updateHistory logic after press
        $this->updateHistory();
    }

    //function to decrement until $count hits -5
    public function decrement(): void
    {
        //if $count is not -5 keep subtracting from counter, removes $msg if needed, stores $count in $history
        if ($this->count != -5) {
            $this->count--;
            $this->msg = "";
        }

        //if $count is exactly -5 let the user know it cant go lower in $msg
        if ($this->count == -5) {
            $this->msg = "Count cant be lower than -5.";
        }

        //calls the updateHistory logic after press
        $this->updateHistory();
    }

    //function to reset $count to 0, resets $msg, stores $count in $history
    public function resetCount()
    {
        $this->count = 0;
        $this->msg = "";

        //calls the updateHistory logic after press
        $this->updateHistory();
    }

    //function to keep track of the last 5 numbers being displayed
    public function updateHistory(): void
    {
        $this->history[] = $this->count;

        // removes oldest $history entry if more than 5 entries exist
        if (count($this->history) > 5) {
            array_shift($this->history);
        }
    }
}
