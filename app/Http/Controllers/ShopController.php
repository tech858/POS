<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function cart($hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->first();

        if (request()->branch && request()->branch != '') {
            $shopBranch = Branch::withoutGlobalScopes()->find(request()->branch);

        } else {
            $shopBranch = $restaurant->branches->first();
        }

        return view('shop.index', ['restaurant' => $restaurant, 'shopBranch' => $shopBranch]);
    }

    public function orderSuccess($id)
    {
        $order = Order::findOrFail($id);
        if (request()->branch && request()->branch != '') {
            $shopBranch = Branch::withoutGlobalScopes()->find(request()->branch);

        } else {
            $shopBranch = $order->branch;
        }
        return view('shop.order_success', ['restaurant' => $order->branch->restaurant, 'id' => $id, 'shopBranch' => $shopBranch]);
    }

    public function bookTable($hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();

        if (request()->branch && request()->branch != '') {
            $shopBranch = Branch::withoutGlobalScopes()->find(request()->branch);

        } else {
            $shopBranch = $restaurant->branches->first();
        }

        return view('shop.book_a_table', ['restaurant' => $restaurant, 'shopBranch' => $shopBranch]);
    }

    public function myBookings($hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();

        if (request()->branch && request()->branch != '') {
            $shopBranch = Branch::withoutGlobalScopes()->find(request()->branch);

        } else {
            $shopBranch = $restaurant->branches->first();
        }

        return view('shop.bookings', ['restaurant' => $restaurant, 'shopBranch' => $shopBranch]);
    }

    public function profile($hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();

        if (request()->branch && request()->branch != '') {
            $shopBranch = Branch::withoutGlobalScopes()->find(request()->branch);

        } else {
            $shopBranch = $restaurant->branches->first();
        }

        return view('shop.profile', ['restaurant' => $restaurant, 'shopBranch' => $shopBranch]);
    }

    public function myOrders($hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();

        if (request()->branch && request()->branch != '') {
            $shopBranch = Branch::withoutGlobalScopes()->find(request()->branch);

        } else {
            $shopBranch = $restaurant->branches->first();
        }

        return view('shop.orders', ['restaurant' => $restaurant, 'shopBranch' => $shopBranch]);
    }

    public function about($hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();

        if (request()->branch && request()->branch != '') {
            $shopBranch = Branch::withoutGlobalScopes()->find(request()->branch);

        } else {
            $shopBranch = $restaurant->branches->first();
        }

        return view('shop.about', ['restaurant' => $restaurant, 'shopBranch' => $shopBranch]);
    }

    public function contact($hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();

        if (request()->branch && request()->branch != '') {
            $shopBranch = Branch::withoutGlobalScopes()->find(request()->branch);

        } else {
            $shopBranch = $restaurant->branches->first();
        }

        return view('shop.contact', ['restaurant' => $restaurant, 'shopBranch' => $shopBranch]);
    }

    public function tableOrder($hash)
    {
        $table = Table::where('hash', $hash)->firstOrFail();

        return view('shop.index', ['tableHash' => $hash, 'restaurant' => $table->branch->restaurant->load('currency'), 'shopBranch' => $table->branch]);
    }

}
