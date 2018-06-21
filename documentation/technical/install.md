# Installation

In order to run Aeris, you need to have installed:

 - [docker](https://docs.docker.com/install/)
 - [composer](https://getcomposer.org/)
 - [yarn](https://yarnpkg.com/en/)

Then, you can proceed to the next steps:

## Clone this git repository

```
git clone git@github.com:MTES-MCT/aeris.git
```

## Add a local DNS entry

You need to add a `aeris.local` mapping to your /etc/hosts file:

```
127.0.0.1 aeris.local  # will map http://aeris.local to http://127.0.0.1
```

## Install dependencies

**From the `app` directory** we need to run `composer` and `yarn`:

    $ cd app
    $ composer install
    $ yarn install

`composer` is PHP dependency manager, `yarn` is a JS dependency manager. They will fetch the external libraries we need in order to run Aeris. The php library will be written in the app/vendor directory, and the js libraries will land in app/node_modules.

## Building assets

Still **from the `app` directory**, **run `yarn`** again:

    $ yarn run encore dev

Yarn is also the tool we use to build assets. Yarn will compile the javascript and CSS developpement files that you can find in app/assets and put them in the `app/public/` directory, so that they can be accessed from the web server.

At this point, the homepage should run without error, with CSS styling, but you can't get inside the database... since the database is empty.

## Launching the containers

**Launch the containers** with `docker-compose up`. For more details regarding the containers, have a look at [the containers documentation](./containers.md)

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

## Importing the database

Ok, this time we need to run a command inside the php container. 

    $ docker exec -it $(docker ps -aqf "name=aeris_php") /bin/sh

The prompt will change: you'll be inside the container, not on your local machine. For this prompt, you can execute the SQL migrations:

```
/var/www/symfony # bin/console doctrine:migrations:migrate --no-interaction
```

This will execute all the migrations inside app/src/Migrations: they create the tables, and set the appropriate indices.

When you run the migrations, one of them creates 2 default users:

 - inspecteur-demo / aeris
 - incinerateur-demo / aeris

(if you need more users, have a look inside the [users documentation](./creating-users.md))

You can now try to login in with those users in the application. Good job, you are done !
