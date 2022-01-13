<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>ADN EMS</title>
</head>
    <body>
        
    </body>
</html> -->

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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

        <p>
            Your Application for Purchase Requisition with Following Information has been Submitted Successfully for futher Evaluation.
        </p>
        
        <p>
            <b>ID :</b> {{$purchase_requisition->serial_id}} <br>
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
            Current Approval Status>>>
        </p>
        
        <ul>
            @foreach ($purchase_requisition->approvers() as $approval)
                <p>
                    @if ($approval->status == 'pending')
                        &#9863 
                    @elseif ($approval->status == 'approved') 
                        &#10003
                    @else
                        &#215
                    @endif
                    {{ucfirst($approval->approvee()->name)}} : <b>{{ucfirst($approval->status)}}</b>
                </p>
            @endforeach     
        </ul>

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