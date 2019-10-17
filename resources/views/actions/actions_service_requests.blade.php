@if(isset($service))
        <a href="javascript:restore('service/accept/{{$service->id}}')" title="Suspend User" class="delete-row delete-color" data-id="{{ $service->id }}"><i class="icon-checkbox-checked mr-3 icon-1x" style="color:green;"></i></a>
        <a href="javascript:sdelete('service/reject/{{$service->id}}')" title="Suspend User" class="delete-row delete-color" data-id="{{ $service->id }}"><i class="icon-cross2 mr-3 icon-1x" style="color:red;"></i></a>
@endif
@if(isset($user))
    <a href="javascript:restorer('barber/accept/{{$user->id}}')" title="Suspend User" class="delete-row delete-color" data-id="{{ $user->id }}"><i class="icon-checkbox-checked mr-3 icon-1x" style="color:green;"></i></a>
    <a href="javascript:sdeleter('barber/reject/{{$user->id}}')" title="Suspend User" class="delete-row delete-color" data-id="{{ $user->id }}"><i class="icon-cross2 mr-3 icon-1x" style="color:red;"></i></a>
@endif
