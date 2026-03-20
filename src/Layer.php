<?php

declare(strict_types=1);

namespace Touta\Aria\Build;

enum Layer: int
{
    case L0_PRIMITIVE = 0;
    case L1_ATOM = 1;
    case L2_MOLECULE = 2;
    case L3_ORGANISM = 3;
    case L4_SYSTEM = 4;
    case L5_DOMAIN = 5;

    public function ordinal(): int
    {
        return $this->value;
    }
}
