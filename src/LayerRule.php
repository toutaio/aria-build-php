<?php

declare(strict_types=1);

namespace Touta\Aria\Build;

use Touta\Aria\Runtime\Failure;
use Touta\Aria\Runtime\Result;
use Touta\Aria\Runtime\StructuredFailure;
use Touta\Aria\Runtime\Success;

final class LayerRule
{
    /**
     * @param array<ComponentDescriptor> $allComponents
     *
     * @return Success<bool>|Failure<StructuredFailure>
     */
    public function validate(ComponentDescriptor $component, array $allComponents): Result
    {
        /** @var array<string, ComponentDescriptor> $index */
        $index = [];
        foreach ($allComponents as $c) {
            $index[$c->name] = $c;
        }

        foreach ($component->dependencies as $depName) {
            if (!isset($index[$depName])) {
                return Failure::from(new StructuredFailure(
                    'UNKNOWN_DEPENDENCY',
                    "Component \"{$component->name}\" depends on unknown component \"{$depName}\"",
                    ['component' => $component->name, 'dependency' => $depName],
                ));
            }

            $dep = $index[$depName];

            if ($dep->layer->ordinal() > $component->layer->ordinal()) {
                return Failure::from(new StructuredFailure(
                    'LAYER_VIOLATION',
                    "Component \"{$component->name}\" (L{$component->layer->ordinal()}) depends on \"{$dep->name}\" (L{$dep->layer->ordinal()}), which is a higher layer",
                    ['component' => $component->name, 'dependency' => $dep->name],
                ));
            }
        }

        return Success::of(true);
    }
}
