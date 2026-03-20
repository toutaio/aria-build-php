# aria-build-php

ARIA build-time tooling for the Touta PHP ecosystem.

## Install

```bash
composer require touta/aria-build-php
```

## What's included

- **Layer** — Enum representing the 6 ARIA architecture layers
- **ComponentDescriptor** — Value object describing a component's architectural position
- **LayerRule** — Validates that dependencies only flow downward through layers
- **DependencyGraph** — Directed graph with cycle detection

## Quality

```bash
composer qa        # Full quality gate (lint + analyse + test)
composer test      # Run tests only
composer analyse   # PHPStan at max level
composer lint      # Check formatting
```

## License

MIT
