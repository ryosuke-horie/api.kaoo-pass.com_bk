FROM bref/php-82-fpm-dev:2
COPY --from=bref/extra-pgsql-php-83:1 /opt /opt
