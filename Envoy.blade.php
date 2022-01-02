@servers(['prod' => ['ec2-user@3.109.54.172']])

@task('deploy', ['on' => 'prod'])
    cd /home/ec2-user/sites/label-generator.saiashirwad.com
    git pull origin main
    composer install
    php artisan migrate --force
@endtask