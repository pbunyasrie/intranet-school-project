# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://vagrantcloud.com/search.
  config.vm.box = "debian/stretch64"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # NOTE: This will enable public access to the opened port
  config.vm.network "forwarded_port", guest: 80, host: 8080
  #config.vm.network "forwarded_port", guest: 9998, host: 8080

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine and only allow access
  # via 127.0.0.1 to disable public access
  # config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  # config.vm.network "private_network", ip: "192.168.33.10"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  config.vm.synced_folder ".", "/var/www/project",
    owner: "vagrant",
    group: "www-data",
  mount_options: ["dmode=775,fmode=664"]

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
  config.vm.provider "virtualbox" do |vb|
    # Display the VirtualBox GUI when booting the machine
    # vb.gui = true
  
    # Customize the amount of memory on the VM:
    vb.memory = "1024"
  end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.
  config.vm.provision "shell", inline: <<-SHELL
    # Common utilities
    apt-get update -y
    apt-get install mlocate ack curl vim htop net-tools vim psmisc git nfs-common apt-transport-https lsb-release ca-certificates cronolog zsh -y
    
    # PHP
    sh -c "$(curl -fsSL https://raw.githubusercontent.com/robbyrussell/oh-my-zsh/master/tools/install.sh)"
    wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
    apt-get update
    apt-get install php7.2 php7.2-fpm php7.2-mbstring php7.2-gmp php7.2-dom php7.2-mysql php7.2-gd php7.2-xml php7.2-zip php7.2-curl -y

    echo "listen = 127.0.0.1:9000" >> /etc/php/7.2/fpm/pool.d/www.conf

    # Install Composer
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
    mv composer.phar /usr/bin/composer

    # Apache
    apt-get install apache2 -y
    a2enmod http2
    apachectl restart
    apachectl stop
    a2enmod proxy_fcgi setenvif
    a2enconf php7.2-fpm # Again, this depends on your PHP vendor.
    a2dismod php7.2 # This disables mod_php.
    a2dismod mpm_prefork # This disables the prefork MPM. Only one MPM can run at a time.
    a2enmod mpm_event # Enable event MPM. You could also enable mpm_worker.
    a2dissite 000-default
    a2enmod rewrite

cat << EOF >> /etc/apache2/apache2.conf
<FilesMatch "\.php$">
	SetHandler "proxy:fcgi://127.0.0.1:9000/"
</FilesMatch>
EOF
    rm -rf /var/www/html
    ln -s /var/www/project/public /var/www/html

cat << EOF > /etc/apache2/sites-enabled/project.conf
<VirtualHost _default_:*>
        ServerName project.dev
        ServerAdmin webmaster@project.dev
        DocumentRoot "/var/www/html"
        DirectoryIndex index.php

        <Directory "/var/www/html">
            Options Indexes MultiViews FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>

</VirtualHost>
EOF

    sed -i '/upload_max_filesize/s/= *2M/=20M/' /etc/php/7.2/fpm/php.ini
    sed -i '/post_max_size/s/= *8M/=20M/' /etc/php/7.2/fpm/php.ini

    # Setup the project
    cd /var/www/project
    composer install

    # MySQL
    apt-get install mariadb-server -y

mysql_secure_installation <<EOF

y
secret
secret
y
y
y
y
EOF

