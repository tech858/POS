<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ restaurant()->name }} - Order #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        .receipt {
            width: 80mm;
            padding: 2mm;
            page-break-after: always;
        }

        .header {
            text-align: center;
            margin-bottom: 3mm;
        }

        .restaurant-name {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 1mm;
        }

        .restaurant-info {
            font-size: 9pt;
            margin-bottom: 1mm;
        }

        .order-info {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 2mm 0;
            margin-bottom: 3mm;
            font-size: 9pt;
        }

        .order-number {
            font-weight: bold;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3mm;
            font-size: 9pt;
        }

        .items-table th {
            text-align: left;
            padding: 1mm 0;
            border-bottom: 1px solid #000;
        }

        .items-table td {
            padding: 1mm 0;
            vertical-align: top;
        }

        .qty {
            width: 10%;
            text-align: center;
        }

        .description {
            width: 50%;
        }

        .price {
            width: 20%;
            text-align: right;
        }

        .amount {
            width: 20%;
            text-align: right;
        }

        .summary {
            font-size: 9pt;
            margin-top: 2mm;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1mm;
        }

        .total {
            font-weight: bold;
            font-size: 11pt;
            border-top: 1px solid #000;
            padding-top: 1mm;
            margin-top: 1mm;
        }

        .footer {
            text-align: center;
            margin-top: 3mm;
            font-size: 9pt;
            padding-top: 2mm;
            border-top: 1px dashed #000;
        }

        @media print {
            @page {
                margin: 0;
                size: 80mm auto;
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="header">
            <div class="restaurant-name">{{ restaurant()->name }}</div>
            <div class="restaurant-info">{{ restaurant()->address }}</div>
            <div class="restaurant-info">@lang('modules.customer.phone'): {{ restaurant()->phone_number }}</div>
        </div>

        <div class="order-info">
            <div class="summary-row">
                <span>@lang('modules.order.orderNumber') #<span class="order-number">{{ $order->order_number }}</span></span>
                <span>{{ $order->date_time->timezone(timezone())->translatedFormat('d M Y H:i') }}</span>
            </div>
            @if($order->table_id)
            <div class="summary-row">
                <span>@lang('modules.table.table'): <span class="table-number">{{ $order->table->table_code }}</span></span>
            </div>
            @endif
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th class="qty">@lang('modules.order.qty')</th>
                    <th class="description">@lang('modules.menu.itemName')</th>
                    <th class="price">@lang('modules.order.price')</th>
                    <th class="amount">@lang('modules.order.amount')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td class="qty">{{ $item->quantity }}</td>
                    <td class="description">
                        {{ $item->menuItem->item_name }}
                        @if(isset($item->menuItemVariation))
                        <br><small>({{ $item->menuItemVariation->variation }})</small>
                        @endif
                    </td>
                    <td class="price">{{ currency() }}{{ number_format($item->price, 2) }}</td>
                    <td class="amount">{{ currency() }}{{ number_format($item->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <div class="summary-row">
                <span>@lang('modules.order.subTotal'):</span>
                <span>{{ currency() }}{{ number_format($order->sub_total, 2) }}</span>
            </div>

            @foreach ($order->taxes as $item)
            <div class="summary-row">
                <span>{{ $item->tax->tax_name }} ({{ $item->tax->tax_percent }}%):</span>
                <span>{{ currency() }}{{ number_format(($item->tax->tax_percent / 100) * $order->sub_total, 2) }}</span>
            </div>
            @endforeach

            <div class="summary-row total">
                <span>@lang('modules.order.total'):</span>
                <span>{{ currency() }}{{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <div class="footer">
            <p>@lang('messages.thankYouVisit')</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
