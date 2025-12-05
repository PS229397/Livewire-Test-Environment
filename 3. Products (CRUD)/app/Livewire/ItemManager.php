<?php

namespace App\Livewire;

use Livewire\Component;

class ItemManager extends Component
{
    //^component properties
    public $items;
    public $name;
    public $description;
    public $price;
    public $editingId = null;


    //^ initialization logic
    //? render the component view
    public function render()
    {
        return view('livewire.item-manager');
    }

    //? initialize component state
    public function mount()
    {
    }

    //? load items from the database
    public function loadItems()
    {
    }


    //^ CRUD operations
    //? create a new item
    public function createItem()
    {
    }

    //? edit an existing item on id
    public function editItem($id)
    {
    }

    //? update edited item
    public function updateItem()
    {
    }
}
