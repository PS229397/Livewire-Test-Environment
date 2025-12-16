<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\error;

class ItemManager extends Component
{
    //^component properties
    public $items = [];
    public $name;
    public $description;
    public $price;
    public $editingId = null;
    public $modal = null;
    public $deletingId = null;
    public $confirmDelete = null;
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
        //show last added/edited item ontop
        $this->items = Item::orderBy('updated_at', 'desc')->get();
    }

    //^ modal management
    //? modal switch
    public function switchModal($value)
    {
        //if modal is closed open it, vice versa
        $this->modal = ! $this->modal;

        //check if value is numeric to trigger edit mode
        if ($value !== null && is_numeric($value)) {
            $this->editItem($value);
        }

        //if not numeric reset inputs and error bag
        else {
            $this->editingId = null;
            $this->reset(['name', 'description', 'price']);
            $this->resetErrorBag();
            return;
        }
    }

    //? delete modal switch
    public function switchDeleteModal($value)
    {
        //if value is not 'close', open modal and set deletingId
        if ($value !== 'close') {
            $this->deletingId = $value;
            $this->confirmDelete = true;
        }

        //else close modal and reset deletingId
        else {
            $this->confirmDelete = false;
            $this->deletingId = null;
        }
    }

    //^ CRUD operations
    //? create a new item
    public function createItem()
    {
        //input validation parameters
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0|max:10000',
        ]);

        //creates a database item with the validated inputs
        Item::create($validated);

        //reset logic to prep inputs for next query
        $this->reset(['name', 'description', 'price']);
        $this->resetErrorBag();
        $this->switchModal('close');

        //loads the list to reflect new data
        $this->loadItems();
    }

    //? edit an existing item on id
    public function editItem($id)
    {
        //sets editingId to the passed id to trigger edit mode
        $this->editingId = $id;

        //finds item by id and populates inputs with existing data
        $item = Item::findOrFail($id);

        //populate inputs with existing data
        $this->name = $item->name;
        $this->description = $item->description;
        $this->price = $item->price;
    }

    //? update edited item
    public function updateItem()
    {
        //input validation parameters
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0|max:10000',
        ]);

        //finds item by id and updates with validated inputs
        $item = Item::findOrFail($this->editingId);
        $item->update($validated);

        //reset logic to prep inputs for next query
        $this->reset(['name', 'description', 'price']);
        $this->resetErrorBag();
        $this->switchModal('close');

        //loads the list to reflect new data
        $this->loadItems();
    }

    //? delete item on id
    public function deleteItem($id)
    {
        //finds item by id and deletes it from db
        $item = Item::find($id);
        $item->delete();

        //reset delete modal state
        $this->deletingId = null;
        $this->confirmDelete = false;

        //loads the list to reflect new data
        $this->loadItems();
    }
}
