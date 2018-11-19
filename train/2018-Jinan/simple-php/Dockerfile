# Origin image
FROM ubuntu:16.04

# Meta Information
MAINTAINER Wang Yihang "wangyihanger@gmail.com"

ENV DEBIAN_FRONTEND noninteractive

# update
RUN apt update

# Setup Server Environment
RUN apt install -y \
    openssh-server \
    apache2 \
    php \
    libapache2-mod-php \
    php-mysql \
    mysql-server

ENTRYPOINT /run.sh
