<?php

namespace App\Http\Controllers\API\Drivers;

use App\Http\Controllers\Controller;
use App\Repositories\Drivers\DriverRepository;
use Illuminate\Http\Request;
use App\Services\DriverService;

class DriverController extends Controller
{
    public function __construct(
        protected DriverRepository $driverRepository,
        protected DriverService $driverService
    ) {
    }

    public function getDriver(Request $request)
    {
        $name = $request->route('name');

        $this->driverService->validateDriverName($name);

        return response()->json(['data' => $this->driverRepository->getDriverData($name)], 200);
    }
}
