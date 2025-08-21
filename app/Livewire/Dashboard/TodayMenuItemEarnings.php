<?php

namespace App\Livewire\Dashboard;

use App\Models\MenuItem;
use Livewire\Component;

class TodayMenuItemEarnings extends Component
{

    public function render()
    {
        $start = now()->startOfDay()->toDateTimeString();
        $end = now()->endOfDay()->toDateTimeString();

        $query = MenuItem::with(['orders' => function ($q) use ($start, $end) {
            return $q->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->whereDate('orders.date_time', '>=', $start)->whereDate('orders.date_time', '<=', $end);
        }])->get();

        
        $menuItems = $query->map(function ($order) {
            $order['total'] = $order->orders->sum('amount');
            return $order;
        });

        $menuItems = $query->filter(function ($order) {
            return ($order->total > 0);
        })->sortBy('total', SORT_REGULAR, true)->splice(0, 5);

        return view('livewire.dashboard.today-menu-item-earnings', [
            'menuItems' => $menuItems
        ]);
    }

}
