<?php

declare(strict_types=1);

use Touta\Aria\Build\ComponentName;

// Scenario: ComponentName wraps a string via factory method
it('creates a ComponentName from a string', function (): void {
    $name = ComponentName::from('http-client');

    expect($name)->toBeInstanceOf(ComponentName::class)
        ->and($name->value)->toBe('http-client');
});

// Scenario: Two ComponentNames with the same string are equal
it('produces equal instances for the same string', function (): void {
    $a = ComponentName::from('http-client');
    $b = ComponentName::from('http-client');

    expect($a)->toEqual($b);
});

// Scenario: Two ComponentNames with different strings are not equal
it('produces different instances for different strings', function (): void {
    $a = ComponentName::from('http-client');
    $b = ComponentName::from('dns-resolver');

    expect($a)->not->toEqual($b);
});
