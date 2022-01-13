<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ADN EMS</title>
    </head>
    <body>
        @if (env('APP_DEBUG'))
            <h1>Test Email (Please Ignore)</h1>
        @endif
        
        <h3 >
            Dear {{$conveyance->user()->name}},
        </h3> 
        
        <p>
            Your Application for Conveyance
            @if ($conveyance->conveyance_type == 'transportation')
                (Transportation) on {{$conveyance->date()}} from {{$conveyance->from}} to {{$conveyance->to}} 
            @elseif ($conveyance->conveyance_type == 'overtime')
                (Overtime) on {{$conveyance->date()}} from {{$conveyance->inTime()}} to {{$conveyance->outTime()}}
            @else
                (Holiday) on {{$conveyance->date()}} from {{$conveyance->inTime()}} to {{$conveyance->outTime()}}
            @endif
            
            has been Submitted Successfully for futher Evaluation.
        </p>
        <br>
        <p>
            Current Approval Status>>>
        </p>
        <ul>
            @foreach ($conveyance->approvers() as $approval)
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
