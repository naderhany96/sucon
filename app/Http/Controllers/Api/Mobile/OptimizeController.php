<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Artisan;
use Appstract\Opcache\OpcacheFacade as OPcache;

class OptimizeController extends ApiController
{
    public function optimize()
    {
        Artisan::call('optimize');
        OPcache::compile(true);
        
        return 'done';
    }
    
    public function clear()
    {
        OPcache::clear();
        Artisan::call('optimize:clear');

        return 'done';
    }

    public function status()
    {
        return OPcache::getStatus();
    }

}
