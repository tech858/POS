<?php

namespace App\Livewire\Settings;

use App\Models\Branch;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class BranchSettings extends Component
{
    use LivewireAlert;

    public $showAddBranchModal = false;
    public $showEditBranchModal = false;
    public $confirmDeleteBranchModal = false;
    public $activeBranch;

    public function showAddBranch()
    {
        $this->showAddBranchModal = true;
    }

    #[On('hideAddBranch')]
    public function hideAddBranch()
    {
        $this->showAddBranchModal = false;
    }

    #[On('hideEditBranch')]
    public function hideEditBranch()
    {
        $this->showEditBranchModal = false;
    }

    public function showDeleteBranch($id)
    {
        $this->activeBranch = Branch::findOrFail($id);
        $this->confirmDeleteBranchModal = true;
    }

    public function showEditBranch($id)
    {
        $this->activeBranch = Branch::findOrFail($id);
        $this->showEditBranchModal = true;
    }

    public function deleteBranch($id)
    {
        Branch::destroy($id);

        $this->activeBranch = null;

        $this->confirmDeleteBranchModal = false;

        session(['branches' => Branch::get()]);

        $this->alert('success', __('messages.branchDeleted'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

    }

    #[On('hideEditCurrency')]
    public function hideEditCurrency()
    {
        $this->showEditBranchModal = false;
        session(['branches' => Branch::get()]);
    }

    public function render()
    {
        return view('livewire.settings.branch-settings');
    }

}
