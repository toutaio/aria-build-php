<?php

declare(strict_types=1);

use Touta\Aria\Build\ComponentDescriptor;
use Touta\Aria\Build\ComponentName;
use Touta\Aria\Build\DependencyGraph;
use Touta\Aria\Build\Layer;

// Scenario: Empty graph has no cycle
it('reports no cycle in an empty graph', function (): void {
    $graph = new DependencyGraph();

    expect($graph->hasCycle())->toBeFalse();
});

// Scenario: Linear dependency chain has no cycle
it('reports no cycle for linear dependencies', function (): void {
    $graph = new DependencyGraph();
    $graph->addComponent(new ComponentDescriptor(ComponentName::from('a'), Layer::L2_MOLECULE, [ComponentName::from('b')]));
    $graph->addComponent(new ComponentDescriptor(ComponentName::from('b'), Layer::L1_ATOM, [ComponentName::from('c')]));
    $graph->addComponent(new ComponentDescriptor(ComponentName::from('c'), Layer::L0_PRIMITIVE));

    expect($graph->hasCycle())->toBeFalse();
});

// Scenario: Direct A→B→A cycle is detected
it('detects a direct A→B→A cycle', function (): void {
    $graph = new DependencyGraph();
    $graph->addComponent(new ComponentDescriptor(ComponentName::from('a'), Layer::L1_ATOM, [ComponentName::from('b')]));
    $graph->addComponent(new ComponentDescriptor(ComponentName::from('b'), Layer::L1_ATOM, [ComponentName::from('a')]));

    expect($graph->hasCycle())->toBeTrue();
});

// Scenario: Indirect A→B→C→A cycle is detected
it('detects an indirect A→B→C→A cycle', function (): void {
    $graph = new DependencyGraph();
    $graph->addComponent(new ComponentDescriptor(ComponentName::from('a'), Layer::L2_MOLECULE, [ComponentName::from('b')]));
    $graph->addComponent(new ComponentDescriptor(ComponentName::from('b'), Layer::L1_ATOM, [ComponentName::from('c')]));
    $graph->addComponent(new ComponentDescriptor(ComponentName::from('c'), Layer::L0_PRIMITIVE, [ComponentName::from('a')]));

    expect($graph->hasCycle())->toBeTrue();
});

// Scenario: All added components are retrievable
it('retrieves all added components', function (): void {
    $graph = new DependencyGraph();
    $a = new ComponentDescriptor(ComponentName::from('a'), Layer::L1_ATOM);
    $b = new ComponentDescriptor(ComponentName::from('b'), Layer::L0_PRIMITIVE);

    $graph->addComponent($a);
    $graph->addComponent($b);

    expect($graph->getComponents())->toBe([$a, $b]);
});
