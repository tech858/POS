<?php

namespace App\Livewire\Shop;

use Livewire\Component;

class LanguageSwitcher extends Component
{

    public function setLanguage($locale)
    {
        session(['locale' => $locale]);

        $this->js('window.location.reload()');

    }

    public function render()
    {
        return view('livewire.shop.language-switcher');
    }

}
