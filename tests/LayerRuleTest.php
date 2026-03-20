<?php

declare(strict_types=1);

use Touta\Aria\Build\BuildError;
use Touta\Aria\Build\ComponentDescriptor;
use Touta\Aria\Build\ComponentName;
use Touta\Aria\Build\Layer;
use Touta\Aria\Build\LayerRule;
use Touta\Aria\Runtime\Failure;
use Touta\Aria\Runtime\Success;

// Scenario: LayerRule passes when component depends on a lower layer
it('passes when depending on a lower layer', function (): void {
    $molecule = new ComponentDescriptor(ComponentName::from('http-client'), Layer::L2_MOLECULE, [ComponentName::from('tcp-socket')]);
    $atom = new ComponentDescriptor(ComponentName::from('tcp-socket'), Layer::L1_ATOM);

    $result = (new LayerRule())->validate($molecule, [$molecule, $atom]);

    expect($result)->toBeInstanceOf(Success::class);
});

// Scenario: LayerRule passes when component depends on the same layer
it('passes when depending on the same layer', function (): void {
    $a = new ComponentDescriptor(ComponentName::from('json-parser'), Layer::L1_ATOM, [ComponentName::from('string-utils')]);
    $b = new ComponentDescriptor(ComponentName::from('string-utils'), Layer::L1_ATOM);

    $result = (new LayerRule())->validate($a, [$a, $b]);

    expect($result)->toBeInstanceOf(Success::class);
});

// Scenario: LayerRule fails with LAYER_VIOLATION when depending on a higher layer
it('fails when depending on a higher layer', function (): void {
    $atom = new ComponentDescriptor(ComponentName::from('tcp-socket'), Layer::L1_ATOM, [ComponentName::from('http-client')]);
    $molecule = new ComponentDescriptor(ComponentName::from('http-client'), Layer::L2_MOLECULE);

    $result = (new LayerRule())->validate($atom, [$atom, $molecule]);

    expect($result)->toBeInstanceOf(Failure::class);

    $error = $result->error();
    expect($error)->toBeInstanceOf(BuildError::class)
        ->and($error->code)->toBe(BuildError::LAYER_VIOLATION)
        ->and($error->message)->toContain('tcp-socket')
        ->and($error->message)->toContain('http-client');
});

// Scenario: LayerRule passes when a component has no dependencies
it('passes when a component has no dependencies', function (): void {
    $component = new ComponentDescriptor(ComponentName::from('byte-buffer'), Layer::L0_PRIMITIVE);

    $result = (new LayerRule())->validate($component, [$component]);

    expect($result)->toBeInstanceOf(Success::class);
});

// Scenario: LayerRule fails with INVALID_COMPONENT for an unknown dependency
it('fails gracefully for an unknown dependency', function (): void {
    $component = new ComponentDescriptor(ComponentName::from('http-client'), Layer::L2_MOLECULE, [ComponentName::from('ghost-dep')]);

    $result = (new LayerRule())->validate($component, [$component]);

    expect($result)->toBeInstanceOf(Failure::class);

    $error = $result->error();
    expect($error)->toBeInstanceOf(BuildError::class)
        ->and($error->code)->toBe(BuildError::INVALID_COMPONENT)
        ->and($error->message)->toContain('ghost-dep');
});
