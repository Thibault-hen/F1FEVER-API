<?php

namespace App\Http\Controllers\API\Circuits;

use App\Http\Controllers\Controller;
use App\Repositories\Circuits\CircuitRepository;
use App\Services\CircuitService;
use Illuminate\Http\Request;

class CircuitController extends Controller
{
    protected $circuitRepository;
    protected $circuitService;
    public function __construct(CircuitRepository $circuitRepository, CircuitService $circuitService)
    {
        $this->circuitRepository = $circuitRepository;
        $this->circuitService = $circuitService;
    }

    public function getCircuit(Request $request)
    {
        $name = $request->route("name");

        $this->circuitService->validateCircuitName($name);

        return response()->json(['Data' => $this->circuitRepository->getCircuitData($name)], 200);
    }
}
