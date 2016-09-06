# Add an unofficial repository with PHP7 and other stuff
sudo echo "deb http://packages.dotdeb.org jessie all" >> /etc/apt/sources.list

wget https://www.dotdeb.org/dotdeb.gpg
sudo apt-key add dotdeb.gpg

sudo apt-get update

# The string, "your_password" below should be replaced when setting up your own system
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password your_password'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password your_password'

sudo apt-get install -y mariadb-server
sudo apt-get install -y php7.0-common libapache2-mod-php7.0 php7.0-cli php7.0-mysql php-xml php7.0-mbstring php7.0-curl


sudo curl -sL https://deb.nodesource.com/setup_4.x | sudo bash -
sudo apt-get install -y nodejs

sudo npm install -g gulp

# CHANGE THIS LINE #
cd /var/www/html/snydern

npm install

curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
# CHANGE THIS LINE #
sudo cp /var/www/html/snydern/provisioners/apache2.conf /etc/apache2/apache2.conf
# CHANGE THIS LINE #
sudo cp /var/www/html/snydern/provisioners/snydern.conf /etc/apache2/sites-available/snydern.conf
# CHANGE THIS LINE #
sudo ln /etc/apache2/sites-available/snydern.conf /etc/apache2/sites-enabled/snydern.conf
# CHANGE THIS LINE #
sudo cp /var/www/html/snydern/provisioners/envvars /etc/apache2/envvars

composer install

sudo systemctl restart apache2.service
