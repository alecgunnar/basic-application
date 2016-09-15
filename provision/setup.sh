apt-get update
apt-get install -y nginx nodejs npm php-fpm php php-zip php-mysql

cat provision/host.nginx > /etc/nginx/sites-available/default

service nginx restart
service php7.0-fpm restart
