<?php

declare(strict_types=1);

use Touta\Aria\Build\LayerName;

// Scenario: LayerName wraps a string via factory method
it('creates a LayerName from a string', function (): void {
    $name = LayerName::from('L0_PRIMITIVE');

    expect($name)->toBeInstanceOf(LayerName::class)
        ->and($name->value)->toBe('L0_PRIMITIVE');
});

// Scenario: Two LayerNames with the same string are equal
it('produces equal instances for the same string', function (): void {
    $a = LayerName::from('L1_ATOM');
    $b = LayerName::from('L1_ATOM');

    expect($a)->toEqual($b);
});

// Scenario: Two LayerNames with different strings are not equal
it('produces different instances for different strings', function (): void {
    $a = LayerName::from('L0_PRIMITIVE');
    $b = LayerName::from('L1_ATOM');

    expect($a)->not->toEqual($b);
});
