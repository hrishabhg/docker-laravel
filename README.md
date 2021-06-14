# **Setup Instructions:**

git clone git@github.com:ashish7adlakha/docker-laravel.git 

cd docker-laravel

docker-compose up -d --build

sudo chown -R www-data:www-data src/storage/

docker-compose run --rm artisan migrate

