@servers(['prod' => ['ubuntu@dashboard.saiashirwad.com']])

@task('deploy', ['on' => 'prod'])
    cd /www/wwwroot/inhouse/label-generator.saiashirwad.com/
    git reset --hard
    git pull origin main
    composer install
    php artisan down
    php artisan migrate --force
    php artisan queue:restart
    php artisan optimize
    php artisan up
@endtask
