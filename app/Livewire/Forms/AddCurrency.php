<?php

namespace App\Livewire\Forms;

use App\Models\Currency;
use Livewire\Component;

class AddCurrency extends Component
{

    public $restaurantCurrency;
    public $currencySymbol;
    public $currencyCode;

    public function submitForm()
    {
        $this->validate([
            'restaurantCurrency' => 'required',
            'currencySymbol' => 'required',
            'currencyCode' => 'required',
        ]);

        $currency = new Currency();
        $currency->currency_name = $this->restaurantCurrency;
        $currency->currency_symbol = $this->currencySymbol;
        $currency->currency_code = $this->currencyCode;
        $currency->save();

        $this->dispatch('hideAddCurrency');
    }

    public function render()
    {
        return view('livewire.forms.add-currency');
    }

}
