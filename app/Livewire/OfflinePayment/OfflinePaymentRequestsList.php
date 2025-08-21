<?php
namespace App\Livewire\OfflinePayment;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Restaurant;
use Livewire\WithPagination;
use App\Models\GlobalInvoice;
use App\Models\OfflinePlanChange;
use App\Models\GlobalSubscription;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class OfflinePaymentRequestsList extends Component
{
    use WithPagination, LivewireAlert;

    public $name;
    public $description;
    public $methodId;
    public $showViewRequestModal = false;
    public $showConfirmChangeModal =false;
    public $selectViewRequest;
    public $remark;
    public $payDate;
    public $nextPayDate;
    public $status;
    public $offlinePlanChange;

    private function resetForm()
    {
        $this->methodId = null;
        $this->name = $this->description = '';
        // $this->status = 'active';
        // $this->showPaymentMethodForm = false;
    }

    public function ViewRequest($id)
    {
        $this->selectViewRequest = OfflinePlanChange::findOrFail($id);
        $this->showViewRequestModal = true;

    }

    // Confirm the change of plan
    public function confirmChangePlan($id, $status)
    {
        $this->offlinePlanChange = OfflinePlanChange::with('restaurant')->findOrFail($id);
        $this->status = $status;
        if ($status == 'verified') {
            $this->payDate = now();
            $this->nextPayDate = $this->offlinePlanChange->package_type == 'monthly' ? Carbon::now()->addMonth() : Carbon::now()->addYear();
        }
        $this->showConfirmChangeModal = true;
    }

    // Decline the request
    public function declineRequest()
    {

        $this->validate([
            'remark' => 'required|min:10',
        ]);

        $this->offlinePlanChange->update([
            'status' => 'rejected',
            'remark' => $this->remark
        ]);

        $this->showConfirmChangeModal = false;
        $this->reset(['remark','offlinePlanChange', 'status']);
        $this->alert('success', __('messages.OfflinePlanChangeDeclined'), ['toast' => true, 'position' => 'top-end']);
    }

    // Process plan change request (accept/reject)
    public function changePlan()
    {
        if ($this->status == 'verified') {
            $this->handleVerifiedPlan();
        } elseif ($this->status == 'rejected') {
            $this->declineRequest();
        }
    }

    // Handle verified plan change (subscription & invoice)
    protected function handleVerifiedPlan()
    {
        $this->validate([
            'payDate' => 'required',
            'nextPayDate' => 'required'
        ]);

        $restaurant = Restaurant::find($this->offlinePlanChange->restaurant_id);
        $package = $this->offlinePlanChange->package;

        GlobalSubscription::where('restaurant_id', $restaurant->id)
            ->where('subscription_status', 'active')
            ->update(['subscription_status' => 'inactive']);

        $this->offlinePlanChange->update([
            'status' => 'verified',
            'pay_date' => $this->payDate,
            'next_pay_date' => $this->nextPayDate,
        ]);

        $restaurant->update([
            'package_id' => $package->id,
            'package_type' => $package->package_type,
            'is_active' => true,
            'license_expire_on' => $this->nextPayDate,
            'license_updated_at' => now(),
            'subscription_updated_at' => now(),
        ]);

        $subscription = GlobalSubscription::create([
            'restaurant_id' => $this->offlinePlanChange->restaurant_id,
            'package_id' => $this->offlinePlanChange->package_id,
            'currency_id' => $this->offlinePlanChange->package->currency_id,
            'package_type' => $this->offlinePlanChange->package_type,
            'quantity' => 1,
            'gateway_name' => 'offline',
            'subscription_status' => 'active',
            'subscribed_on_date' => $this->payDate,
            'ends_at' => $this->nextPayDate,
            'transaction_id' => strtoupper(str()->random(15)),
        ]);

        GlobalInvoice::create([
            'restaurant_id' => $this->offlinePlanChange->restaurant_id,
            'global_subscription_id' => $subscription->id,
            'package_id' => $this->offlinePlanChange->package_id,
            'currency_id' => $this->offlinePlanChange->package->currency_id,
            'offline_method_id' => $this->offlinePlanChange->offline_method_id,
            'package_type' => $this->offlinePlanChange->package_type,
            'total' => $this->offlinePlanChange->amount,
            'gateway_name' => 'offline',
            'status' => 'active',
            'pay_date' => $this->payDate,
            'next_pay_date' => $this->nextPayDate,
            'transaction_id' => $subscription->transaction_id,
        ]);
        cache()->forget('package');
        cache()->forget('restaurant_modules');
        $this->showConfirmChangeModal = false;
        $this->alert('success', __('messages.offlinePaymentVerified'), ['toast' => true, 'position' => 'top-end']);
        $this->reset(['remark', 'payDate', 'nextPayDate', 'offlinePlanChange', 'status']);
    }



    public function downloadFile($id)
    {
        $request = OfflinePlanChange::findOrFail($id);

        if (empty($request->file_name)) {
            return $this->alert('error', 'File not found.');
        }

        $filePath = public_path('user-uploads/' . OfflinePlanChange::FILE_PATH . '/' . $request->file_name);

        if (!file_exists($filePath)) {
            return $this->alert('error', 'File not found.');
        }

        return response()->download($filePath);
    }


    public function render()
    {
        $offlinePaymentRequest = OfflinePlanChange::paginate(10);

        return view('livewire.offline-payment.offline-payment-requests-list', compact('offlinePaymentRequest'));
    }
}
