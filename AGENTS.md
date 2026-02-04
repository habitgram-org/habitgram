# Agent Development Guide

## Tech Stack

**Backend:** Laravel 12 (PHP 8.4+) + Inertia.js + Spatie Laravel Data + Pest PHP
**Frontend:** React 19 + TypeScript + Tailwind CSS 4 + shadcn/ui + Vite 7

## Build, Lint & Test Commands

### Frontend (TypeScript/React)

```bash
npm run dev                 # Start Vite dev server
npm run build              # Production build
npm run build:ssr          # Build with SSR support
npm run lint               # ESLint with auto-fix
npm run format             # Prettier format (auto-organizes imports)
npm run format:check       # Check formatting without writing
npm run types              # TypeScript type checking (tsc --noEmit)
```

### Backend (PHP/Laravel)

```bash
composer dev               # Full dev environment (server + queue + logs + vite)
composer lint              # Laravel Pint (PSR-12 formatting)
composer refactor          # Rector + Pint (refactoring + formatting)
composer test:lint         # Pint check without writing
composer test:types        # PHPStan static analysis (level 6)
composer ide-helper        # Update IDE helper files after model changes

# Testing
vendor/bin/pest                          # Run all tests
vendor/bin/pest tests/Feature            # Run feature tests
vendor/bin/pest tests/Unit               # Run unit tests
vendor/bin/pest --filter=AuthenticationTest  # Run single test file
vendor/bin/pest --filter=test_login      # Run single test method
```

## Code Style Guidelines

### PHP (Backend)

#### File Organization

- Always include `declare(strict_types=1)` at the top of every PHP file
- Use final classes by default (enforced by Pint)
- Organize code: `app/Actions/{Domain}/`, `app/DTOs/{Domain}/`, `app/Http/Requests/{Domain}/`

#### Type Safety

- Enable strict types in all files
- Use typed properties (no implicit types)
- Type-hint all method parameters and return types
- Use DTOs (Spatie Laravel Data) for data transfer between layers

#### Naming Conventions

- Classes: PascalCase (e.g., `CreateCountHabitEntry`)
- Methods: camelCase (e.g., `getDTO()`)
- Variables: camelCase (e.g., `$habitEntry`)
- Constants: UPPER_SNAKE_CASE (e.g., `MAX_ATTEMPTS`)
- Database tables: snake_case plural (e.g., `count_habits`)
- Database columns: snake_case (e.g., `created_at`)

#### Imports

- Group imports: PHP built-ins, vendor packages, app namespaces
- Use explicit imports (no global namespace references except built-ins)
- Alphabetize imports within each group

#### Error Handling

- Use FormRequest validation for user input
- Wrap multi-step operations in `DB::transaction()`
- Throw domain-specific exceptions (not generic Exception)
- Use Laravel's Gate for authorization checks

### TypeScript/React (Frontend)

#### File Organization

- Components: `resources/js/components/{feature}/{component-name}.tsx`
- Pages: `resources/js/pages/{Feature}/{Page}.tsx`
- UI components: `resources/js/components/ui/{component}.tsx` (shadcn/ui)
- Types: `resources/js/types/index.d.ts`

#### Type Safety

- Use interfaces for object shapes (defined in `types/index.d.ts`)
- No `any` types - use `unknown` if type is truly unknown
- Type all component props explicitly
- Mirror backend enums exactly in TypeScript

#### Naming Conventions

- Components: PascalCase (e.g., `HabitHeader.tsx`)
- Files: kebab-case (e.g., `count-habit-details.tsx`)
- Variables/functions: camelCase (e.g., `habitData`)
- Constants: UPPER_SNAKE_CASE (e.g., `MAX_COUNT`)
- Type/Interface: PascalCase (e.g., `CountHabit`)

#### Imports

- Prettier auto-organizes imports via `prettier-plugin-organize-imports`
- Run `npm run format` to auto-sort imports
- Use path alias `@/*` for `resources/js/*`
- React imports are automatic (React 19 JSX runtime)

#### Formatting

