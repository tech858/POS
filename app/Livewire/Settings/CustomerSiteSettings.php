<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CustomerSiteSettings extends Component
{

    use LivewireAlert;

    public $settings;
    public $customerLoginRequired;
    public $allowCustomerOrders;
    public $allowCustomerDeliveryOrders;
    public $allowCustomerPickupOrders;
    public $isWaiterRequestEnabled;
    public $defaultReservationStatus;
    public function mount()
    {
        $this->defaultReservationStatus = $this->settings->default_table_reservation_status;
        $this->customerLoginRequired = $this->settings->customer_login_required == 1 ? true : false;
        $this->allowCustomerOrders = $this->settings->allow_customer_orders == 1 ? true : false;
        $this->allowCustomerDeliveryOrders = $this->settings->allow_customer_delivery_orders == 1 ? true : false;
        $this->allowCustomerPickupOrders = $this->settings->allow_customer_pickup_orders == 1 ? true : false;
        $this->isWaiterRequestEnabled = $this->settings->is_waiter_request_enabled == 1 ? true : false;
    }

    public function submitForm()
    {
        $this->validate([
            'defaultReservationStatus' => 'required|in:Confirmed,Checked_In,Cancelled,No_Show,Pending',
        ]);

        $this->settings->default_table_reservation_status = $this->defaultReservationStatus;
        $this->settings->customer_login_required = $this->customerLoginRequired ? 1 : 0;
        $this->settings->allow_customer_orders = $this->allowCustomerOrders ? 1 : 0;
        $this->settings->allow_customer_delivery_orders = $this->allowCustomerDeliveryOrders ? 1 : 0;
        $this->settings->allow_customer_pickup_orders = $this->allowCustomerPickupOrders ? 1 : 0;
        $this->settings->is_waiter_request_enabled = $this->isWaiterRequestEnabled ? 1 : 0;
        $this->settings->save();

        $this->dispatch('settingsUpdated');

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.settings.customer-site-settings');
    }
}
