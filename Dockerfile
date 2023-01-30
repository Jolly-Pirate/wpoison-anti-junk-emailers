FROM php:7-apache

COPY .htaccess words.gz wpoison.php /var/www/html/

RUN \
  a2enmod rewrite && \
  mkdir --verbose --preserve members && \
  gunzip words.gz && \
  mv --verbose words members/ && \
  mv --verbose wpoison.php members/email.php
