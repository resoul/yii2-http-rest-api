# HTTP REST API Service

Yii2-based REST API service with queue support and modern architecture.

## Requirements

- PHP 8.2+
- MySQL 5.7+ / MariaDB 10.3+
- Composer 2.x

## Installation

```bash
# Install dependencies
composer install

# Copy environment config
cp app/etc/env.test.php app/etc/env.php

# Edit environment variables
nano app/etc/env.php

# Run migrations
php bin/middleware migrate

# Start queue worker
php bin/middleware queue/listen
```

## Configuration

Edit `app/etc/env.php`:

- Database credentials
- Mailer settings
- Cookie validation key (generate with `php -r "echo bin2hex(random_bytes(32));"`)
- Timezone and language

## API Endpoints

- `GET /` - Get API version
- `GET /health` - Health check

## Queue

Process jobs in background:

```bash
php bin/middleware queue/listen
```

## Development

Run local server:

```bash
php -S localhost:8080 -t public
```

## Project Structure

```
app/
  code/           - Application code
    Middleware/   - Framework and modules
  etc/            - Configuration files
bin/              - CLI scripts
public/           - Web root
runtime/          - Runtime files (logs, cache)
vendor/           - Composer dependencies
```