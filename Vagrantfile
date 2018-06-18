@script = <<SCRIPT
APP_ENV="Development"
DOCUMENT_ROOT_ZEND="/var/www/html"
apt-get update
apt-get install -y language-pack-en-base
apt-get install -y software-properties-common
LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php
apt-get install -y python-software-properties
apt-get update
apt-get -f install
apt-get install -y apache2 --force-yes
apt-get install -y php7.2 --force-yes
apt-get install -y php7.2-fpm --force-yes
apt-get install -y php7.2-mysql --force-yes
apt-get install -y php7.2-xml --force-yes
apt-get install -y php7.2-mbstring --force-yes
apt-get install -y php7.2-zip --force-yes
apt-get install -y php7.2-apc --force-yes
apt-get install -y php7.2-apcu --force-yes
apt-get install -y php7.2-dba --force-yes
apt-get install -y php7.2-memcache --force-yes
apt-get install -y php7.2-memcached --force-yes
apt-get install -y php7.2-mongo --force-yes
apt-get install -y php7.2-redis --force-yes
apt-get install -y php7.2-wincache --force-yes
apt-get install -y php7.2-xcache --force-yes
apt-get install -y php7.2-gd --force-yes
apt-get install -y php7.2-xdebug --force-yes
apt-get install -y git --force-yes
apt-get install -y curl --force-yes
apt-get install -y vim --force-yes
apt-get install -y mysql-utilities --force-yes
apt-get install -y dos2unix --force-yes
apt-get install -y phpunit --force-yes

export DEBIAN_FRONTEND="noninteractive"
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password 123456'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password 123456'
sudo apt-get -y install mysql-server

echo "
<VirtualHost *:80>
    ServerName skeleton-zf.local
    DocumentRoot $DOCUMENT_ROOT_ZEND
    <Directory $DOCUMENT_ROOT_ZEND>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
" > /etc/apache2/sites-available/application-zf.conf

echo "
#
# The MySQL database server configuration file.
#
# You can copy this to one of:
# - "/etc/mysql/my.cnf" to set global options,
# - "~/.my.cnf" to set user-specific options.
#
# One can use all long options that the program supports.
# Run program with --help to get a list of available options and with
# --print-defaults to see which it would actually understand and use.
#
# For explanations see
# http://dev.mysql.com/doc/mysql/en/server-system-variables.html

# This will be passed to all mysql clients
# It has been reported that passwords should be enclosed with ticks/quotes
# escpecially if they contain "#" chars...
# Remember to edit /etc/mysql/debian.cnf when changing the socket location.
[client]
port		= 3306
socket		= /var/run/mysqld/mysqld.sock

# Here is entries for some specific programs
# The following values assume you have at least 32M ram

# This was formally known as [safe_mysqld]. Both versions are currently parsed.
[mysqld_safe]
socket		= /var/run/mysqld/mysqld.sock
nice		= 0

[mysqld]
#
# * Basic Settings
#
user		= mysql
pid-file	= /var/run/mysqld/mysqld.pid
socket		= /var/run/mysqld/mysqld.sock
port		= 3306
basedir		= /usr
datadir		= /var/lib/mysql
tmpdir		= /tmp
lc-messages-dir	= /usr/share/mysql
skip-external-locking
#
# Instead of skip-networking the default is now to listen only on
# localhost which is more compatible and is not less secure.
bind-address		= 0.0.0.0
#
# * Fine Tuning
#
key_buffer		= 16M
max_allowed_packet	= 16M
thread_stack		= 192K
thread_cache_size       = 8
# This replaces the startup script and checks MyISAM tables if needed
# the first time they are touched
myisam-recover         = BACKUP
#max_connections        = 100
#table_cache            = 64
#thread_concurrency     = 10
#
# * Query Cache Configuration
#
query_cache_limit	= 1M
query_cache_size        = 16M
#
# * Logging and Replication
#
# Both location gets rotated by the cronjob.
# Be aware that this log type is a performance killer.
# As of 5.1 you can enable the log at runtime!
#general_log_file        = /var/log/mysql/mysql.log
#general_log             = 1
#
# Error log - should be very few entries.
#
log_error = /var/log/mysql/error.log
#
# Here you can see queries with especially long duration
#log_slow_queries	= /var/log/mysql/mysql-slow.log
#long_query_time = 2
#log-queries-not-using-indexes
#
# The following can be used as easy to replay backup logs or for replication.
# note: if you are setting up a replication slave, see README.Debian about
#       other settings you may need to change.
#server-id		= 1
#log_bin			= /var/log/mysql/mysql-bin.log
expire_logs_days	= 10
max_binlog_size         = 100M
#binlog_do_db		= include_database_name
#binlog_ignore_db	= include_database_name
#
# * InnoDB
#
# InnoDB is enabled by default with a 10MB datafile in /var/lib/mysql/.
# Read the manual for more InnoDB related options. There are many!
#
# * Security Features
#
# Read the manual, too, if you want chroot!
# chroot = /var/lib/mysql/
#
# For generating SSL certificates I recommend the OpenSSL GUI "tinyca".
#
# ssl-ca=/etc/mysql/cacert.pem
# ssl-cert=/etc/mysql/server-cert.pem
# ssl-key=/etc/mysql/server-key.pem

[mysqldump]
quick
quote-names
max_allowed_packet	= 16M

[mysql]
#no-auto-rehash	# faster start of mysql but no tab completition

[isamchk]
key_buffer		= 16M

#
# * IMPORTANT: Additional settings that can override those from this file!
#   The files must end with '.cnf', otherwise they'll be ignored.
#
!includedir /etc/mysql/conf.d/
"> /etc/mysql/my.cnf

mysql -u root -p123 -e "GRANT ALL ON *.* to root@'%' IDENTIFIED BY '123'; FLUSH PRIVILEGES;"

service mysql restart

a2enmod rewrite
a2enmod headers
a2dismod php5
a2enmod php7.2
a2dissite 000-default
a2ensite application-zf
apt-get remove -y apache2
apt-get install -y apache2
service apache2 restart

cd /var/www/html
curl -Ss https://getcomposer.org/installer | php
php composer.phar install --no-progress
php composer.phar update
mysql -u root -p123 < /var/www/html/database/database-v1.0.0.sql
echo "** Acesse http://192.168.99.99/ em seu navegador. **"

php -d variables_order=EGPCS

SCRIPT

Vagrant.configure(2) do |config|
  config.vm.box = 'bento/ubuntu-14.04'
  config.vm.network "private_network", ip: "192.168.99.99"
  config.vm.synced_folder ".", "/var/www/html"
  config.vm.provision "shell", inline: @script

  config.vm.provider "virtualbox" do |v|
    v.memory = 1024
    v.cpus = 2
  end

end

