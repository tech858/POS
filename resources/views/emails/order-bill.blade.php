@component('mail::message')
# {{ __('modules.order.orderNumber') . '#'.$order->order_number }}

{{__('app.hello') }} {{ $order->customer->name }},

{{__('email.sendOrderBill.text1')}}

## {{__('email.sendOrderBill.text2')}}
@component('mail::table')
| {{ __('modules.menu.itemName') }}           | {{ __('modules.order.qty') }}      | {{ __('modules.order.price') }}     |
|:-------------- |:-------------:| ---------:|
@foreach ($items as $item)
| {{ $item->menuItem->item_name }} | {{ $item->quantity }} | {{ $settings->currency->currency_symbol }}{{ number_format($item->price * $item->quantity, 2) }} |
@endforeach
| **{{ __('modules.order.subTotal') }}**   |               | **{{ $settings->currency->currency_symbol }}{{ $subtotal }}** |
@foreach ($taxesWithAmount as $tax)
| **{{ $tax['name'] }} ({{ $tax['rate'] }}%)** |     | **{{ $settings->currency->currency_symbol }}{{ number_format($tax['amount'], 2) }}** |
@endforeach
| **{{ __('modules.order.total') }}**      |               | **{{ $settings->currency->currency_symbol }}{{ $totalPrice }}** |
@endcomponent

**{{ __('app.date') }}**: {{ $order->date_time->translatedFormat('F j, Y, g:i a') }}  

@lang('app.thanks'),<br>
{{ config('app.name') }}
@endcomponent
