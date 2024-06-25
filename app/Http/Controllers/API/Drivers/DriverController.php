<?php

namespace App\Http\Controllers\API\Drivers;

use App\Http\Controllers\Controller;
use App\Repositories\Drivers\DriverRepository;
use Illuminate\Http\Request;
use App\Services\DriverService;

class DriverController extends Controller
{
    protected $driverRepository;
    protected $driverService;
    public function __construct(DriverRepository $driverRepository, DriverService $driverService)
    {
        $this->driverRepository = $driverRepository;
        $this->driverService = $driverService;
    }

    public function getDriver(Request $request)
    {
        $name = $request->route("name");

        $this->driverService->validateDriverName($name);

        return response()->json(['Data' => $this->driverRepository->getDriverData($name)], 200);
    }
}
