FROM php:8.2.0alpha3-apache
COPY /src /var/www/html/
EXPOSE 9000
RUN echo 'ServerName currency-converter' >> /etc/apache2/apache2.conf
RUN apt-get update && apt-get install -y libxml2-dev
RUN docker-php-ext-install soap