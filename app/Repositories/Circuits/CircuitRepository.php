<?php

namespace App\Repositories\Circuits;

use App\Models\Circuits;
use Illuminate\Database\Eloquent\Collection;

class CircuitRepository
{
    protected $circuitId;

    private function setCircuitId(string $name): void
    {
        $this->circuitId = Circuits::where('circuitRef', $name)
            ->value('circuitId');
    }

    public function getCircuitData(string $name): Collection
    {
        $this->setCircuitId($name);

        return Circuits::where('circuitId', $this->circuitId)
            ->get();
    }
}
