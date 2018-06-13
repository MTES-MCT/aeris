

# Local installation

 - clone this git repository
```
git clone https://github.com/MTES-MCT/aeris
```
 - add a `aeris.local` mapping to your /etc/hosts file
```
127.0.0.2 aeris.local  # will map http://aeris.local to http://127.0.0.2
```
 - install `docker` and `docker-compose`, then launch the containers:

```bash
$ docker-compose up
```

You are done, you can visit your Symfony application on the following URL: `http://aeris.local` (and access Kibana on `http://aeris.local:82`)

# Containers

In docker-compose.yml, you'll find the following containers:

* `database`: This is the PostgreSQL database container,
* `php`: This is the PHP-FPM container including the application volume mounted on,
* `nginx`: This is the Nginx webserver container in which php volumes are mounted too,
* `elk`: This is a ELK stack container which uses Logstash to collect logs, send them into Elasticsearch and visualize them with Kibana.

You can rebuild all Docker images by running:

```bash
$ docker-compose build
```

and you can watch the running containers using

```bash
$ docker-compose ps
```

# Logs

You can visualize Nginx & Symfony logs in Kibana by visiting `http://symfony.localhost:82`.

They are stored in the following directories on your host machine:

* `logs/nginx`
* `logs/symfony`

