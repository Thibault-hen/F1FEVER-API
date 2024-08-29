<?php

namespace App\Http\Controllers\API\Records;

use App\Http\Controllers\Controller;
use App\Repositories\Records\RecordsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecordsController extends Controller
{
    public function __construct(protected RecordsRepository $recordsRepository)
    {
    }
    public function getDriversRecords(): JsonResponse
    {
        $this->recordsRepository->setDriversRecords();

        return response()->json(['data' => $this->recordsRepository->getDriversRecords()], 200);
    }

    public function getConstructorsRecords(): JsonResponse
    {
        $this->recordsRepository->setConstructorsRecords();

        return response()->json(['data' => $this->recordsRepository->getConstructorsRecords()], 200);
    }
}
