# Tools

In order to run Aeris, you need to have installed:

 - [docker](https://docs.docker.com/install/)
 - [composer](https://getcomposer.org/)
 - [yarn](https://yarnpkg.com/en/)

What follows are some explainations regarding how we use these tools in Aeris, and what you can do with them.

## Docker containers

In docker-compose.yml, you'll find the following containers:

* `database`: This is the PostgreSQL database container,
* `php`: This is the PHP-FPM container including the application volume mounted on,
* `nginx`: This is the Nginx webserver container in which php volumes are mounted too,

You can rebuild all Docker images by running:

```bash
$ docker-compose build
```
And you can run the container using

```bash
$ docker-compose up
```

You can watch the running containers using

    $ docker ps
    CONTAINER ID        IMAGE               COMMAND                  CREATED             STATUS              PORTS                         NAMES
    0e53d067a08c        aeris_nginx         "nginx"                  17 hours ago        Up 12 minutes       0.0.0.0:80->80/tcp, 443/tcp   aeris_nginx_1
    ca190317e64d        aeris_php           "php-fpm7 -F"            17 hours ago        Up 12 minutes       0.0.0.0:9000->9000/tcp        aeris_php_1
    fd74a0aab7b7        postgres:9.6        "docker-entrypoint.s…"   40 hours ago        Up 12 minutes       0.0.0.0:5432->5432/tcp        aeris_db_1

Our php container, aeris_php, has an id which is ca190317e64d. 
You can get inside this container using:

    $ docker exec -it $(docker ps -aqf "name=aeris_php") /bin/sh


## PHP

We use PHP7 and [composer](getcomposer.org) for dependency management.

Some of the notable components include:

 - Symfony
 - FOSUserBundle for user login
 - VichUploader for file upload
 - Doctrine and Doctrine Migrations for database management

## JS

We use [Encore](http://symfony.com/doc/current/frontend.html) for dependency management and building JS/CSS. It requires node and yarn. See app/webpack.config.js

### Adding a dependency:

```bash
$ yarn add bulma-tooltip
```



```bash
$ yarn run encore
```

You can build the assets for dev and production with the following parameters:

```bash
$ yarn run encore dev --watch
$ yarn run encore production
```

## CSS

We use [etalab's template](https://github.com/etalab/template.data.gouv.fr) on the homepage and [Bulma](https://bulma.io/documentation/overview/start/) inside the application

## Python

[fabric](http://www.fabfile.org/) is used for [deployment](deployment.md), see the dedicated documentation.
