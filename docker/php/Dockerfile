FROM php:8.1-apache
WORKDIR /var/www/html
RUN chmod -R 777 ./
RUN docker-php-ext-install pdo mysqli pdo_mysql
RUN a2enmod rewrite
RUN service apache2 restart
EXPOSE 80