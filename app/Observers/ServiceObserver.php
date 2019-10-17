<?php

namespace App\Observers;

use App\Service;

class ServiceObserver
{
    public function creating(Service $service){
        $service->created_by = auth()->id();
        if (auth()->user()->hasRole('admin')){
            $service->status = 'active';
        }
    }
}
