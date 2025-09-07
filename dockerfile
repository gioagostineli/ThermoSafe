# Dockerfile (sem extensão)
FROM php:8.2-apache

# Instala e habilita as extensões de MySQL necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql

# (opcional) define timezone para logs consistentes
RUN echo "date.timezone=America/Sao_Paulo" > /usr/local/etc/php/conf.d/timezone.ini

# Copia o projeto para dentro da imagem (será sobreposto pelo volume, mas ajuda em builds limpos)
COPY . /var/www/html/

# Permissões para o Apache
RUN chown -R www-data:www-data /var/www/html
