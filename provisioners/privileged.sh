sudo apt-get update

# The string, "your_password" below should be replaced when setting up your own system
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password not_safe_password'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password not_safe_password'

sudo apt-get install -y php5-common libapache2-mod-php5 php5-cli mysql-server php5-mysql

sudo curl -sL https://deb.nodesource.com/setup_4.x | sudo bash -
sudo apt-get install -y nodejs

sudo npm install -g gulp

# CHANGE THIS LINE #
cd /var/www/html/test

npm install

curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
# CHANGE THIS LINE #
sudo cp /var/www/html/test/provisioners/apache2.conf /etc/apache2/apache2.conf
# CHANGE THIS LINE #
sudo cp /var/www/html/test/provisioners/test.conf /etc/apache2/sites-available/test.conf
# CHANGE THIS LINE #
sudo ln /etc/apache2/sites-available/test.conf /etc/apache2/sites-enabled/test.conf
# CHANGE THIS LINE #
sudo cp /var/www/html/test/provisioners/envvars /etc/apache2/envvars

sudo systemctl restart apache2.service
