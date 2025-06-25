<?php

namespace App\Transformers;

interface NewsTransformerInterface
{
    public function transform(array $raw): array;
}
