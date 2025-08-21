<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\GlobalCurrency;

class AddSuperadminCurrency extends Component
{
    public $currencyName;
    public $currencySymbol;
    public $currencyCode;

    public function submitForm()
    {
        $this->validate([
            'currencyName' => 'required',
            'currencySymbol' => 'required',
            'currencyCode' => 'required',
        ]);

        $currency = new GlobalCurrency();
        $currency->currency_name = $this->currencyName;
        $currency->currency_symbol = $this->currencySymbol;
        $currency->currency_code = $this->currencyCode;
        $currency->save();

        $this->dispatch('hideAddCurrency');
    }

    public function render()
    {
        return view('livewire.forms.add-superadmin-currency');
    }
}
