sudo apt-get update

# The string, "your_password" below should be replaced when setting up your own system
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password not_safe_password'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password not_safe_password'

sudo apt-get install -y php5-common libapache2-mod-php5 php5-cli mysql-server

curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
sudo cp /var/www/html/snydern/provisioners/apache2.conf /etc/apache2/apache2.conf
sudo cp /var/www/html/snydern/provisioners/snydern.conf /etc/apache2/sites-available/snydern.conf
sudo ln /etc/apache2/sites-available/snydern.conf /etc/apache2/sites-enabled/snydern.conf
sudo cp /var/www/html/snydern/provisioners/envvars /etc/apache2/envvars

sudo systemctl restart apache2.service
