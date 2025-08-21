<?php

namespace App\Livewire\Settings;

use App\Models\LanguageSetting;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class LanguageSettings extends Component
{

    use LivewireAlert;

    public $languageSettings;
    public $languageActive = [];
    public $languageRtl = [];
    public $languageID = [];

    public function mount()
    {
        $this->languageSettings = LanguageSetting::all();

        foreach ($this->languageSettings as $value) {
            $this->languageID[] = $value->id;
            $this->languageActive[] = (bool)$value->active;
            $this->languageRtl[] = (bool)$value->is_rtl;
        }

    }

    public function submitForm()
    {
        foreach ($this->languageID as $key => $value) {
            LanguageSetting::where('id', $value)
                ->update([
                    'active' => $this->languageActive[$key],
                    'is_rtl' => $this->languageRtl[$key]
                ]);
        }

        cache()->forget('languages');

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.settings.language-settings');
    }

}
