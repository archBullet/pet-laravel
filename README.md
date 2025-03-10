В проекте используется
```
php v8.3
laravel v12 (см. /composer.json)
```

Запуск проекта
```
docker compose up -d --build
```
Запуск тестов
```
1. docker compose exec -it fpm bash
2. ./test.sh
```