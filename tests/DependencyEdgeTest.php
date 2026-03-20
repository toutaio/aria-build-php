<?php

declare(strict_types=1);

use Touta\Aria\Build\ComponentName;
use Touta\Aria\Build\DependencyEdge;

// Scenario: DependencyEdge wraps a from→to component relationship
it('creates a DependencyEdge with from and to component names', function (): void {
    $edge = new DependencyEdge(
        ComponentName::from('http-client'),
        ComponentName::from('tcp-socket'),
    );

    expect($edge->fromComponent)->toEqual(ComponentName::from('http-client'))
        ->and($edge->toComponent)->toEqual(ComponentName::from('tcp-socket'));
});

// Scenario: Two DependencyEdges with the same from/to are equal
it('produces equal edges for the same from/to pair', function (): void {
    $a = new DependencyEdge(ComponentName::from('a'), ComponentName::from('b'));
    $b = new DependencyEdge(ComponentName::from('a'), ComponentName::from('b'));

    expect($a)->toEqual($b);
});

// Scenario: DependencyEdges with swapped from/to are not equal
it('considers direction — swapped edges are not equal', function (): void {
    $ab = new DependencyEdge(ComponentName::from('a'), ComponentName::from('b'));
    $ba = new DependencyEdge(ComponentName::from('b'), ComponentName::from('a'));

    expect($ab)->not->toEqual($ba);
});
