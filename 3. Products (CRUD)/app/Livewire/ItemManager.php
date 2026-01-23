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
    //* -sortable columns
    //*-sort on category name
    //*-visual helpers on sort to check if first-last last-first
    //*-return to page 1 on create and edit
    //~===============================================================================================~//

    //-separation of concerns->apparte trade"interacts with x"
    //-factories for db seeder
    //-types toevoegen aan functies
    //-maintainability/best practises

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
    public $sort = 'updated_at';
    public $sortCount = 0;
    public $sortDirection = 'desc';
    public $sortIndicator = [];
    public $allTags = [];
    public $selectedTags = [];
    use WithPagination;


    //^ Initialization logic ======================================================================== ^//
    //? render the component view
    public function render()
    {
        $query = Item::query()
            //leftjoin to make categories table searchable
            ->leftJoin('categories', 'items.category_id', '=', 'categories.id')
            ->select('items.*', 'categories.name as category_name')

            //checks the search input for value and queries the items and categories if needed
            ->when($this->search !== '', function ($q) {
                $q->where(function ($q) {
                    $q->where('items.name', 'like', "%{$this->search}%")
                        ->orWhere('items.description', 'like', "%{$this->search}%")
                        ->orWhere('categories.name', 'like', "%{$this->search}%");
                });
            });

        //makes sure the first page is shown on search
        if (!empty($this->search)) {
            $this->setPage(1);
        }

        //if selected sorting type is categories query the categories table, else query the items table using value stored in $sort
        if ($this->sort === 'category') {
            $query->orderBy('category_name', $this->sortDirection);
        } else {
            $query->orderBy("items.{$this->sort}", $this->sortDirection);
        }

        //sets $query results as the $item value and paginates the result
        $items = $query->paginate($this->perPage);

        //checks howmany items there are on the page and fills any unused space with a filler
        $this->fillerRows = max(0, $this->perPage - $items->count());
        $this->allTags = \App\Models\Tag::orderBy('name')->get();

        return view('livewire.item-manager', [
            'items' => $items,
            'categories' => Category::orderBy('name')->get(),
            'tags' => \App\Models\Tag::orderBy('name')->get(),
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
            $this->reset(['name', 'category_id', 'description', 'price', 'selectedTags']);
            $this->resetErrorBag();
        }
    }

    //^ Validation and column sorting logic ========================================================= ^//
    //? input validation logic
    public function validateInput()
    {
        //make sure the name, category and price are not empty, description can be null
        return $this->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0|max:10000',

            'selectedTags' => ['array'],
            'selectedTags.*' => ['exists:tags,id'],
        ]);
    }

    //? column sorting logic
    public function sortBy($value)
    {
        //makes sure the first page is selected on sort
        $this->setPage(1);

        //if sorting by a new column, reset sort count and sort indictor, else increment sort count
        if ($this->sort !== $value) {
            $this->sortIndicator = [];
            $this->sort = $value;
            $this->sortCount = 1;
        } else {
            $this->sortCount++;
        }

        //if sort is clicked once, set to ascending with fitting indicator
        if ($this->sortCount === 1) {
            $this->sortDirection = 'asc';
            $this->sortIndicator[$value] = '↑';
            return;
        }

        //if sort is clicked twice, set to descending with fitting indicator
        if ($this->sortCount === 2) {
            $this->sortDirection = 'desc';
            $this->sortIndicator[$value] = '↓';
            return;
        }

        //if sortCount is 3 or more, reset to default sort, remove indicator
        $this->sort = 'updated_at';
        $this->sortDirection = 'desc';
        $this->sortCount = 0;
        $this->sortIndicator = [];
    }

    //^ CRUD operations ============================================================================= ^//
    //? create a new item
    public function createItem()
    {
        //call input validation
        $validated = $this->validateInput();

        //creates a database item with the validated inputs, sets page to 1
        $item = Item::create(
            \Illuminate\Support\Arr::except($validated, ['selectedTags'])
        );
        $this->setPage(1);

        // attach tags
        if (!empty($this->selectedTags)) {
            $item->tags()->attach($this->selectedTags);
        }

        //closes modal and loads the list to reflect new data
        $this->closeModal();
        $this->successMsg('added');
    }

    //? edit an existing item on id
    public function editItem($id)
    {
        //sets editing id to id given by edit button
        $this->editingId = $id;

        //recieves the given category from the db
        $item = Item::with('category')->findOrFail($id);

        //populates edit modal with the selected item
        $this->name = $item->name;
        $this->category_id = $item->category_id;
        $this->description = $item->description;
        $this->price = $item->price;
        $this->selectedTags = $item->tags()->pluck('tags.id')->toArray();
    }

    //? update edited item
    public function updateItem()
    {
        //call input validation
        $validated = $this->validateInput();

        //finds item by id and updates with validated inputs
        $item = Item::findOrFail($this->editingId);
        $item->update($validated);

        // sync tags
        $item->tags()->sync($this->selectedTags);

        $this->setPage(1);

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

    //^ Miscallaneous functions ====================================================================== ^//
    //? set success message
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
