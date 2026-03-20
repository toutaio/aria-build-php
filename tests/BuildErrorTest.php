<?php

declare(strict_types=1);

use Touta\Aria\Build\BuildError;

// Scenario: BuildError is created with code and message
it('creates a BuildError with code and message', function (): void {
    $error = new BuildError(BuildError::LAYER_VIOLATION, 'Component X violates layer rule');

    expect($error->code)->toBe('BUILD.LAYER_VIOLATION')
        ->and($error->message)->toBe('Component X violates layer rule')
        ->and($error->context)->toBe([]);
});

// Scenario: BuildError is created with context
it('creates a BuildError with context', function (): void {
    $error = new BuildError(
        BuildError::CYCLE_DETECTED,
        'Cycle found',
        ['components' => ['a', 'b']],
    );

    expect($error->code)->toBe('BUILD.CYCLE_DETECTED')
        ->and($error->context)->toBe(['components' => ['a', 'b']]);
});

// Scenario: withMessage returns a new BuildError with updated message
it('returns new instance with updated message via withMessage', function (): void {
    $original = new BuildError(BuildError::INVALID_COMPONENT, 'original');
    $updated = $original->withMessage('updated');

    expect($updated->message)->toBe('updated')
        ->and($updated->code)->toBe(BuildError::INVALID_COMPONENT)
        ->and($original->message)->toBe('original');
});

// Scenario: withContext returns a new BuildError with merged context
it('returns new instance with merged context via withContext', function (): void {
    $original = new BuildError(BuildError::LAYER_VIOLATION, 'msg', ['a' => 1]);
    $updated = $original->withContext(['b' => 2]);

    expect($updated->context)->toBe(['a' => 1, 'b' => 2])
        ->and($original->context)->toBe(['a' => 1]);
});

// Scenario: BuildError error code constants are correctly prefixed
it('has correctly prefixed error code constants', function (): void {
    expect(BuildError::LAYER_VIOLATION)->toBe('BUILD.LAYER_VIOLATION')
        ->and(BuildError::CYCLE_DETECTED)->toBe('BUILD.CYCLE_DETECTED')
        ->and(BuildError::INVALID_COMPONENT)->toBe('BUILD.INVALID_COMPONENT');
});
