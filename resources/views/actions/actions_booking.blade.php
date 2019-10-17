@if(isset($booking))
    @if(!$booking->canceled_by)
        <a href="javascript:sdelete('bookings/{{$booking->id}}')" title="Suspend User" class="delete-row delete-color" data-id="{{ $booking->id }}"><i class="icon-user-block mr-3 icon-1x" style="color:red;"></i></a>
    @else
        <a href="javascript:restore('bookings/restore/{{$booking->id}}')" title="Restore User" class="restore-row restore-color" data-id="{{ $booking->id }}"><i
                class="icon-spinner11"></i></a>
    @endif
@endif
