FROM ubuntu:16.04

RUN apt-get update
RUN apt-get install -y nginx
RUN apt-get install -y php
RUN apt-get install -y php-fpm

RUN mkdir /www
WORKDIR /www

ADD ./dev/nginx.host /etc/nginx/sites-available/default
ADD ./dev/run /usr/local/bin/run
