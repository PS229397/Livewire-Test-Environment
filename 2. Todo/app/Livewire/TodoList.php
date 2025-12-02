<?php

// ========================== TODO ========================== //
// extend the remove done function to remove all dones at once
// add a counter for total todos and dones
// add an inline edit function
// ========================================================== //

namespace App\Livewire;

use Livewire\Component;

class TodoList extends Component
{
    // default livewire render function
    public function render()
    {
        return view('livewire.todo-list');
    }

    //global variable list
    public $newTodo = '';
    public $todos = [];
    public $isDuplicate = false;
    public $errorMessage = null;


    //function to add an item to the todo list
    public function addTodo()
    {
        //adds text from the newTodo input into the todos array
        $this->todos[] = ['text'=> $this->newTodo, 'completed'=>false];
        //clears the newTodo input for the next item
        $this->newTodo = '';
    }

    //function that triggers when the newTodo input is updated using an [active watcher (updated+variable name)]
    public function updatedNewTodo($value)
    {
        //reset checks to default
        $this->isDuplicate = false;
        $this->errorMessage = null;

        //defines forbidden characters
        $forbiddenCharacters = ['$', '@', '%', '#', '<', '>'];

        //check for forbidden characters in $value using haystack method
        foreach ($forbiddenCharacters as $char) {
            //if forbidden character is detected, show user errormessage and stop further checks
            if (str_contains($value, $char)) {
                $this->errorMessage = "your item contains a forbidden character: {$char}";
                return;
            }

            //if no forbidden character is detected, proceed to duplicate check
            $this->checkDuplicate($value);
        }
    }

    //function to check for duplicate items in the todo list
    public function checkDuplicate($value) {
        foreach ($this->todos as $todo) {
            //if duplicate is detected, set isDuplicate to true and show user errormessage
            if (strtolower($todo['text']) === strtolower($value)) {
                $this->isDuplicate = true;
                $this->errorMessage = "this item is already in your todo list";
                return;
            }
        }
    }

    public function toggleCompleted($index)
    {
        $this->todos[$index]['completed'] = ! $this->todos[$index]['completed'];
    }

    //function to remove specified item out of the todo list $index gets passed down from button
    public function removeTodo($index)
    {
        //removes the specified item at $index from the todos array
        unset($this->todos[$index]);
        //makes a duplicate of the array with all remaining items nicely indexed, pushes it to the todos array
        $this->todos = array_values($this->todos);
    }
}
