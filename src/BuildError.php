<?php

declare(strict_types=1);

namespace Touta\Aria\Build;

final readonly class BuildError
{
    public const LAYER_VIOLATION = 'BUILD.LAYER_VIOLATION';
    public const CYCLE_DETECTED = 'BUILD.CYCLE_DETECTED';
    public const INVALID_COMPONENT = 'BUILD.INVALID_COMPONENT';

    /**
     * @param array<string, mixed> $context
     */
    public function __construct(
        public string $code,
        public string $message,
        public array $context = [],
    ) {}

    public function withMessage(string $message): self
    {
        return new self($this->code, $message, $this->context);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function withContext(array $context): self
    {
        return new self($this->code, $this->message, array_merge($this->context, $context));
    }
}
