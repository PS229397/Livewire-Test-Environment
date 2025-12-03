<?php

//! ========================== TODO ========================== //
//! refine errorchecking to be a singular function
//! ========================================================== //

namespace App\Livewire;

use Livewire\Component;

class TodoList extends Component
{
    //? default livewire render function
    public function render()
    {
        return view('livewire.todo-list');
    }

    //^global variable list
    public $newTodo = '';
    public $input = '';
    public $todos = [];
    public $todoCount = 0;
    public $doneCount = 0;
    public $totalCount = 0;
    public $isDuplicate = false;
    public $editingIndex = null;
    public $editedText = '';
    public $errorMessage = null;



    //? function to add an item to the todo list
    public function addTodo()
    {
        //adds text from the newTodo input into the todos array
        $this->todos[] = ['text' => $this->newTodo, 'completed' => false];

        //clears the newTodo input for the next item
        $this->newTodo = '';

        //increments the todoCount and totalCount by 1
        $this->todoCount++;
        $this->totalCount++;
    }

    //? function to edit selected todo item
    public function editTodo($index)
    {
        //makes sure newTodo input is empty when editing
        $this->newTodo = '';

        //if btn is clicked, set editingIndex to current index to trigger input mode
        $this->editingIndex = $index;
        $this->editedText = $this->todos[$index]['text'] ?? '';
    }

    //? function to save the edited todo and restructure the array
    public function saveEdit($index)
    {
        //if btn is clicked, update the todo item at the specified index with the edited text
        if ($this->editingIndex === $index && isset($this->todos[$index])) {
            $this->todos[$index]['text'] = $this->editedText;
        }

        //reset checks to default
        $this->editingIndex = null;
        $this->editedText = '';
    }

    //? function to cancel the edit action and revert to the original value
    public function cancelEdit()
    {
        //if btn is clicked set editingIndex to null to cancel input mode
        $this->editingIndex = null;

        //reset checks to default
        $this->isDuplicate = false;
        $this->errorMessage = null;
    }

    //? function that triggers when the newTodo input is updated using an [active watcher (updated+variable name)] passes it to checkforbidden
    public function updatedNewTodo($value)
    {
        //passes value to forbidden char function
        $this->checkForbiddenChar($value);

        //makes sure editing mode is off on input change
        $this->editingIndex = null;
    }

    //? function that triggers when the editedText input is updated using an [active watcher (updated+variable name)] passes it to checkforbidden
    public function updatedEditedText($value)
    {
        $this->checkForbiddenChar($value);
    }

    //? function to check for forbidden characters in add and edit todo inputs
    public function checkForbiddenChar($value)
    {
        //trims the value to combat spaces in front or behind the input
        $input = trim($value);

        //reset checks to default
        $this->isDuplicate = false;
        $this->errorMessage = null;

        //defines forbidden characters
        $forbiddenCharacters = ['$', '@', '%', '#', '<', '>'];

        //check for forbidden characters in $value using haystack method
        foreach ($forbiddenCharacters as $char) {
            //if forbidden character is detected, show user errormessage and stop further checks
            if (str_contains($input, $char)) {
                $this->errorMessage = "your item contains a forbidden character: {$char}";
                return;
            }

            //patch solution to only allow this if function to run when an editing index is present (nested if statements are bad habits)
            if ($this->editingIndex !== null) {
                //if the edited text is the same as the original, skip duplicate check
                if ($input === $this->todos[$this->editingIndex]['text']) {
                    return;
                }
            }

            //if no forbidden character is detected, proceed to duplicate check
            $this->checkDuplicate($input);
        }
    }

    //? function to check for duplicate items in the todo list
    public function checkDuplicate($value)
    {
        foreach ($this->todos as $todo) {
            //if duplicate is detected, set isDuplicate to true and show user errormessage
            if (strtolower($todo['text']) === strtolower($value)) {
                $this->isDuplicate = true;
                $this->errorMessage = "this item is already in your todo list";
                return;
            }
        }
    }

    //? function to toggle the completed status of the specified item to done in the todo list, $index gets passed down from button
    public function toggleCompleted($index)
    {
        //toggles the completed status of the specified item at $index in the todos array
        $this->todos[$index]['completed'] = ! $this->todos[$index]['completed'];

        //updates the todoCount and doneCount accordingly
        $this->todoCount--;
        $this->doneCount++;
    }

    //? function to remove specified item out of the todo list $index gets passed down from button
    public function removeTodo($index)
    {
        //removes the specified item at $index from the todos array
        unset($this->todos[$index]);
        //makes a duplicate of the array with all remaining items nicely indexed, pushes it to the todos array
        $this->todos = array_values($this->todos);
        // re-check the current input against the updated list
        if (!empty($this->newTodo)) {
            $this->updatedNewTodo($this->newTodo);
        }
        //decrements the doneCount and totalCount by 1
        $this->doneCount--;
        $this->totalCount--;
    }

    //? function to remove all done items from the todo list
    public function removeAllDone()
    {
        //loop through todos array and remove all completed items
        foreach ($this->todos as $index => $todo) {
            if ($todo['completed'] == true) {
                unset($this->todos[$index]);
                $this->doneCount--;
                $this->totalCount--;
            }
        }
        //reindex the todos array
        $this->todos = array_values($this->todos);
    }
}
