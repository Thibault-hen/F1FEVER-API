<?php

namespace App\Http\Controllers\API\Constructors;

use App\Http\Controllers\Controller;
use App\Repositories\Constructors\ConstructorRepository;
use App\Services\ConstructorService;
use Illuminate\Http\Request;

class ConstructorController extends Controller
{
    protected $constructorRepository;
    protected $constructorService;
    public function __construct(ConstructorRepository $constructorRepository, ConstructorService $constructorService)
    {
        $this->constructorRepository = $constructorRepository;
        $this->constructorService = $constructorService;
    }
    public function getConstructor(Request $request)
    {
        $name = $request->route("name");

        $this->constructorService->validateConstructorName($name);

        return response()->json(['Constructor' => $this->constructorRepository->getConstructorData($name)], 200);
    }
}
