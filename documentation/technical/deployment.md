# Deployment

Deployment is achieved using [fabric](http://www.fabfile.org/):

_Fabric is a Python (2.5-2.7) library and command-line tool for streamlining the use of SSH for application deployment or systems administration tasks._

On ubuntu, it can be installed globally with `apt-get install fabric`

There is one task for deployments. It takes one parameter, the environment where we want to deploy.

```bash
$ fab deploy:staging
$ fab deploy:prod
```

The staging environment is password protected, and has debugging tools enabled.
The prod environment is, well, the production app.

# Deployment structure

Two environments, `staging` and `prod`, are hosted on the same machine for now.
The `staging` environment is for 

    /var/www
    ├── aeris-prod -> /home/deploy/prod/releases/deploy-1521128368
    └── aeris-staging -> /home/deploy/staging/releases/deploy-1521128490
    /home/deploy
    ├── prod
    │   └── same structure as staging 
    └── staging
        ├── releases 
        │   ├── deploy-1521128488
        │   └── deploy-1521128490
        │       ├── bin
        │       ├── composer.json
        │       ├── composer.lock
        │       ├── config
        │       ├── public
        │       ├── src
        │       ├── symfony.lock
        │       ├── templates
        │       ├── var
        │       └── vendor
        └── shared
            └── env

The idea is as follow:

 - /var/www/aeris-[env-name] is a symlink to a release, stored in /var/www/[env-name]/releases
 - each release has a timestamp, and contains the complete project
 - shared information (like environment variables), are stored in /var/www/[env]/shared. During deployment, they are copied in the release directory 

