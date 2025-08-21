<?php

namespace App\Livewire\SuperadminSettings;

use App\Helper\Files;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class AppSettings extends Component
{

    use LivewireAlert, WithFileUploads;

    public $settings;
    public $themeColor;
    public $themeColorRgb;
    public $photo;
    public $appName;

    public function mount()
    {
        $this->themeColor = $this->settings->theme_hex;
        $this->themeColorRgb = $this->settings->theme_rgb;
        $this->appName = $this->settings->name;
    }

    /**
     * @throws \Exception
     */
    public function submitForm()
    {
        $this->validate([
            'themeColor' => 'required'
        ]);

        $this->themeColorRgb = $this->hex2rgba($this->themeColor);

        $this->settings->name = $this->appName;
        $this->settings->theme_hex = $this->themeColor;
        $this->settings->theme_rgb = $this->themeColorRgb;
        $this->settings->save();

        if ($this->photo) {
            $this->settings->logo = Files::uploadLocalOrS3($this->photo, dir: 'logo');
        }

        $this->settings->save();

        cache()->forget('global_setting');
        session()->forget('companyOrGlobalSetting');

        $this->redirect(route('superadmin.superadmin-settings.index'), navigate: true);

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function hex2rgba($color): string
    {

        list($r, $g, $b) = sscanf($color, '#%02x%02x%02x');

        return $r . ', ' . $g . ', ' . $b;
    }

    public function deleteLogo()
    {
        if (is_null($this->settings->logo)) {
            return;
        }

        File::delete(public_path('user-uploads/logo/' . $this->settings->logo));
        Files::deleteFile($this->settings->logo, 'logo');

        $this->settings->forceFill(['logo' => null])->save();

        $this->redirect(route('superadmin.superadmin-settings.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.superadmin-settings.app-settings');
    }

}
