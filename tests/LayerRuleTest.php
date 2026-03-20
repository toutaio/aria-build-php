<?php

declare(strict_types=1);

use Touta\Aria\Build\ComponentDescriptor;
use Touta\Aria\Build\Layer;
use Touta\Aria\Build\LayerRule;
use Touta\Aria\Runtime\Failure;
use Touta\Aria\Runtime\Success;

it('passes when depending on a lower layer', function (): void {
    $molecule = new ComponentDescriptor('http-client', Layer::L2_MOLECULE, ['tcp-socket']);
    $atom = new ComponentDescriptor('tcp-socket', Layer::L1_ATOM);

    $result = (new LayerRule())->validate($molecule, [$molecule, $atom]);

    expect($result)->toBeInstanceOf(Success::class);
});

it('passes when depending on the same layer', function (): void {
    $a = new ComponentDescriptor('json-parser', Layer::L1_ATOM, ['string-utils']);
    $b = new ComponentDescriptor('string-utils', Layer::L1_ATOM);

    $result = (new LayerRule())->validate($a, [$a, $b]);

    expect($result)->toBeInstanceOf(Success::class);
});

it('fails when depending on a higher layer', function (): void {
    $atom = new ComponentDescriptor('tcp-socket', Layer::L1_ATOM, ['http-client']);
    $molecule = new ComponentDescriptor('http-client', Layer::L2_MOLECULE);

    $result = (new LayerRule())->validate($atom, [$atom, $molecule]);

    expect($result)->toBeInstanceOf(Failure::class);

    $error = $result->error();
    expect($error->message())->toContain('tcp-socket')
        ->and($error->message())->toContain('http-client');
});

it('passes when a component has no dependencies', function (): void {
    $component = new ComponentDescriptor('byte-buffer', Layer::L0_PRIMITIVE);

    $result = (new LayerRule())->validate($component, [$component]);

    expect($result)->toBeInstanceOf(Success::class);
});

it('fails gracefully for an unknown dependency', function (): void {
    $component = new ComponentDescriptor('http-client', Layer::L2_MOLECULE, ['ghost-dep']);

    $result = (new LayerRule())->validate($component, [$component]);

    expect($result)->toBeInstanceOf(Failure::class);

    $error = $result->error();
    expect($error->message())->toContain('ghost-dep');
});
