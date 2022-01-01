@servers(['prod' => ['ec2-user@13.235.157.197']])

@task('deploy', ['on' => 'prod'])
    cd /www/wwwroot/label-generator.saiashirwad.com
    git pull origin main
    php artisan migrate --force
@endtask