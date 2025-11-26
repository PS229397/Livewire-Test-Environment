<?php

namespace App\Livewire;

use Livewire\Component;

class TodoList extends Component
{
    //global variable list
    public $newTodo = '';
    public $todos = [];

    public function render()
    {
        return view('livewire.todo-list');
    }

    //function to add an item to the todo list
    public function addTodo(){
        //adds text from the newTodo input into the todos array
        $this->todos[] = $this->newTodo;
        //clears the newTodo input for the next item
        $this->newTodo = '';
    }

    //function to remove specified item out of the todo list $index gets passed down from button
    public function removeTodo($index){
        //removes the specified item at $index from the todos array
        unset($this->todos[$index]);
        //makes a duplicate of the array with all remaining items nicely indexed, pushes it to the todos array
        $this->todos = array_values($this->todos);
    }
}
