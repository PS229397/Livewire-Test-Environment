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

    public $count = 0;
    public $msg = "";

    public function increment()
    {
        if ($this->count != 10) {
            $this->count++;
            $this->msg = "";
        } else {
            $this->msg = "Count cant be higher than 10.";
        }
    }
    public function decrement()
    {
        if ($this->count != -5) {
            $this->count--;
            $this->msg = "";
        } else {
            $this->msg = "Count cant be lower than -5.";
        }
    }
    public function resetCount()
    {
        $this->count = 0;
        $this->msg = "";
    }
}
