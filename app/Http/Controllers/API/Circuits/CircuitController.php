<?php

namespace App\Http\Controllers\API\Circuits;

use App\Http\Controllers\Controller;
use App\Repositories\Circuits\CircuitRepository;
use App\Services\CircuitService;
use Illuminate\Http\Request;

class CircuitController extends Controller
{
    public function __construct(
        protected CircuitRepository $circuitRepository,
        protected CircuitService $circuitService
    ) {
    }

    public function getCircuit(Request $request)
    {
        $name = $request->route('name');

        $this->circuitService->validateCircuitName($name);

        return response()->json(['data' => $this->circuitRepository->getCircuitData($name)], 200);
    }
}
