from fabric.api import *
from fabric.contrib.files import exists
from fabric.contrib.project import *
from time import time
from sys import exit

env.hosts = [
    'ns388137.ip-176-31-252.eu'
]
env.user = 'root' # should be changed asap

def deploy(env_name):
    existing_environments = ['staging', 'prod']
    if env_name not in existing_environments:
        puts('%s is not a valid environment' % env_name)
        puts('Allowed environments: %s' % ', '.join(existing_environments))
        exit(1)

    deploy_timestamp="%(time).0f" % {'time':time()}

    deployment_directory='/home/deploy/%s/releases/release-%s' % (env_name, deploy_timestamp)
    
    upload_code(deployment_directory)
    enable_project(env_name, deployment_directory)

def upload_code(deployment_directory):
    if not exists(deployment_directory):
       puts('creating deployment directory')
       run('mkdir -p %s' % deployment_directory) 

    puts('Deploying project in %s' % deployment_directory)
    rsync_project(
        local_dir='./app/*',
        remote_dir=deployment_directory,
        default_opts='-azcrSh --stats',
        exclude=['.git', 'var', 'node_modules', 'vendor']
    )

def enable_project(env_name, deployment_directory):
    # Copy of the environment file
    run('cp /home/deploy/%s/shared/env %s/.env' % (env_name, deployment_directory)) 
    # warmup cache
    with cd(deployment_directory):
        run('composer install')
        run('composer dump-autoload --optimize')
        run('npm install')
        run('bin/console cache:clear --env=dev')
        run('bin/console cache:clear --env=prod')
        run('bin/console doctrine:migrations:migrate --no-interaction')
        run('bin/console cache:warmup --env=dev >> /dev/null')
        run('bin/console cache:warmup --env=prod >> /dev/null')

    # Create symlink
    run('ln -sfn %s /var/www/aeris-%s' % (deployment_directory, env_name))
    # Restart the necessary services
    run('service php7.0-fpm restart')
    run('service nginx restart')