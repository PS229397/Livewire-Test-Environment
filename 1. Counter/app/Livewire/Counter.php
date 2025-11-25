<?php

namespace App\Livewire;

use Livewire\Component;

use function Laravel\Prompts\alert;

class Counter extends Component
{
    public function render()
    {
        return view('livewire.counter');
    }

    //public variable storage
    public $count = 0;
    public $msg = "";

    //function to increment until $count hits 10
    public function increment()
    {
        //if $count is not 10 keep adding to counter, removes $msg if needed
        if ($this->count != 10) {
            $this->count++;
            $this->msg = "";
        }

        //if $count is exactly 10 let the user know it cant go higher in $msg
        if ($this->count == 10) {
            $this->msg = "Count cant be higher than 10.";
        }
    }

    //function to decrement until $count hits -5
    public function decrement()
    {
        //if $count is not -5 keep subtracting from counter, removes $msg if needed
        if ($this->count != -5) {
            $this->count--;
            $this->msg = "";
        }

        //if $count is exactly -5 let the user know it cant go lower in $msg
        if ($this->count == -5) {
            $this->msg = "Count cant be lower than -5.";
        }
    }

    //function to reset $count to 0 also resets $msg
    public function resetCount()
    {
        $this->count = 0;
        $this->msg = "";
    }
}
