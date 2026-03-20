<?php

declare(strict_types=1);

use Touta\Aria\Build\Layer;

// Scenario: Layer enum has exactly 6 cases
it('has all 6 layers', function (): void {
    $cases = Layer::cases();

    expect($cases)->toHaveCount(6);
});

// Scenario: Layer enum contains L0 through L5
it('contains L0 through L5', function (): void {
    expect(Layer::L0_PRIMITIVE)->toBeInstanceOf(Layer::class)
        ->and(Layer::L1_ATOM)->toBeInstanceOf(Layer::class)
        ->and(Layer::L2_MOLECULE)->toBeInstanceOf(Layer::class)
        ->and(Layer::L3_ORGANISM)->toBeInstanceOf(Layer::class)
        ->and(Layer::L4_SYSTEM)->toBeInstanceOf(Layer::class)
        ->and(Layer::L5_DOMAIN)->toBeInstanceOf(Layer::class);
});

// Scenario: Layer ordinals match their numeric tier
it('assigns correct ordinal values', function (): void {
    expect(Layer::L0_PRIMITIVE->ordinal())->toBe(0)
        ->and(Layer::L1_ATOM->ordinal())->toBe(1)
        ->and(Layer::L2_MOLECULE->ordinal())->toBe(2)
        ->and(Layer::L3_ORGANISM->ordinal())->toBe(3)
        ->and(Layer::L4_SYSTEM->ordinal())->toBe(4)
        ->and(Layer::L5_DOMAIN->ordinal())->toBe(5);
});

// Scenario: Lower layers have smaller ordinals than higher layers
it('orders lower layers below higher layers', function (): void {
    $layers = Layer::cases();

    for ($i = 0; $i < count($layers) - 1; $i++) {
        expect($layers[$i]->ordinal())->toBeLessThan($layers[$i + 1]->ordinal());
    }
});
