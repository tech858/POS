@extends('layouts.guest')

@section('content')

@livewire('shop.cart', ['tableID' => $tableHash ?? null, 'restaurant' => $restaurant ?? null, 'shopBranch' => $shopBranch ?? null])

@livewire('customer.signup', ['restaurant' => $restaurant])
    
@endsection