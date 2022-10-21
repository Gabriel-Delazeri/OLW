<?php

namespace App\Http\Controllers;

use App\Services\PunkapiService;

class BeerController extends Controller
{
    public function index()
    {
        $service = new PunkapiService();

        return $service->getBeers();
    }

}
