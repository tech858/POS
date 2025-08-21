<?php

namespace App\Livewire\Restaurant;

use Livewire\Component;
use App\Models\Restaurant;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RestaurantTable extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $search;
    public $restaurant;
    public $roles;
    public $showEditCustomerModal = false;
    public $confirmDeleteCustomerModal = false;
    public $showCustomerOrderModal = false;
    public $showChangePackageModal = false;

    protected $listeners = ['refreshRestaurants' => '$refresh'];

    public function showEditCustomer($id)
    {
        $this->restaurant = Restaurant::findOrFail($id);
        $this->showEditCustomerModal = true;
    }

    #[On('hideEditStaff')]
    public function hideEditStaff()
    {
        $this->showEditCustomerModal = false;
    }

    public function showChangePackage($id)
    {
        $this->restaurant = Restaurant::findOrFail($id);

        $this->showChangePackageModal = true;
    }

    #[On('hideChangePackage')]
    public function hideChangePackage()
    {
        $this->showChangePackageModal = false;
        $this->reset('restaurant');
    }

    public function showDeleteCustomer($id)
    {
        $this->restaurant = Restaurant::findOrFail($id);
        $this->confirmDeleteCustomerModal = true;
    }

    public function deleteCustomer($id)
    {
        Restaurant::destroy($id);

        $this->confirmDeleteCustomerModal = false;
        $this->reset('restaurant');
        $this->alert('success', __('messages.memberDeleted'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

    }

    #[On('hideEditCustomer')]
    public function hideEditCustomer()
    {
        $this->showEditCustomerModal = false;
    }

    public function render()
    {
        $query = Restaurant::where(function($q) {
            return $q->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('id', 'like', '%'.$this->search.'%')
                ->orWhere('email', 'like', '%'.$this->search.'%');
        })
        ->orderByDesc('id')
        ->withCount('branches')
        ->paginate(20);

        return view('livewire.restaurant.restaurant-table', [
            'restaurants' => $query
        ]);
    }

}
