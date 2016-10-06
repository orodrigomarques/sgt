#!/usr/bin/env bash

# senhas e pastas
PASSWORD='12345'
PROJECTFOLDER='sgt'

# criando pasta do projeto
sudo mkdir "/var/www/html/${PROJECTFOLDER}"

# update / upgrade
sudo apt-get update
sudo apt-get -y upgrade

# instalar apache 2.5 and php 5.5
sudo apt-get install -y apache2
sudo apt-get install -y php5

# instalar mysql e setar senha
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password $PASSWORD"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $PASSWORD"
sudo apt-get -y install mysql-server
sudo apt-get install php5-mysql

# instalar phpmyadmin  e setar senha
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/dbconfig-install boolean true"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/app-password-confirm password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/admin-pass password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/app-pass password $PASSOWRD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2"
sudo apt-get -y install phpmyadmin

# configurando arquivos de host
VHOST=$(cat <<EOF
<VirtualHost *:80>
    DocumentRoot "/var/www/html/${PROJECTFOLDER}"
    <Directory "/var/www/html/${PROJECTFOLDER}">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF
)
echo "${VHOST}" > /etc/apache2/sites-available/000-default.conf

# habilitando mod_rewrite
sudo a2enmod rewrite

# restart apache
service apache2 restart

# instalando git
sudo apt-get -y install git

# instalando Composer
curl -s https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

#instalando sublimetext
sudo add-apt-repository ppa:webupd8team/sublime-text-3 -y && sudo apt-get update && sudo apt-get install sublime-text-installer -y

# instalando java oracle
sudo add-apt-repository ppa:webupd8team/java -y && sudo update && sudo apt-get install oracle-java8-installer -y

#instalando netbeans
wget http://download.netbeans.org/netbeans/8.2/final/bundles/netbeans-8.2-javase-linux.sh -O netbeans-linux.sh
chmod +x netbeans-linux.sh
./netbeans-linux.sh

#baixando o projeto
cd /var/www/html
git clone https://github.com/rmark3z/sgt.git




