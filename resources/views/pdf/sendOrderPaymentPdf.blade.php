<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>خرید کالا</title>
</head>
<body style="direction: rtl;">
<p style="text-align: center">به نام خدا </p>
<p style="text-align: center">فاکتور فروش </p>
<table style="direction: rtl;margin-bottom: 50px; justify-content: center; border: 1px solid gray">
    <tr>
        <th style="text-align: center;border: 1px solid gray;">ردیف</th>
        <th style="text-align: center;border: 1px solid gray;">شماره سفارش</th>
        <th style="text-align: center;border: 1px solid gray;">نام محصول</th>
        <th style="text-align: center;border: 1px solid gray;">رنگ محصول</th>
        <th style="text-align: center;border: 1px solid gray;">گارانتی محصول</th>
        <th style="text-align: center;border: 1px solid gray;">تعداد کالا</th>
        <th style="text-align: center;border: 1px solid gray;">قیمت محصول</th>
        <th style="text-align: center;border: 1px solid gray;">قیمت کل محصولات</th>
        <th style="text-align: center;border: 1px solid gray;">قیمت محصول با لحاظ تخفیف</th>
        <th style="text-align: center;border: 1px solid gray;">قیمت کل محصولات با لحاظ تخفیف</th>
        <th style="text-align: center;border: 1px solid gray;">درصد تخفیف اعمال شده برای محصول</th>
    </tr>
    @foreach ($orderItems as $key=> $orderItem)
        <tr>
            <td style="text-align: center;border: 1px solid gray;">{{$key+1}}</td>
            <td style="text-align: center;border: 1px solid gray;">{{$orderItem['order_id']}}</td>
            <td style="text-align: center;border: 1px solid gray;">{{\App\Models\Market\OrderItem::find($orderItem['id'])->product->name}} </td>
            <td style="text-align: center;border: 1px solid gray;">{{\App\Models\Market\OrderItem::find($orderItem['id'])->color->color_name}}</td>
            <td style="text-align: center;border: 1px solid gray;">{{\App\Models\Market\OrderItem::find($orderItem['id'])->guarantee->name}}</td>
            <td style="text-align: center;border: 1px solid gray;">{{$orderItem['number']}}</td>
            <td style="text-align: center;border: 1px solid gray;">{{number_format($orderItem['final_product_price_without_amazing_sale'])}}</td>
            <td style="text-align: center;border: 1px solid gray;">{{number_format($orderItem['final_total_price_without_amazing_sale'])}}</td>
            <td style="text-align: center;border: 1px solid gray;">{{number_format($orderItem['final_product_price_with_amazing_sale'])}}</td>
            <td style="text-align: center;border: 1px solid gray;">{{number_format($orderItem['final_total_price_with_amazing_sale'])}}</td>
            <td style="text-align: center;border: 1px solid gray;">{{\App\Models\Market\OrderItem::find($orderItem['id'])->amazingSale->percentage}}
                %
            </td>


        </tr>
    @endforeach
</table>

{{--<table style="direction: rtl;justify-content: flex-start;text-align: start;width: 100%;display: flex;border: 1px solid gray;">--}}
{{--    <tr>--}}
{{--        <th style="text-align: center;padding: 10px;;border: 1px solid gray;">آدرس</th>--}}
{{--        <td style="text-align: center;border: 1px solid gray;">{{$order->address->fullAddress}}</td>--}}

{{--    </tr>--}}
{{--    <tr>--}}
{{--        <th style="text-align: center;border: 1px solid gray;">هزینه ارسال</th>--}}
{{--        <td style="text-align: center;border: 1px solid gray;">{{number_format($order['delivery_amount'])}}</td>--}}

{{--    </tr>--}}
{{--    <tr>--}}
{{--        <th style="text-align: center;border: 1px solid gray;">مقدار نهایی بدون احتساب کوپن تخفیف</th>--}}
{{--        <td style="text-align: center;border: 1px solid gray;">{{number_format($order['order_final_amount'])}}</td>--}}

{{--    </tr>--}}
{{--    <tr>--}}
{{--        <th style="text-align: center;border: 1px solid gray;">مقدار نهایی با احتساب کوپن تخفیف</th>--}}
{{--        <td style="text-align: center;border: 1px solid gray;">{{number_format($order['order_final_amount_with_copan_discount'])}}</td>--}}

{{--    </tr>--}}


{{--</table>--}}
</body>
</html>
