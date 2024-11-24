FROM php:8.3-apache

# パッケージリストを更新し必要なライブラリ・ツールをインストール
# 最後にPHP拡張機能をインストール
# docker-php-ext-installは、PHP公式Dockerイメージに含まれるスクリプト
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    vim \
  && apt-get clean \
  && docker-php-ext-install zip pdo_mysql mysqli 

RUN a2enmod rewrite
COPY ./apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Node.js 18をインストール
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
  && apt-get install -y nodejs

# PHPの設定ファイルをホストからイメージ内にコピー
COPY ./php/php.ini /usr/local/etc/php/

# Composerのインストール
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  && php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
  && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
  && php -r "unlink('composer-setup.php');"

# ユーザーを作成する
RUN useradd -m -u 1000 -g www-data ww-data

# ドキュメントルートを設定
WORKDIR /var/www/html

# www-data ユーザーに変更
USER www-data