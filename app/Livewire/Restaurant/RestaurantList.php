<?php

namespace App\Livewire\Restaurant;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Table;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\GlobalSetting;

class RestaurantList extends Component
{

    use LivewireAlert;
    public $search;
    public $showAddRestaurant = false;

    public $showRegenerateQrCodes = false;

    public function mount()
    {
        $setting = GlobalSetting::first();

        if(config('app.url') !== $setting->installed_url){
            $this->showRegenerateQrCodes = true;
        }
    }

    #[On('hideAddRestaurant')]
    public function hideAddRestaurant()
    {
        $this->showAddRestaurant = false;
    }


    public function regenerateQrCodes()
    {
        $tables = Table::all();

        foreach ($tables as $table) {
            $table->generateQrCode();
        }

        $this->showRegenerateQrCodes = false;

        $setting = GlobalSetting::first();
        $setting->installed_url = config('app.url');
        $setting->saveQuietly();

        cache()->forget('global_setting');

        $this->alert('success', __('superadmin.qrCodesRegenerated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }


    public function render()
    {
        return view('livewire.restaurant.restaurant-list');
    }

}
