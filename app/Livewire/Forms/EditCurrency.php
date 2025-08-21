<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class EditCurrency extends Component
{
    public $currency;
    public $restaurantCurrency;
    public $currencySymbol;
    public $currencyCode;
    public $numberOfDecimal;

    public function mount()
    {
        $this->restaurantCurrency = $this->currency->currency_name;
        $this->currencySymbol = $this->currency->currency_symbol;
        $this->currencyCode = $this->currency->currency_code;
//        $this->numberOfDecimal = $this->currency->no_of_decimal;
    }

    public function submitForm()
    {
        $this->validate([
            'restaurantCurrency' => 'required',
            'currencySymbol' => 'required',
            'currencyCode' => 'required',
        ]);

        $this->currency->currency_name = $this->restaurantCurrency;
        $this->currency->currency_symbol = $this->currencySymbol;
        $this->currency->currency_code = $this->currencyCode;
//        $this->currency->no_of_decimal = $this->numberOfDecimal;
        $this->currency->save();

        $this->dispatch('hideEditCurrency');
    }

    public function render()
    {
        return view('livewire.forms.edit-currency');
    }

}
