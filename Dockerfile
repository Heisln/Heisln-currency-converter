FROM php:8.0.3-apache
RUN echo 'ServerName currency-converter' >> /etc/apache2/apache2.conf