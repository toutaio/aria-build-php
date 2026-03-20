<?php

declare(strict_types=1);

namespace Touta\Aria\Build;

final class DependencyGraph
{
    /** @var array<string, ComponentDescriptor> */
    private array $components = [];

    public function addComponent(ComponentDescriptor $component): void
    {
        $this->components[$component->name->value] = $component;
    }

    public function hasCycle(): bool
    {
        /** @var array<string, 'visiting'|'visited'> $state */
        $state = [];

        foreach (array_keys($this->components) as $name) {
            if (!isset($state[$name]) && $this->dfs($name, $state)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return list<ComponentDescriptor>
     */
    public function getComponents(): array
    {
        return array_values($this->components);
    }

    /**
     * @param array<string, 'visiting'|'visited'> $state
     */
    private function dfs(string $name, array &$state): bool
    {
        $state[$name] = 'visiting';

        $component = $this->components[$name] ?? null;

        if ($component !== null) {
            foreach ($component->dependencies as $dep) {
                if (($state[$dep->value] ?? null) === 'visiting') {
                    return true;
                }

                if (!isset($state[$dep->value]) && $this->dfs($dep->value, $state)) {
                    return true;
                }
            }
        }

        $state[$name] = 'visited';

        return false;
    }
}