echo "bind-address = stretch" >> /etc/mysql/mariadb.conf.d/50-server.cnf

    # Create the database
    php artisan config:clear
    mysql -u root --password="secret" -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost'     IDENTIFIED BY 'secret'       WITH GRANT OPTION; FLUSH PRIVILEGES; drop database project; create database project COLLATE 'utf8_unicode_ci'"
    php artisan migrate:fresh --seed

    # Install Apache Tika
    TIKA_VERSION="1.16"
    TIKA_SERVER_URL="https://www.apache.org/dist/tika/tika-server-$TIKA_VERSION.jar"
	apt-get update \
	&& apt-get install openjdk-8-jre-headless curl gdal-bin tesseract-ocr \
		tesseract-ocr-eng tesseract-ocr-ita tesseract-ocr-fra tesseract-ocr-spa tesseract-ocr-deu -y \
	&& curl -sSL https://people.apache.org/keys/group/tika.asc -o /tmp/tika.asc \
	&& gpg --import /tmp/tika.asc \
	&& curl -sSL "$TIKA_SERVER_URL.asc" -o /tmp/tika-server-${TIKA_VERSION}.jar.asc \
	&& NEAREST_TIKA_SERVER_URL=$(curl -sSL http://www.apache.org/dyn/closer.cgi/${TIKA_SERVER_URL#https://www.apache.org/dist/}\?asjson\=1 \
		| awk '/"path_info": / { pi=$2; }; /"preferred":/ { pref=$2; }; END { print pref " " pi; };' \
		| sed -r -e 's/^"//; s/",$//; s/" "//') \
	&& echo "Nearest mirror: $NEAREST_TIKA_SERVER_URL" \
	&& curl -sSL "$NEAREST_TIKA_SERVER_URL" -o /usr/share/java/tika-server.jar \
	&& apt-get clean -y && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


cat << EOF >> /etc/init.d/tika
#!/bin/sh
### BEGIN INIT INFO
# Provides: tika
# Required-Start: $remote_fs $syslog
# Required-Stop: $remote_fs $syslog
# Default-Start: 2 3 4 5
# Default-Stop: 0 1 6
# Short-Description: Tika Server
# Description: Apache Tika Server for extraction of metadata and text.
### END INIT INFO

start () {
    echo -n "Starting Tika server daemon..."

    daemon --respawn --user=tika --name=tika --verbose --command="java -jar /usr/share/java/tika-server.jar"
    RETVAL=$?
    if [ $RETVAL = 0 ]
    then
        echo "done."
    else
        echo "failed. See error code for more information."
    fi
    return $RETVAL
}

stop () {
    # Stop daemon
    echo -n "Stopping Tika server daemon..."

    daemon --stop --name=tika --verbose
    RETVAL=$?

    if [ $RETVAL = 0 ]
    then
        echo "Done."
    else
        echo "Failed. See error code for more information."
    fi
    return $RETVAL
}

restart () {
    daemon --restart --name=tika --verbose
}

status () {
    # Report on the status of the daemon
    daemon --running --verbose --name=tika
    return $?
}

case "$1" in
    start)
        start
    ;;
    status)
        status
    ;;
    stop)
        stop
    ;;
    restart)
        restart
    ;;
    *)
        echo $"Usage: tika {start|status|stop|restart}"
        exit 3
    ;;
esac

exit $RETVAL
EOF
    #cd /root
    #git clone https://github.com/opensemanticsearch/tika-server.deb
    #cd tika-server.deb/build
    #bash build
    #dpkg -i tika-server*.deb
    #apt-get install openjdk-8-jre-headless -y
    #apt --fix-broken install -y
    #cp /root/tika-server.deb/etc/init.d/tika /etc/init.d/tika
    chmod 755 /etc/init.d/tika

    # Install Elasticsearch
    # reference: https://www.elastic.co/guide/en/elasticsearch/reference/current/deb.html
    wget -qO - https://artifacts.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -
    echo "deb https://artifacts.elastic.co/packages/5.x/apt stable main" | sudo tee -a /etc/apt/sources.list.d/elastic-5.x.list
    apt-get update && apt-get install elasticsearch

    sed -i 's/Xms2g/Xms512m/g' /etc/elasticsearch/jvm.options
    sed -i 's/Xmx2g/Xmx512m/g' /etc/elasticsearch/jvm.options


    # Restart services
    systemctl restart php7.2-fpm 
    systemctl restart apache2
    service tika start
    systemctl status elasticsearch
    systemctl enable php7.2-fpm
    systemctl enable apache2
    systemctl enable mariadb
    systemctl enable tika
    systemctl enable elasticsearch

    # Create the elasticsearch indices for our app
    php artisan elastic:create-index "\App\FileIndexConfigurator"
    php artisan elastic:update-mapping App\\File

  SHELL
end
