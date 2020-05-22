FROM php:7.2-fpm

RUN docker-php-ext-install mysqli

RUN apt-get update && apt-get install -y \
    curl \
    vim \
    iputils-ping \
    iputils-tracepath \
    whois \
    net-tools \
    tcpdump \
    dnsutils \
    sudo