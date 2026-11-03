#!/bin/sh
# Executado automaticamente pela imagem postgres apenas na primeira vez que o
# volume de dados é criado (docker-entrypoint-initdb.d). Cria um banco de
# dados separado para os testes automatizados, para que o PHPUnit nunca
# rode migrations/RefreshDatabase contra o banco de desenvolvimento.
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    SELECT 'CREATE DATABASE ${POSTGRES_DB}_testing OWNER ${POSTGRES_USER}'
    WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = '${POSTGRES_DB}_testing')\gexec
EOSQL
