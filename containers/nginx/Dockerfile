FROM alpine:3.6

MAINTAINER Clement Camin <clement@keiruaprod.fr>

RUN apk add --update nginx
RUN rm -rf /var/cache/apk/* && rm -rf /tmp/*

RUN rm /etc/nginx/conf.d/default.conf
ADD nginx.conf /etc/nginx/
ADD symfony.conf /etc/nginx/conf.d/

RUN echo "upstream php-upstream { server php:9001; }" > /etc/nginx/conf.d/upstream.conf

RUN adduser -D -g '' -G www-data www-data

CMD ["nginx"]

EXPOSE 80
EXPOSE 443