- Prettier config: 4-space indentation, single quotes, semicolons, 80 char line width
- Use `cn()` utility from `@/lib/utils` for conditional className merging
- Tailwind: Use `cn()` with Tailwind classes (auto-sorted by prettier-plugin-tailwindcss)

#### Component Patterns

- Use shadcn/ui components from `@/components/ui/`
- Inertia forms: Use `<Form>` component with `route()` helper (Ziggy)
- State: Use Inertia props via `usePage<SharedData>().props`
- Notifications: Use `toast` from `sonner` for success/error messages
- No prop-types (disabled in ESLint) - use TypeScript instead

#### Error Handling

- Form validation errors auto-handled by Inertia
- Use toast notifications for user feedback
- Type guard functions for discriminated unions (habit types)

## Architecture Patterns

### Backend Request Flow

```
Route → Controller → Action → DTO → Database
  ↓         ↓           ↓
Gate    Request    Transaction
```

### Key Backend Conventions

1. **Actions**: Single-purpose business logic classes (e.g., `CreateCountHabitEntry`)
2. **DTOs**: Use Spatie Laravel Data for type-safe data transfer
3. **Requests**: Must define `getDTO()` method returning DTO instance
4. **Resources**: Transform models to frontend using Spatie Data Resources
5. **Authorization**: Use Laravel's Gate via controller dependency injection

### Polymorphic Habit Types

- Parent `Habit` model with `habitable_type` and `habitable_id`
- Concrete types: `CountHabit`, `AbstinenceHabit`, `DailyHabit`
- Each type has its own entries table and business logic
- Frontend uses discriminated union types

### Frontend Data Flow

```
Models → Resources → Inertia Props → React Components
```

## Common Pitfalls & Best Practices

### DO ✅

- Run `npm run format` before committing (auto-organizes imports)
- Use `DB::transaction()` for multi-step database operations
- Type-hint controller parameters (`User $user` instead of `Auth::user()`)
- Update TypeScript types when adding backend enum values
- Run `composer ide-helper` after model changes
- Use named routes (Ziggy generates TypeScript definitions)
- Use `cn()` for conditional Tailwind classes
- Preserve `declare(strict_types=1)` in all PHP files

### DON'T ❌

- Don't create new migrations for polymorphic types - extend existing patterns
- Don't use `Auth::user()` without null checks
- Don't use generic `Exception` - throw domain-specific exceptions
- Don't use `any` type in TypeScript
- Don't skip validation in FormRequests
- Don't forget to run formatters before committing

## Integration Notes

- **IDE Helper**: Generates PHPDoc for better IDE support
- **Ziggy**: Generates TypeScript route definitions from Laravel routes
- **Inertia**: Server-driven SPA (no separate REST API)
- **React Compiler**: Enabled via babel-plugin-react-compiler
- **Date Handling**: Backend uses `CarbonImmutable`, frontend receives formatted strings

## Testing Strategy

- **Pest PHP**: Feature tests for critical user flows (auth, habit CRUD)
- **Unit Tests**: Complex business logic in Actions
- **Type Checking**: TypeScript compiler + PHPStan for PHP
- **No E2E**: Prioritize backend feature coverage
- Use `RefreshDatabase` trait in tests
- Test authorization via Gates
- Test validation via FormRequests

## Copilot Rules Integration

This codebase includes comprehensive coding instructions at `.github/copilot-instructions.md` covering:

- Architecture patterns (polymorphic relationships, Action/DTO pattern)
- Backend conventions (Actions, DTOs, Requests, Resources, Enums)
- Frontend conventions (components, types, forms, state, styling)
- Development workflows (running locally, testing, database)
- Authorization patterns (Gate usage)
- Error handling strategies
- File organization rules
- Common pitfalls and security/performance considerations

**Always refer to `.github/copilot-instructions.md` for detailed architectural guidance.**

## Quick Reference

**Run single test:** `vendor/bin/pest --filter=test_name`
**Format all code:** `npm run format && composer lint`
**Type check all:** `npm run types && composer test:types`
**Dev environment:** `composer dev` (runs server + queue + logs + vite)
