@if(isset($barber))
    @if($barber->status->title == 'Active')
        <a href="javascript:sdelete('barbers/{{$barber->id}}')" title="Suspend User" class="delete-row delete-color" data-id="{{ $barber->id }}"><i class="icon-user-block mr-3 icon-1x" style="color:red;"></i></a>
    @else
        <a href="javascript:restore('barbers/restore/{{$barber->id}}')" title="Restore User" class="restore-row restore-color" data-id="{{ $barber->id }}"><i
                class="icon-spinner11"></i></a>
    @endif
@endif
