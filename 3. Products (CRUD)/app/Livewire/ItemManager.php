<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\DB;

class ItemManager extends Component
{
    //^component properties
    public $items = [];
    public $name;
    public $description;
    public $price;
    public $editingId = null;
    public $modal = null;
    public $tstMsg = '';


    //^ initialization logic
    //? initialize component state
    public function mount()
    {
        //on load populate component with up to date db
        $this->loadItems();
    }

    //? render the component view
    public function render()
    {
        return view('livewire.item-manager');
    }


    //? load items from the database
    public function loadItems()
    {
        $this->items = Item::all();
    }


    //^ CRUD operations
    //? create a new item
    public function createItem()
    {
        $validated = $this->validate(['name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'decimal']);

        Item::create($validated);
        $this->reset(['name', 'description', 'price']);

        $this->loadItems();
    }

    public function populateEdit($value){

    }

    //? edit an existing item on id
    public function editItem($id)
    {
        //get values from $items where id is id
        //populate fields
        //validate
        //if validaion is correct continue
        //call update item with the new values attatched
    }

    //? update edited item
    public function updateItem()
    {
    }

    //? modal switch
    public function switchModal($value){
        if ($value !== null){
            $this->tstMsg = 'test';
            $this->editingId = $value;
            $this->populateEdit($value);
        }
        $this->modal = ! $this->modal;
    }
}
