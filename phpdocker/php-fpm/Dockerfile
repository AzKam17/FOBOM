FROM phpdockerio/php:7.4-fpm
WORKDIR "/application"

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        git \ 
        php7.4-bcmath \ 
        php7.4-bz2 \ 
        php7.4-gd \ 
        php7.4-intl \ 
        php7.4-mcrypt \ 
        php7.4-mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
