<?php

namespace App\Http\Controllers;

use App\Jobs\SendExportEmailJob;
use App\Jobs\StoreExportDataJob;
use App\Jobs\ExportJob;
use App\Services\PunkapiService;
use App\Http\Requests\BeerRequest;

class BeerController extends Controller
{
    public function index(BeerRequest $request, PunkapiService $service)
    {
        return $service->getBeers( ...$request->validated());
    }

    public function export(BeerRequest $request, PunkapiService $service)
    {
        $filename = "cervejas-encontradas-". now()->format("Y-m-d - H_i") . ".xlsx";

        ExportJob::withChain([
            new SendExportEmailJob($filename),
            new StoreExportDataJob(auth()->user(), $filename)
        ])->dispatch($request->validated(), $filename);

        return 'relatorio criado';
    }
}
