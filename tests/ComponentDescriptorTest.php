<?php

declare(strict_types=1);

use Touta\Aria\Build\ComponentDescriptor;
use Touta\Aria\Build\Layer;

it('can be created with name, layer, and dependencies', function (): void {
    $descriptor = new ComponentDescriptor('http-client', Layer::L2_MOLECULE, ['tcp-socket', 'dns-resolver']);

    expect($descriptor)->toBeInstanceOf(ComponentDescriptor::class);
});

it('returns the name', function (): void {
    $descriptor = new ComponentDescriptor('http-client', Layer::L2_MOLECULE, ['tcp-socket']);

    expect($descriptor->name)->toBe('http-client');
});

it('returns the layer', function (): void {
    $descriptor = new ComponentDescriptor('http-client', Layer::L2_MOLECULE, ['tcp-socket']);

    expect($descriptor->layer)->toBe(Layer::L2_MOLECULE);
});

it('returns the dependency list', function (): void {
    $descriptor = new ComponentDescriptor('http-client', Layer::L2_MOLECULE, ['tcp-socket', 'dns-resolver']);

    expect($descriptor->dependencies)->toBe(['tcp-socket', 'dns-resolver']);
});

it('returns empty array when no dependencies', function (): void {
    $descriptor = new ComponentDescriptor('byte-buffer', Layer::L0_PRIMITIVE);

    expect($descriptor->dependencies)->toBe([]);
});
