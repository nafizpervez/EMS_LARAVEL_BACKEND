<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ADN EMS</title>

        <style>
        table.GeneratedTable {
            width: 100%;
            background-color: #ffffff;
            border-collapse: collapse;
            border-width: 2px;
            border-color: #ffffff;
            border-style: solid;
            color: #000000;
        }

        table.GeneratedTable td, table.GeneratedTable th {
            border-width: 2px;
            border-color: #ffffff;
            border-style: solid;
            padding: 3px;
            text-align: center;
        }

        table.GeneratedTable thead {
            background-color: #90b33e;
        }
    </style>
    </head>
    <body>
        @if (env('APP_DEBUG'))
            <h1>
                Test Email (Please Ignore),
            </h1> 
        @endif
        
        <h3 >
            Dear {{$purchase_requisition->user()->name}},
        </h3>

        <br>

        <h2>
            Application Approved!
        </h2>

        <p>
            Your Application for Purchase Requisition with Following Information has been Approved.
        </p>
        
        <p>
            <b>ID :</b> {{$purchase_requisition->serial_id}} <br>
            <b>Expanse Type :</b> {{ucfirst($purchase_requisition->expanse_type)}} <br>
            <b>Purpose of Purchase :</b> {{ucfirst($purchase_requisition->purpose_of_purchase == null? 'No Data': $purchase_requisition->purpose_of_purchase)}} <br>
            <b>User :</b> {{ucfirst($purchase_requisition->user)}} <br>
            <b>Comment :</b> {{ucfirst($purchase_requisition->comment)}} <br>
        </p>
        <br>
        <table class="GeneratedTable">
            <thead>
                <tr>
                    <th> Sl. </th>
                    <th>Purchase Type</th>
                    <th>Item Description</th>
                    <th>Item Quantity</th>
                    <th>Measurement of Unit</th>
                    <th>Required Date</th>
                    <th>Estimated Unit Price</th>
                    <th>Estimated Total Price</th>
                </tr>
                
            </thead>
            <tbody>
            @foreach ($purchase_requisition->items() as $item)
                <tr>
                    <th>{{ $loop->index +1}}</th>
                    <td>{{ucfirst($item->purchase_type)}}</td>
                    <td>{{$item->item_description}}</td>
                    <td>{{$item->item_quantity}}</td>
                    <td>{{$item->measurement_of_unit == null? 'No Data': $item->measurement_of_unit}}</td>
                    <td>{{$item->required_datet == null? 'No Data': $item->required_datet}}</td>
                    <td>৳ {{$item->estimated_unit_price}}  BDT</td>
                    <td>৳ {{$item->estimated_total_price}}  BDT</td>
                </tr>
            @endforeach
            <tr>
                    <th></th>
                    <td></td>
                    <td><b>Total</b></td>
                    <td><b>{{$purchase_requisition->totalItemQuantity()}}</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>৳ {{$purchase_requisition->totalEstimatedAmount()}} BDT</b></td>
                </tr>
            </tbody>
        </table>  

        <br>
        <p>
            Thanks & Regards,<br>
            ADN EMS <br>
        </p>

        <p>
            ADN Technologies LTD. <br>
            RCC Tower (2nd Floor), <br>
            17 Mohakhali, C/A, Dhaka-1212 <br> 
            Mobile: +880 1819 412285
        </p>
    </body>
</html>
