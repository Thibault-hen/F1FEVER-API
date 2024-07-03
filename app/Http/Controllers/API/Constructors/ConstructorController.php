<?php

namespace App\Http\Controllers\API\Constructors;

use App\Http\Controllers\Controller;
use App\Repositories\Constructors\ConstructorRepository;
use App\Services\ConstructorService;
use Illuminate\Http\Request;

class ConstructorController extends Controller
{
    public function __construct(
        protected ConstructorRepository $constructorRepository,
        protected ConstructorService $constructorService
    ) {
    }
    public function getConstructor(Request $request)
    {
        $name = $request->route('name');

        $this->constructorService->validateConstructorName($name);

        return response()->json(['data' => $this->constructorRepository->getConstructorData($name)], 200);
    }
}
