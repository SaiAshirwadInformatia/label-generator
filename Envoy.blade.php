@servers(['prod' => ['ec2-user@dashboard.saiashirwad.com']])

@task('deploy', ['on' => 'prod'])
    cd /home/ec2-user/sites/label-generator.saiashirwad.com
    git reset --hard
    git pull origin main
    composer install
    php artisan down
    php artisan migrate --force
    php artisan queue:restart
    php artisan optimize
    php artisan up
@endtask