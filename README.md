## Teacher Student Laravel Web Application

**Setup Instructions:**

1. Clone the repo
```sh
git clone git@github.com:ashish7adlakha/docker-laravel.git 
```

2. Setup docker, build and add ownership to `www-data`
```sh
cd docker-laravel
docker-compose up -d --build
sudo chown -R www-data:www-data src/storage/
```

3. Migrate
```sh
docker-compose run --rm artisan migrate
```

4. open [http://localhost:8000/](http://localhost:8000/) in your web browser
