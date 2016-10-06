# sgt
#Tutorial para configuração da Vm no Vagrant

#Instale em sua maquina local os seguintes softwares:
Oracle VirtualBox -  disponivel em https://www.virtualbox.org/wiki/Downloads
Vagrant - https://www.vagrantup.com/downloads.html
SSH no Windows: https://winscp.net/eng/download.php ou http://www.putty.org/
SSH no Linux:  sudo apt-get install openssh-server -y

Faça o download dos arquivos do branche vm e descompacte
Abra o promt de comando no windows ou terminal no linux e navegue ate a pasta que contem os arquivos da vm
execute o comando:
  vagrant up
Aguarde a instalacao da vm

Para acessar a vm no promt ou no terminal execute
ssh -X vagrant@192.168.33.22

A vm nao tem interface grafica somente linha de comando
Voce pode executar qualquer programa instalado nela via linha de comando
para executar o netbeans o comando é: netbeans &
para executar o sublime text o comando é subl &
para acessar o phpmyadmin em seu navegador da maquina fisica acesse 192.168.33.22/phpmyadmin


