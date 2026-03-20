<?php

declare(strict_types=1);

use Touta\Aria\Build\ComponentDescriptor;
use Touta\Aria\Build\ComponentName;
use Touta\Aria\Build\Layer;

// Scenario: ComponentDescriptor can be constructed with branded types
it('can be created with name, layer, and dependencies', function (): void {
    $descriptor = new ComponentDescriptor(
        ComponentName::from('http-client'),
        Layer::L2_MOLECULE,
        [ComponentName::from('tcp-socket'), ComponentName::from('dns-resolver')],
    );

    expect($descriptor)->toBeInstanceOf(ComponentDescriptor::class);
});

// Scenario: ComponentDescriptor exposes its ComponentName
it('returns the name', function (): void {
    $descriptor = new ComponentDescriptor(
        ComponentName::from('http-client'),
        Layer::L2_MOLECULE,
        [ComponentName::from('tcp-socket')],
    );

    expect($descriptor->name)->toEqual(ComponentName::from('http-client'));
});

// Scenario: ComponentDescriptor exposes its Layer
it('returns the layer', function (): void {
    $descriptor = new ComponentDescriptor(
        ComponentName::from('http-client'),
        Layer::L2_MOLECULE,
        [ComponentName::from('tcp-socket')],
    );

    expect($descriptor->layer)->toBe(Layer::L2_MOLECULE);
});

// Scenario: ComponentDescriptor exposes its dependency list as ComponentName[]
it('returns the dependency list', function (): void {
    $descriptor = new ComponentDescriptor(
        ComponentName::from('http-client'),
        Layer::L2_MOLECULE,
        [ComponentName::from('tcp-socket'), ComponentName::from('dns-resolver')],
    );

    expect($descriptor->dependencies)->toEqual([
        ComponentName::from('tcp-socket'),
        ComponentName::from('dns-resolver'),
    ]);
});

// Scenario: ComponentDescriptor defaults to empty dependencies
it('returns empty array when no dependencies', function (): void {
    $descriptor = new ComponentDescriptor(ComponentName::from('byte-buffer'), Layer::L0_PRIMITIVE);

    expect($descriptor->dependencies)->toBe([]);
});
