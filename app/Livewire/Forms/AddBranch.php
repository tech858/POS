<?php

namespace App\Livewire\Forms;

use App\Models\Branch;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AddBranch extends Component
{

    use LivewireAlert;

    public $branchName;
    public $branchAddress;

    public function submitForm()
    {
        $this->validate([
            'branchName' => 'required|unique:branches,name,null,id,restaurant_id,' . restaurant()->id,
            'branchAddress' => 'required'
        ]);

        Branch::create([
            'name' => $this->branchName,
            'restaurant_id' => restaurant()->id,
            'address' => $this->branchAddress,
        ]);

        // Reset the value
        $this->branchName = '';
        $this->branchAddress = '';

        $this->dispatch('hideAddBranch');

        session(['branches' => Branch::get()]);

        $this->alert('success', __('messages.branchAdded'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.forms.add-branch');
    }

}
