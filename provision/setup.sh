# Install needed packages
add-apt-repository ppa:ondrej/php
apt-get update
apt-get install -y nginx nodejs npm php7.0-fpm php7.0 php7.0-zip php7.0-dom php7.0-xdebug

# Move the host file into place
cp -f /vagrant/provision/host.nginx /etc/nginx/sites-available/default

# Make the log directory

mkdir -p /vagrant/log
touch /vagrant/log/error.log
touch /vagrant/log/access.log

# Install Composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
mv composer.phar /usr/local/bin/composer

# Install composer dependencies
composer install

# Restart deamon services
service nginx restart
service php7.0-fpm restart
