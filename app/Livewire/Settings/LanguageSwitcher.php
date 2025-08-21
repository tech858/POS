<?php

namespace App\Livewire\Settings;

use App\Models\User;
use App\Scopes\BranchScope;
use Livewire\Component;

class LanguageSwitcher extends Component
{

    public function setLanguage($locale)
    {
        User::withoutGlobalScope(BranchScope::class)->where('id', user()->id)->update(['locale' => $locale]);

        session()->forget(['isRtl', 'user']);

        $this->js('window.location.reload()');

    }

    public function render()
    {
        return view('livewire.settings.language-switcher');
    }

}
