@if(isset($service))
    @if(!$service->trashed())
        <a href="{{ route('services.edit', [$service->id]) }}" title="Edit Project"><i class="icon-pencil5 mr-1 icon-1x"></i></a>
        <a href="javascript:sdelete('services/{{$service->id}}')" title="Suspend User" class="delete-row delete-color" data-id="{{ $service->id }}"><i class="icon-bin mr-3 icon-1x" style="color:red;"></i></a>
    @else
        <a href="javascript:restore('services/restore/{{$service->id}}')" title="Restore User" class="restore-row restore-color" data-id="{{ $service->id }}"><i
                class="icon-loop3"></i></a>
        <a href="javascript:permanent('services/deletePermanently/{{$service->id}}')" title="Delete Permanently" class="delete-permanently-row delete-color" style="margin: 5px;" data-id="{{ $service->id }}"><i
                class="icon-cancel-square2" style="color: red;"></i></a>
    @endif
@endif
