<?php

namespace App\Services\Sources;

interface SourceInterface
{
    public function fetch(): array;
}
