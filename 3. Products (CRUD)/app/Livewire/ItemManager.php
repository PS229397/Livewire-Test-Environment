<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Item;
use App\Models\Category;

class ItemManager extends Component
{
    //~============================================/TODO/=============================================~//
    //*-update confirmation on edit
    //*-refine modal management logic
    //*-unify confirmation modal
    //*-extend currentConfirm to be currentModal
    //*-fill unused table space with blank rows to prevent layout shift
    //!-save state of edit while edit confirmation is up -- blocker: edit cancel calls a new edit on id || potential fix: hiding modal instead of closing outright on cancel
    //*-close modal on outside click and ESC key
    //*-make a category table
    //*-link category_id as a foreign key into items table
    //*-in the category select replace hardcoded options with a foreach category in categories(dynamic design)
    //*-make sure category gets pulled on edit and the select state is set to the category
    //*-integrate category within validation and modal close
    //*-centeralize validation rules
    //*-validate before confirm modal on edit
    //*-add success messages on create, update, delete
    //*-success indicator animations
    //*-pagination for item list
    //*-search for item list
    //*-make category a searchable within search
    //*-clear search button
    //&-sortable columns
    //~===============================================================================================~//

    //^ Component properties ======================================================================== ^//
    public int $perPage = 10;
    public int $fillerRows = 0;
    protected $paginationTheme = 'tailwind';
    public $name;
    public $category_id;
    public $description;
    public $price;
    public $currentModal = '';
    public $editingId = null;
    public $deletingId = null;
    public $succesMsg = '';
    public $tstMsg = '';
    public $search = '';

    //^ Initialization logic ======================================================================== ^//
    //? initialize component state
    use WithPagination;

    //? render the component view
    public function render()
    {
        //checks the search input for value and queries the items accordingly, if no search value, returns all items
        if ($this->search !== '') {
            $items = Item::where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhereHas('category', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
                ->orderBy('updated_at', 'desc')
                ->paginate($this->perPage);
        } else {
            $items = Item::orderBy('updated_at', 'desc')->paginate($this->perPage);
        }

        //checks how many items there are within the table page (max 10) fills up any empty spot with a filler
        $this->fillerRows = max(
            0,
            $this->perPage - $items->count()
        );

        return view('livewire.item-manager', [
            'items' => $items,
            'categories' => Category::orderBy('name')->get(),
        ]);
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
            $this->reset(['name', 'category_id', 'description', 'price']);
            $this->resetErrorBag();
        }
    }

    //^ Validation logic ============================================================================ ^//
    public function validateInput()
    {
        return $this->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
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
        $this->resetPage();

        //closes modal and loads the list to reflect new data
        $this->closeModal();
        $this->successMsg('added');
    }

    //? edit an existing item on id
    public function editItem($id)
    {
        $this->editingId = $id;

        $item = Item::with('category')->findOrFail($id);

        $this->name = $item->name;
        $this->category_id = $item->category_id;
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

        //closes modal and shows success message
        $this->closeModal();
        $this->successMsg('updated');
    }

    //? delete item on id
    public function deleteItem($id)
    {
        //finds item by id and deletes it from db
        $item = Item::findOrFail($id);
        $item->delete();
        $this->resetPage();

        //closes modal and shows success message
        $this->closeModal();
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

    //? clear search input
    public function clearSearch()
    {
        $this->search = '';
    }
}
