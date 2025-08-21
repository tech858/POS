<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;

class ShopDesktopNavigation extends Component
{
    protected $listeners = ['setCustomer' => '$refresh'];

    public $orderItemCount = 0;
    public $restaurant;
    public $shopBranch;

    #[On('updateCartCount')]
    public function updateCartCount($count)
    {
        $this->orderItemCount = $count;
    }

    public function render()
    {
        return view('livewire.shop-desktop-navigation');
    }

}
