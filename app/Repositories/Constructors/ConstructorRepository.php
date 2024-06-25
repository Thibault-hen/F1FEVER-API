<?php

namespace App\Repositories\Constructors;

use App\Models\Constructors;
use Illuminate\Database\Eloquent\Collection;

class ConstructorRepository
{
    protected $constructorId;

    private function setConstructorId(string $name): void
    {
        $this->constructorId = Constructors::where('constructorRef', $name)
            ->value('constructorId');
    }

    public function getConstructorData(string $name): Collection
    {
        $this->setConstructorId($name);

        return Constructors::where('constructorId', $this->constructorId)
            ->get();
    }
}
