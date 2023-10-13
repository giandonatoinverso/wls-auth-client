FROM php:latest

RUN apt-get update && apt-get install -y bash
RUN docker-php-ext-install opcache

WORKDIR /var/www/html

COPY ./src ./

RUN chmod 755 *;
EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80"]