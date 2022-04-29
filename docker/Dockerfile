FROM php:8.1-cli

RUN \
    apt-get update; \
    apt-get install -y --fix-missing \
        apt-utils \
        bash-completion \
        g++ \
        gcc \
        git \
        gnupg \
        make \
        nano \
        unzip \
    ; \
    echo "deb http://packages.dotdeb.org jessie all" >> /etc/apt/sources.list; \
    echo "deb-src http://packages.dotdeb.org jessie all" >> /etc/apt/sources.list; \
    curl -sS --insecure https://www.dotdeb.org/dotdeb.gpg | apt-key add -; \
    apt-get update; \
    apt-get install -y \
        libonig-dev \
        libxml2-dev \
        libxslt-dev \
        libzip-dev \
        zlib1g-dev \
    ; \
    docker-php-ext-configure \
        intl \
    ; \
    docker-php-ext-install \
        bcmath \
        dom \
        exif \
        intl \
        json \
        mbstring \
        xml \
        xsl \
        zip \
    ; \
    apt-get autoremove -y; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/*; \
    truncate -s 0 /var/log/*log;

# Install composer
RUN \
    curl -slL https://getcomposer.org/composer-2.phar -o /usr/local/bin/composer; \
    chmod +x /usr/local/bin/composer;

# Create user
ARG UID
RUN \
    useradd -ms /bin/bash --uid ${UID} docker; \
    usermod -a -G www-data docker; \
    curl -sl https://gist.githubusercontent.com/babeuloula/3911e3192bdade918c26a43885f31a0a/raw/d37620f6e28606a0db0642687b57afc3acb45f48/.bashrc -o /home/docker/.bashrc; \
    chown -R docker:docker /home/docker; \
    chown -R docker /var/www/html;
USER docker

# Setting up user
RUN \
    echo "set linenumbers" > /home/docker/.nanorc

WORKDIR /var/www/html
