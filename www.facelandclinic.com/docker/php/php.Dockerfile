FROM php:8.0.27-fpm
ARG SSH_PRIVATE_KEY
WORKDIR /var/www/html/www.facelandclinic.com

COPY --from=composer:1.10.10 /usr/bin/composer /usr/local/bin/composer
RUN apt-get update \
  && apt-get install -y \
    git \
    iputils-ping \
    libmagickwand-dev \
    libmemcached-dev \
    libmcrypt-dev \
    libxslt1-dev \
    libtidy-dev \
    libxml2-dev \
    libbz2-dev \
    libicu-dev \
    libpng-dev \
    libzip-dev \
    npm \
    unzip \
    vim \
    watch \
    zlib1g-dev \
  && docker-php-ext-install \
    pdo_mysql \
    calendar \
    gettext \
    sockets \
    sysvmsg \
    sysvsem \
    sysvshm \
    bcmath \
    mysqli \
    pcntl \
    shmop \
    exif \
    intl \
    soap \
    tidy \
    bz2 \
    xsl \
    zip \
    gd \
  && pecl install \
    memcached \
    igbinary \
    imagick \
    msgpack \
    mcrypt \
  && docker-php-ext-enable \
    memcached \
    igbinary \
    imagick \
    msgpack \
    mcrypt

RUN curl -LO https://deployer.org/deployer.phar &&\
    mv deployer.phar /usr/local/bin/dep &&\
    chmod +x /usr/local/bin/dep

RUN set -x
RUN mkdir /root/.ssh/ &&\
    echo "${SSH_PRIVATE_KEY}" > /root/.ssh/id_rsa &&\
    chmod 600 /root/.ssh/id_rsa &&\
    ssh-keyscan -t rsa,dsa bitbucket.org >> /root/.ssh/known_hosts

RUN ssh-keyscan -t rsa,dsa bitbucket.org >> /root/.ssh/known_hosts

#COPY ./* ./
#RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-scripts --no-autoloader &&\
#    composer dump-autoload --optimize

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar &&\
    chmod +x wp-cli.phar &&\
    mv wp-cli.phar /usr/local/bin/wp

RUN npm install -g gulp