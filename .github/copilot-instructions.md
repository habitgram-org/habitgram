# Habitgram AI Coding Instructions

## Architecture Overview

**Stack**: Laravel 12 (PHP 8.4+) + Inertia.js + React + TypeScript + Tailwind CSS + shadcn/ui

### Core Domain Pattern: Polymorphic Habit Types
The app uses **polymorphic relationships** to model different habit tracking types:
- `Habit` model (parent) with `habitable_type` and `habitable_id`
- Concrete types: `CountHabit`, `AbstinenceHabit`, `DailyHabit` (in `app/Models/{Count,Abstinence,Daily}/`)
- Each type has its own entries table and business logic
- Frontend mirrors this with discriminated union types in [types/index.d.ts](resources/js/types/index.d.ts)

### Backend Request Flow
```
Route → Controller → Action → DTO
    ↓       ↓          ↓
   Gate  Request  Transaction
```

**Key conventions:**
- **Actions** (`app/Actions/`): Single-purpose business logic classes (e.g., [CreateCountHabitEntry.php](app/Actions/Habit/Count/Entry/CreateCountHabitEntry.php))
- **DTOs**: Use `spatie/laravel-data` for type-safe data transfer (e.g., [CreateCountHabitEntryDTO.php](app/DTOs/Habit/Count/Entry/CreateCountHabitEntryDTO.php))
- **Requests**: Always define `getDTO()` method returning DTO instance (see [StoreCountHabitEntryRequest.php](app/Http/Requests/Habit/Count/Entry/StoreCountHabitEntryRequest.php))
- **Resources**: Transform models to frontend-safe structures using `spatie/laravel-data` Resources
- **Enums**: Use backed enums with `EnumHelperTrait` (see [HabitType.php](app/Enums/HabitType.php))

### Frontend Conventions
- **Component structure**: `resources/js/{components,pages,layouts}/`
- **UI components**: shadcn/ui in `components/ui/`, styled with Tailwind v4
- **Types**: TypeScript interfaces in [types/index.d.ts](resources/js/types/index.d.ts) - mirror backend enums exactly
- **Forms**: Use Inertia's `<Form>` component with `route()` helper from Ziggy
- **State**: Inertia shared data in `SharedData` interface - access via `usePage<SharedData>().props`
- **Styling**: Use `cn()` utility from [lib/utils.ts](resources/js/lib/utils.ts) for conditional classes

## Development Workflows

### Running Locally
```bash
# Full dev environment (recommended)
composer dev  # Runs: server, queue, logs (pail), vite concurrently

# Or with Docker
make up && make app-console
```

### Code Quality & Testing
```bash
# PHP
composer lint              # Laravel Pint (PSR-12)
composer refactor         # Rector + Pint
composer test:types       # PHPStan static analysis
docker exec -it habitgram_app sh -c "vendor/bin/pest" # Pest tests

# TypeScript/React
npm run lint              # ESLint
npm run format           # Prettier (auto-organizes imports)
npm run types            # TypeScript compiler check
```

### Database
- **Migrations**: UUID primary keys via `HasUuids` trait
- **Soft deletes**: Always use `SoftDeletes` for user-facing models
- **Factories**: Available for all models in `database/factories/`

## Critical Patterns

### Authorization
Use Laravel's Gate via controller dependency injection:
```php
public function __construct(private Gate $gate) {}
$this->gate->authorize('is-participant', [Habit::class, $habit]);
```

### Transaction Boundaries
Wrap all multi-step database operations in `DB::transaction()` (see Actions)

### Frontend Data Hydration
- Models → Resources → Inertia props → React components
- Resources define exact shape sent to frontend (example: [CountHabitResource](app/Http/Resources/CountHabit/CountHabitResource.php))

### Error Handling
- Form validation errors auto-handled by Inertia
- Use `toast` from `sonner` for success notifications
- Flash messages via `Inertia::flash()` on backend

## File Organization Rules

### Backend
- Actions: `app/Actions/{Domain}/{Action}.php`
- DTOs: `app/DTOs/{Domain}/{ActionDTO}.php`
- Requests: `app/Http/Requests/{Domain}/{ActionRequest}.php`
- Resources: `app/Http/Resources/{Domain}/{ModelResource}.php`
- Models: `app/Models/{SubDomain}/{Model}.php` for polymorphic types

### Frontend
- Pages: `resources/js/pages/{Feature}/{Page}.tsx`
- Components: `resources/js/components/{feature}/{component-name}.tsx`
- Shared UI: `resources/js/components/ui/{component}.tsx`

## Key Integrations

- **IDE Helper**: Run `composer ide-helper` after model changes to update PHPDoc
- **Route names**: Use named routes - Ziggy generates TypeScript definitions
- **Date handling**: Backend uses `CarbonImmutable`, frontend receives formatted strings

## Common Pitfalls

1. **Don't** create new migrations for polymorphic types - extend existing patterns
2. **Do** update TypeScript types when adding enum values
3. **Don't** use `Auth::user()` without null checks - prefer controller type-hinted `User $user`
4. **Do** preserve `declare(strict_types=1)` in all PHP files
5. **Don't** forget to run `npm run format` - it auto-organizes imports via Prettier
6. **Don't** add `$fillable` property to models because all Models are already unguarded
7. **Don't** use mass-assignment (`Model::create([...])`) instead always use properties and `save()` method
8. **Do** create feature tests for all new features before considering them complete
9. **Do** run `docker exec -it habitgram_app sh -c "php artisan model:show {Model}"` to inspect model structure and its columns in database
10. **Do** run `docker exec -it habitgram_app sh -c "composer refactor"` after completing the features, fixes.

## Testing Strategy
- **Always use the following command for running tests** `docker exec -it habitgram_app sh -c "php artisan test"`
- **Pest PHP**: Feature tests for critical user flows (auth, habit CRUD)
- **Unit tests**: Complex business logic in Actions
- **Feature Test Coverage**: After implementing new features, always create comprehensive feature tests that cover:
  - Valid input scenarios (happy path)
  - Invalid input scenarios (validation errors)
  - Edge cases (e.g., optional fields, boundary values)
  - Database state assertions (records created, relationships established)
  - Authorization checks if applicable
- No E2E tests yet - prioritize backend feature coverage

### Test File Organization
- Feature tests: `tests/Feature/{Domain}/{FeatureTest}.php`
- Follow naming convention: test descriptions should be readable sentences
- Use Pest's `test()` function with descriptive strings
- Example: `test('user cannot create a count habit without proper unit type', ...)`

When reviewing code, focus on:

## Security Critical Issues
- Check for hardcoded secrets, API keys, or credentials
- Look for SQL injection and XSS vulnerabilities
- Verify proper input validation and sanitization
- Review authentication and authorization logic

## Performance Red Flags
- Identify N+1 database query problems
- Spot inefficient loops and algorithmic issues
- Check for memory leaks and resource cleanup
- Review caching opportunities for expensive operations

## Code Quality Essentials
- Functions should be focused and appropriately sized
- Use clear, descriptive naming conventions
- Ensure proper error handling throughout

## Review Style
- Be specific and actionable in feedback
- Explain the "why" behind recommendations
- Acknowledge good patterns when you see them
- Ask clarifying questions when code intent is unclear

Always prioritize security vulnerabilities and performance issues that could impact users.

Always suggest changes to improve readability. For example, this suggestion seeks to make the code more readable and also makes the validation logic reusable and testable.
