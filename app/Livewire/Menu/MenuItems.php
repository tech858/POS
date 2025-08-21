<?php

namespace App\Livewire\Menu;

use App\Models\ItemCategory;
use App\Models\Menu;
use App\Models\MenuItem;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class MenuItems extends Component
{

    use WithPagination, WithoutUrlPagination, LivewireAlert;

    public $showEditMenuItem = false;
    public $clearFilterButton = false;
    public $showMenuCategoryModal = false;
    public $showItemVariationsModal = false;
    public $menuItem;
    public $confirmDeleteMenuItem = false;
    public $showFilters = false;
    public $menuID = null;
    public $search;
    public $categoryList = [];
    public $menus = [];
    public $filterCategories = [];
    public $filterTypes = [];

    public function mount()
    {
        $this->categoryList = ItemCategory::all();
        $this->menus = Menu::all();
    }

    public function showEditMenu($id)
    {
        $this->showEditMenuItem = true;
        $this->menuItem = MenuItem::findOrFail($id);
    }

    public function showItemVariations($id)
    {
        $this->showItemVariationsModal = true;
        $this->menuItem = MenuItem::findOrFail($id);
    }

    public function showDeleteMenuItem($id)
    {
        $this->confirmDeleteMenuItem = true;
        $this->menuItem = MenuItem::findOrFail($id);
    }

    public function deleteMenuItem($id)
    {
        MenuItem::destroy($id);
        $this->confirmDeleteMenuItem = false;

        $this->alert('success', __('messages.menuItemDeleted'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    #[On('showMenuCategoryModal')]
    public function showMenuCategoryModal()
    {
        $this->showMenuCategoryModal = true;
    }

    #[On('hideCategoryModal')]
    public function hideCategoryModal()
    {
        $this->showMenuCategoryModal = false;
    }

    #[On('hideEditMenuItem')]
    public function hideEditMenuItem()
    {
        $this->showEditMenuItem = false;
    }

    #[On('hideItemVariations')]
    public function hideItemVariations()
    {
        $this->showItemVariationsModal = false;
    }

    #[On('showMenuItemFilters')]
    public function showFiltersSection()
    {
        $this->showFilters = true;
    }

    public function clearFilters()
    {
        $this->filterCategories = [];
        $this->filterTypes = [];
        $this->search = '';
        $this->dispatch('clearMenuItemFilter');
    }

    public function render()
    {
        $this->clearFilterButton = false;

        $query = MenuItem::withCount('variations', 'menu', 'category')->with('category', 'menu');
       
        if (!is_null($this->menuID)) {
            $query = $query->where('menu_id', $this->menuID);
        }

        if ($this->search != '') {
            $this->clearFilterButton = true;
        }

        if (!empty($this->filterCategories)) {
            $query = $query->whereIn('item_category_id', $this->filterCategories);
            $this->clearFilterButton = true;
        }

        if (!empty($this->filterTypes)) {
            $query = $query->whereIn('type', $this->filterTypes);
            $this->clearFilterButton = true;
        }
       
        $query = $query->search('item_name', $this->search)->orderBy('id', 'desc')->paginate(10);

        return view('livewire.menu.menu-items', [
            'menuItems' => $query
        ]);
    }

}
