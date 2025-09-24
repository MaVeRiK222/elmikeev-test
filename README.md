# Задача:
Необходимо стянуть все данные по описанным эндпоинтам и сохранить в БД.

Ссылка на репу, если что там понятнее написано:
https://github.com//cy322666/wb-api/blob/master/README.md

Тут коллекция-дока с примерами запросов на постман:
https://www.postman.com//cy322666/workspace/app-api-test/overview

Использовать Laravel, MySQL.
Код проекта выложить в git. БД развернуть на любом бесплатном хостинге, предоставить доступы к бд и названия таблиц.
Время на выполнение - 3 дня.

### Данные БД:

DB_HOST=141.8.193.236

DB_DATABASE=f1172683_laravel

DB_USERNAME=f1172683_laravel

DB_PASSWORD=ulTCllHt

### Названия таблиц:

- stocks
- sales
- incomes
- orders

### Роуты:
- /stocks
- /sales
- /incomes
- /orders

По переходам на роуты начинается передача данных в БД в соответствующие таблицы

### Запускаем контейнеры
    docker-compose up --build -d

### Запускаем воркера в Laravel
    docker-compose exec -d laravel-app php artisan queue:work
