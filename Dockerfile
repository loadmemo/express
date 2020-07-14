FROM webdevops/php-nginx:7.4-alpine

ENV KEY=""

WORKDIR /app
COPY . /app