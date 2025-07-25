### News Aggregator Setup
Pre-requisites - docker and Xdebug for code coverage

1. Clone the repo and navigate into it.
2. Configure .env file, can refer to .env.example file 
3. Run `docker-compose up -d --build`

4. Visit the app at http://localhost:8000
5. To refer documentation go to http://localhost:8000/api/documentation

### Services
- Laravel App (PHP 8.3)
- MySQL 8 (localhost:3306)
- MongoDB (localhost:27017)
- Nginx Proxy (localhost:8000)
- Redis (localhost:6379)

### Artisan / Composer Access

```bash
docker exec -it laravel_app php artisan
docker exec -it laravel_app composer install
```

### Test Application
```bash
php artisan test --coverage
