#!/bin/sh

# CASO OCORRA ALGUM ERRO, O SCRIPT SERÁ INTERROMPIDO
set -e

cd /var/www/html

# VERIFICA SE O BANCO DE DADOS ESTÁ DISPONÍVEL
until php artisan db:show &>/dev/null; do
  sleep 1
done

# EXECUTA AS MIGRAÇÕES
php artisan migrate

exec apachectl -D FOREGROUND