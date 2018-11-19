# Origin image
FROM ubuntu:14.04

# Meta Information
MAINTAINER Wang Yihang "wangyihanger@gmail.com"

ENV DEBIAN_FRONTEND noninteractive

# update
RUN apt update

# Setup Server Environment
RUN apt install -y \
    openssh-server \
    apache2 \
    php5 \
    libapache2-mod-php5 \
    php5-mysql \
    mysql-server

ENTRYPOINT /run.sh
