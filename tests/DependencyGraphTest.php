<?php

declare(strict_types=1);

use Touta\Aria\Build\ComponentDescriptor;
use Touta\Aria\Build\DependencyGraph;
use Touta\Aria\Build\Layer;

it('reports no cycle in an empty graph', function (): void {
    $graph = new DependencyGraph();

    expect($graph->hasCycle())->toBeFalse();
});

it('reports no cycle for linear dependencies', function (): void {
    $graph = new DependencyGraph();
    $graph->addComponent(new ComponentDescriptor('a', Layer::L2_MOLECULE, ['b']));
    $graph->addComponent(new ComponentDescriptor('b', Layer::L1_ATOM, ['c']));
    $graph->addComponent(new ComponentDescriptor('c', Layer::L0_PRIMITIVE));

    expect($graph->hasCycle())->toBeFalse();
});

it('detects a direct A→B→A cycle', function (): void {
    $graph = new DependencyGraph();
    $graph->addComponent(new ComponentDescriptor('a', Layer::L1_ATOM, ['b']));
    $graph->addComponent(new ComponentDescriptor('b', Layer::L1_ATOM, ['a']));

    expect($graph->hasCycle())->toBeTrue();
});

it('detects an indirect A→B→C→A cycle', function (): void {
    $graph = new DependencyGraph();
    $graph->addComponent(new ComponentDescriptor('a', Layer::L2_MOLECULE, ['b']));
    $graph->addComponent(new ComponentDescriptor('b', Layer::L1_ATOM, ['c']));
    $graph->addComponent(new ComponentDescriptor('c', Layer::L0_PRIMITIVE, ['a']));

    expect($graph->hasCycle())->toBeTrue();
});

it('retrieves all added components', function (): void {
    $graph = new DependencyGraph();
    $a = new ComponentDescriptor('a', Layer::L1_ATOM);
    $b = new ComponentDescriptor('b', Layer::L0_PRIMITIVE);

    $graph->addComponent($a);
    $graph->addComponent($b);

    expect($graph->getComponents())->toBe([$a, $b]);
});
