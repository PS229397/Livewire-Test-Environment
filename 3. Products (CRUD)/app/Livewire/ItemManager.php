<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;
use Carbon\Traits\ToStringFormat;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\error;

class ItemManager extends Component
{
    //~============================================/TODO/=============================================~//
    //*-update confirmation on edit
    //*-refine modal management logic
    //*-unify confirmation modal
    //*-extend currentConfirm to be currentModal
    //&-save state of edit while edit confirmation is up
    //&-close modal on outside click and ESC key
    //&-autofocus on modals
    //*-centeralize validation rules
    //*-validate before confirm modal on edit
    //!-loading spinners
    //!-disable buttons while processing
    //^-add success messages on create, update, delete
    //!-pagination for item list
    //!-search/filter for item list
    //!-sort for item list
    //~===============================================================================================~//

    //^ Component properties ======================================================================== ^//
    public $items = [];
    public $name;
    public $description;
    public $price;
    public $currentModal = '';
    public $editingId = null;
    public $deletingId = null;
    public $succesMsg = '';
    public $tstMsg = '';

    //^ Initialization logic ======================================================================== ^//
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
        //show last added/edited item on top
        $this->items = Item::orderBy('updated_at', 'desc')->get();
    }

    //^ Modal management ============================================================================ ^//
    //? modal open logic
    public function openModal($type, $value)
    {
        //decides which modal to open based on passed type
        switch ($type) {
            case 'add':
                $this->currentModal = $type;
                break;

            case 'edit':
                $this->currentModal = $type;
                $this->editItem($value);
                break;

            case 'update':
                $this->validateInput();
                $this->currentModal = $type;
                break;

            case 'delete':
                $this->currentModal = $type;
                $this->deletingId = $value;
                break;
        }
    }

    //? modal close logic
    public function closeModal()
    {
        //if editingId is populated & update confirmation ui open, re-open edit modal closing the confirmation
        if ($this->editingId !== null && $this->currentModal === 'update') {
            $this->openModal('edit', $this->editingId);
        }
        //else reset all modal states and clear inputs
        else {
            $this->currentModal = '';
            $this->editingId = null;
            $this->deletingId = null;
            $this->reset(['name', 'description', 'price']);
            $this->resetErrorBag();
        }
    }

    //^ Loading bar & validation logic ============================================================== ^//
    //? validation function for the add and update logic
    public function validateInput()
    {
        return $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0|max:10000',
        ]);
    }

    //^ CRUD operations ============================================================================= ^//
    //? create a new item
    public function createItem()
    {
        //call input validation
        $validated = $this->validateInput();

        //creates a database item with the validated inputs
        Item::create($validated);

        //closes modal and loads the list to reflect new data
        $this->closeModal();
        $this->loadItems();
        $this->successMsg('added');
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
        //call input validation
        $validated = $this->validateInput();

        //finds item by id and updates with validated inputs
        $item = Item::findOrFail($this->editingId);
        $item->update($validated);

        //resets editing id to null
        $this->editingId = null;

        //closes modal and loads the list to reflect new data
        $this->closeModal();
        $this->loadItems();
        $this->successMsg('updated');
    }

    //? delete item on id
    public function deleteItem($id)
    {
        //finds item by id and deletes it from db
        $item = Item::findOrFail($id);
        $item->delete();

        //runs closeModal logic
        $this->closeModal();

        //loads the list to reflect new data
        $this->loadItems();
        $this->successMsg('deleted');
    }

    //^ Misallaneous functions ====================================================================== ^//
    //? success message logic
    public function successMsg($value)
    {
        $this->succesMsg = $value;
    }

    //? clear success message
    public function clearMsg()
    {
        $this->succesMsg = '';
    }
}
