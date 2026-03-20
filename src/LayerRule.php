<?php

declare(strict_types=1);

namespace Touta\Aria\Build;

use Touta\Aria\Runtime\Failure;
use Touta\Aria\Runtime\Result;
use Touta\Aria\Runtime\Success;

final class LayerRule
{
    /**
     * @param array<ComponentDescriptor> $allComponents
     *
     * @return Success<bool>|Failure<BuildError>
     */
    public function validate(ComponentDescriptor $component, array $allComponents): Result
    {
        /** @var array<string, ComponentDescriptor> $index */
        $index = [];
        foreach ($allComponents as $c) {
            $index[$c->name->value] = $c;
        }

        foreach ($component->dependencies as $depName) {
            if (!isset($index[$depName->value])) {
                return Failure::from(new BuildError(
                    BuildError::INVALID_COMPONENT,
                    "Component \"{$component->name->value}\" depends on unknown component \"{$depName->value}\"",
                    ['component' => $component->name->value, 'dependency' => $depName->value],
                ));
            }

            $dep = $index[$depName->value];

            if ($dep->layer->ordinal() > $component->layer->ordinal()) {
                return Failure::from(new BuildError(
                    BuildError::LAYER_VIOLATION,
                    "Component \"{$component->name->value}\" (L{$component->layer->ordinal()}) depends on \"{$dep->name->value}\" (L{$dep->layer->ordinal()}), which is a higher layer",
                    ['component' => $component->name->value, 'dependency' => $dep->name->value],
                ));
            }
        }

        return Success::of(true);
    }
}
