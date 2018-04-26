from fabric.api import *
from fabric.contrib.files import exists
from fabric.contrib.project import *
from time import time
from sys import exit

env.hosts = [
    'ns388137.ip-176-31-252.eu'
]
env.user = 'root' # should be changed asap

def check_environment(env_name):
    existing_environments = ['staging', 'prod']
    if env_name not in existing_environments:
        puts('%s is not a valid environment' % env_name)
        puts('Allowed environments: %s' % ', '.join(existing_environments))
        exit(1)

def deploy(env_name):
    check_environment(env_name)
    
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
        run('npm install')
        run('composer install --optimize-autoloader')
        run('chmod a+w var/ -R')
        run('bin/console cache:clear --env=dev --no-debug')
        run('bin/console cache:clear --env=prod --no-debug')
        run('bin/console cache:warmup --env=dev --no-debug')
        run('bin/console cache:warmup --env=prod --no-debug')
        run('chmod a+w var/ -R')
        run('bin/console doctrine:migrations:migrate --no-interaction')

    # Create symlink
    run('ln -sfn %s /var/www/aeris-%s' % (deployment_directory, env_name))
    run('ln -sfn /var/www/upload-%s %s/public/declarations' % (env_name, deployment_directory))
    # Restart the necessary services
    run('service php7.0-fpm restart')
    run('service nginx restart')

def list_releases(env_name):
    check_environment(env_name)
    run('find /home/deploy/%s/releases -maxdepth 1 -printf "%%f\n"' % (env_name))

def set_release(env_name, release):
    # Create symlink
    deployment_directory='/home/deploy/%s/releases/%s' % (env_name, release)
 
    run('ln -sfn %s /var/www/aeris-%s' % (deployment_directory, env_name))
    # Restart the necessary services
    run('service php7.0-fpm restart')
    run('service nginx restart')