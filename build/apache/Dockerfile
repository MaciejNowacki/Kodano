FROM ubuntu:latest

RUN apt-get -y update && \
    apt-get -y -q --no-install-recommends install \
    tzdata apache2 openssl ca-certificates && \
    apt-get -y clean \

RUN a2enmod rewrite
RUN a2enmod ssl
RUN a2enmod proxy_http
RUN a2enmod proxy_fcgi
RUN a2enmod headers

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

# Copy apache vhost file to proxy php requests to php-fpm container
COPY 000-default.conf /etc/apache2/sites-enabled/000-default.conf

# Expose apache.
EXPOSE 80

# By default start up apache in the foreground, override with /bin/bash for interative.
CMD /usr/sbin/apache2ctl -D FOREGROUND