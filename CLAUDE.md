# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Symfony 7.1 API backend for ArtList.dev (https://artlist.dev/), a Minecraft server list application. The frontend repository is at https://github.com/Wojtazzzz/ArtList.dev.

**Stack:**
- PHP 8.2+
- Symfony 7.1
- Doctrine ORM 3.2
- PostgreSQL
- Symfony Messenger for CQRS

## Development Commands

### Setup
```bash
composer install                          # Install dependencies
docker compose up -d                      # Start PostgreSQL database
php bin/console doctrine:migrations:migrate  # Run database migrations
```

### Common Commands
```bash
php bin/console <command>                 # Run Symfony console commands
php bin/console doctrine:migrations:migrate  # Run migrations
php bin/console doctrine:migrations:diff  # Generate migration from entity changes
vendor/bin/phpstan analyse                # Run static analysis (level 6)
```

### Testing
There is no test runner configured in composer.json. Tests are located in `tests/` directory.

## Architecture

### CQRS Pattern
The application uses **CQRS (Command Query Responsibility Segregation)** via Symfony Messenger:
- **Commands** (write operations) implement `App\Shared\Command` interface
- **Queries** (read operations) implement `App\Shared\Query` interface
- **CommandBus** (`App\Shared\MessengerCommandBus`) handles commands
- **QueryBus** (`App\Shared\MessengerQueryBus`) handles queries
- Handlers are automatically registered via `_instanceof` in `config/services.yaml`

### Modular Structure
Code is organized into modules under `src/Modules/`. Currently contains:
- **Servers** - Main module for Minecraft server management

Each module follows **Clean Architecture/Hexagonal Architecture** with layers:

```
src/Modules/{ModuleName}/
├── Api/                    # Controllers, HTTP layer (Route attributes)
├── Application/           # Use cases, DTOs
│   ├── Commands/         # Write operations (CQRS)
│   ├── Queries/          # Read operations (CQRS)
│   ├── Dto/              # Response DTOs
│   └── Services/         # Application services
├── Domain/                # Business logic, entities, value objects
│   ├── Entities/         # Domain entities (not Doctrine entities)
│   ├── ValueObjects/     # Immutable value objects
│   ├── Repositories/     # Repository interfaces
│   ├── Services/         # Domain services
│   └── Clients/          # External client interfaces
└── Infrastructure/        # Framework/DB implementations
    ├── Entities/         # Doctrine entities (DB mapping)
    ├── Repositories/     # Doctrine repository implementations
    └── Clients/          # External API client implementations
```

### Domain vs Infrastructure Entities
The project separates domain entities from persistence:
- **Domain entities** (`Domain/Entities/`) are plain PHP objects representing business concepts
- **Infrastructure entities** (`Infrastructure/Entities/`) are Doctrine-mapped entities for database persistence
- This separation keeps domain logic independent of Doctrine

### Shared Layer
`src/Shared/` contains cross-cutting concerns:
- CQRS abstractions (`Command`, `Query`, `CommandBus`, `QueryBus`)
- Exception handling (`Exceptions/ExceptionListener`)
- Shared interfaces and base classes

## Key Patterns

### Controllers
Controllers use PHP 8 attributes for routing and automatic request/response mapping:
```php
#[Route(path: '/servers', name: 'servers.index', methods: ['GET'])]
#[MapQueryString(validationGroups: ['strict', 'edit'])]
#[MapRequestPayload(validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY)]
```

### Adding New Features
When adding new features to a module:
1. Define Command/Query in `Application/Commands/` or `Application/Queries/`
2. Create corresponding Handler implementing `CommandHandler` or `QueryHandler`
3. Add domain logic in `Domain/` (entities, value objects, services)
4. Implement infrastructure in `Infrastructure/` (repositories, external clients)
5. Expose via controller in `Api/` using Route attributes
6. Register in `config/packages/messenger.yaml` routing if using async transport

### Dependency Injection
- Autowiring and autoconfiguration are enabled by default
- Services in `src/` are automatically registered
- Use constructor injection for dependencies
- Configure custom service arguments in `config/services.yaml` when needed

## Important Configuration

### Environment Variables
See `.env.example` for required variables:
- `DATABASE_URL` - PostgreSQL connection string
- `CRON_SECRET` - Bearer token for cron endpoints (e.g., server updates)
- `APP_SECRET` - Symfony application secret

### Database
- PostgreSQL database runs via Docker Compose
- Connection configured in `DATABASE_URL`
- Migrations in `migrations/` directory

### Messenger/CQRS Bus Configuration
Query bus configuration is in `config/packages/messenger.yaml`:
- Query handlers are tagged automatically via `_instanceof` in `services.yaml`
- Routing maps query classes to transports (currently using `sync`)

## Server Module Specifics

The Servers module manages Minecraft server listings:
- Fetches server data from external API (Mcsrvstat3Client)
- Stores server information and statistics
- Provides REST API for server listing, filtering, and pagination
- Handles both online and offline server states
- Server icons stored in `public/servers/` (configured via `ServerStorage` service)

### Cron/Scheduled Jobs
- `/servers` PUT endpoint updates server data (requires `CRON_SECRET` bearer token)
- Statistics can be destroyed via command (see `DestroyStatisticsCommand`)
