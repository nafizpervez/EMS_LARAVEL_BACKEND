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
            Dear {{$event->createdForUser()->name}},
        </h3> 

        <p>
            You Have been Assigned a Task by <b>{{$event->createdByUser()->name}} ({{$event->createdByUser()->designation}})</b> with following details.
        </p>

        <h3>Task Details >>></h3>
        
        <p>
            <b>{{ucfirst($event->title)}}</b> <br>
            {{$event->description}}
        </p>
        
        <h3>Schedule >>></h3>
        <p>
            @if ($event->day_long_event)                
                <b>Event Time:</b> Day Long Event on {{$event->eventDate()}}                
            @else
                <b>Start Time: {{$event->eventStartTime()}}</b> <br>
                <b>End Time: {{$event->eventEndTime()}}</b>
            @endif
        </p>

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
