FROM debian:stretch
MAINTAINER Forestier Florian <Florian.Forestier@etu.uca.fr>



RUN apt-get update && apt-get install -y apache2 php7.0 php7.0-mysql php7.0-curl php7.0-gd php7.0-fpm php7.0-json git libapache2-mod-php7.0
RUN a2enmod rewrite && a2enmod expires
RUN cd /var/ && rm -r www/
RUN mkdir /var/www

ENV APACHE_CONFDIR /etc/apache2
ENV APACHE_ENVVARS $APACHE_CONFDIR/envvars
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_PID_FILE $APACHE_RUN_DIR/apache2.pid
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_LOG_DIR /var/log/apache2
ENV LANG C

RUN mkdir -p $APACHE_RUN_DIR $APACHE_LOCK_DIR $APACHE_LOG_DIR

RUN cd /etc/apache2/sites-available/ && rm *
RUN cd /etc/apache2/sites-enabled/ && rm *
COPY default.conf /etc/apache2/sites-available/default.conf
RUN a2ensite default.conf


COPY upload.php /var/www/upload.php
RUN mkdir /var/www/images
RUN mkdir /var/www/files
RUN touch /var/www/images/index.php
RUN touch /var/www/files/index.php
RUN touch /var/www/index.php



RUN chown -R www-data:www-data /var/www
RUN chmod -R 666 /var/www/files && chmod -R 666 /var/www/images



EXPOSE 80
CMD ["apache2", "-DFOREGROUND"]
