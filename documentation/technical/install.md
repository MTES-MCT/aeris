
# Installing Aeris

There are a lot of steps, but it's not that complicated: they should work right away. You need to :
 - Run the code inside containers
 - Fetch the PHP and JS dependencies
 - Build and deploy the CSS/JS files

## Running the code inside containers

 - clone this git repository
```
git clone https://github.com/MTES-MCT/aeris
```
 - add a `aeris.local` mapping to your /etc/hosts file
```
127.0.0.1 aeris.local  # will map http://aeris.local to http://127.0.0.1
```
 - install `docker` and `docker-compose`, then launch the containers with `docker-compose up`:

```bash
$ docker-compose up
Starting aeris_db_1 ... 
Starting aeris_db_1 ... done
Starting aeris_php_1 ... 
Starting aeris_php_1 ... done
Starting aeris_nginx_1 ... 
Starting aeris_nginx_1 ... done
Attaching to aeris_db_1, aeris_php_1, aeris_nginx_1
db_1     | LOG:  database system was shut down at 2018-06-14 08:02:07 UTC
db_1     | LOG:  MultiXact member wraparound protections are now enabled
db_1     | LOG:  database system is ready to accept connections
db_1     | LOG:  autovacuum launcher started

```

The first step is done : you can visit your Symfony application on the following URL: `http://aeris.local`.

But there may be some errors on the page since we don't have the dependencies, there is no JS/CSS and the database is empty !

## Understanding the containers

In docker-compose.yml, you'll find the following containers:

* `database`: This is the PostgreSQL database container,
* `php`: This is the PHP-FPM container including the application volume mounted on,
* `nginx`: This is the Nginx webserver container in which php volumes are mounted too,

You can rebuild all Docker images by running:

```bash
$ docker-compose build
```
and you can watch the running containers using

```bash
$ docker-compose ps
```

## Installing dependencies

Now, **from the `app` directory** we need to run `composer` and `npm`:

    $ composer install
    $ npm install

`composer` is PHP dependency manager, `npm` is JS' dependency manager. They will fetch the external libraries we need in order to run Aeris. The php library will be written in the app/vendor directory, and the js libraries will land in app/node_module.

At this point, the homepage should run without error, but without CSS styling.

## Building assets

Again, **from the `app` directory**, run `yarn`:

    $ yarn run encore dev

Yarn is the tool we use to build assets. Yarn will compile the javascript and CSS developpement files that you can find in app/assets and put them in the `app/public/` directory, so that they can be accessed from the web server.

At this point, the homepage should run without error, with CSS styling, but you can't get inside the database... since the database is empty.

## Importing the database

Ok, this time we need to run a command inside the php container. Find your php container using `docker ps`:

    $ docker ps
    CONTAINER ID        IMAGE               COMMAND                  CREATED             STATUS              PORTS                         NAMES
    0e53d067a08c        aeris_nginx         "nginx"                  17 hours ago        Up 12 minutes       0.0.0.0:80->80/tcp, 443/tcp   aeris_nginx_1
    ca190317e64d        aeris_php           "php-fpm7 -F"            17 hours ago        Up 12 minutes       0.0.0.0:9000->9000/tcp        aeris_php_1
    fd74a0aab7b7        postgres:9.6        "docker-entrypoint.s…"   40 hours ago        Up 12 minutes       0.0.0.0:5432->5432/tcp        aeris_db_1

Our php container, aeris_php, has an id which is ca190317e64d. We need to get inside the container using:

$ docker exec -it ca190317e64d /bin/sh

The prompt will change: you'll be inside the container, not on your local machine. For this prompt, you can execute the SQL migrations:

```
/var/www/symfony # bin/console doctrine:migrations:migrate --no-interaction
```

This will execute all the migrations inside app/src/Migrations: they create the tables, and set the appropriate indices.

When you run the migrations, one of them creates 2 default users:

 - incinerateur-demo / aeris
 - inspecteur-demo / aeris

You can try to login in with those users in the application. You are done !

## Creating users and incinerateurs

This is an optionnal step, if you need more users than what running the migrations did.

### Creating an inspecteur



### Creating an incinerateur owner
