#!/usr/bin/env bash

echo Fala memo - Vou instalar a vm para desenvolvimento SGT
sleep 2

#instalacoes gerais
sudo apt-get install unzip -y
sudo apt-get install build-essential -y

# senhas e pastas
PASSWORD='root'
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
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password ${PASSWORD}"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password ${PASSWORD}"
sudo apt-get -y install mysql-server
sudo apt-get -y install php5-mysql

# instalar phpmyadmin  e setar senha
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/dbconfig-install boolean true"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/app-password-confirm password ${PASSWORD}"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/admin-pass password ${PASSWORD}"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/app-pass password ${PASSWORD}"
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
sudo add-apt-repository ppa:webupd8team/sublime-text-3 -y 
sudo apt-get update
sudo apt-get install sublime-text-installer -y

# update / upgrade
sudo apt-get update
sudo apt-get -y upgrade

# instalando java oracle
sudo add-apt-repository ppa:webupd8team/java -y
sudo update
echo oracle-java8-installer shared/accepted-oracle-license-v1-1 select true | sudo /usr/bin/debconf-set-selections
sudo apt-get install oracle-java8-installer -y -q
update-java-alternatives -s java-8-oracle
sudo java -version
sleep 2

#instalando netbeans
sudo add-apt-repository ppa:vajdics/netbeans-installer
sudo apt-get update
sudo apt-get install netbeans-installer -y

#baixando o projeto
sudo git clone https://github.com/rmark3z/sgt.git
cp -rf sgt/* /var/www/html/sgt

echo Vm instalada e rodando
echo Para acessar o phpmyadmin digite em seu navegador
echo http://192.168.33.22/phpmyadmin
echo a senha phpmyadmin toor
echo o projeto se encontra no diretorio /var/www/html/sgt
echo para executar o sistema digite em seu navegador http://192.168.33.22/index.php
echo para atualizar a vm rode o comando vagrant provision
echo agora bora trabalhar!!!




