FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update -y && \
	apt-get upgrade -y && \
	apt-get install -y apache2 && \
	apt-get install tzdata -y

RUN apt-get install -y software-properties-common && \
	  add-apt-repository ppa:ondrej/php && \
    apt-get update -y

RUN apt-get install -y \
	php8.3 \
	php8.3-bcmath \
	php8.3-bz2 \
	php8.3-intl \
	php8.3-gd \
	php8.3-mbstring \
	php8.3-mysql \
	php8.3-zip \
	php8.3-fpm \
	php8.3-cli \
	php8.3-xml \
	php8.3-curl \
	php8.3-soap \
	libapache2-mod-php8.3

RUN a2enmod php8.3

WORKDIR /var/www/html

EXPOSE 80

CMD ["apachectl", "-D", "FOREGROUND"]