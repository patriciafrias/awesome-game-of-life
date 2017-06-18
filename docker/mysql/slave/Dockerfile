FROM mysql:5.7
MAINTAINER Patricia Frias <patriciafm4@gmail.com>

# Copy MySQL config to container
COPY mysql.cnf /etc/mysql/conf.d/mysql.cnf

# Copy entrypoint script to container
COPY entrypoint/init_slave.sh /docker-entrypoint-initdb.d/init_slave.sh

CMD ["mysqld"]
