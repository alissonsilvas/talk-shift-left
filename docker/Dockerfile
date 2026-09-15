FROM php:8.5-cli-bookworm

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/tmp/composer

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip libonig-dev libxml2-dev \
    && docker-php-ext-install dom mbstring \
    && rm -rf /var/lib/apt/lists/*

# Composer is useful for installing PHPUnit (or any other dependency used by
# the examples), while the image remains suitable for plain PHP tests too.
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Source code and tests are mounted by docker compose so edits are available
# immediately without rebuilding the image.
CMD ["php", "-v"]
