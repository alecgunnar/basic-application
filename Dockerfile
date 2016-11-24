FROM ubuntu:16.04

RUN apt-get update
RUN apt-get install -y nginx
RUN apt-get install -y php
RUN apt-get install -y php-fpm
RUN apt-get install -y php-xdebug

RUN mkdir /www
WORKDIR /www

ADD ./dev/nginx.host /etc/nginx/sites-available/default
ADD ./dev/php-fpm.ini /etc/php/7.0/fpm/php.ini
ADD ./dev/run /usr/local/bin/run
