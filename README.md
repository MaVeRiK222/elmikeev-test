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

DB_CONNECTION=pgsql

DB_HOST=aws-1-eu-west-1.pooler.supabase.com

DB_PORT=6543

DB_DATABASE=postgres

DB_USERNAME=postgres.qzigtvfojouvhzplkhqc

DB_PASSWORD=xG6RHpiQXBmZrsy!

Для локального MySQL все данные сохраняются без потерь, из бесплатных сервисов
хорошо работает только Supabase на PostgreSQL.

Большой разницы работы с MySQL и PostgreSQL в рамках этого тестового нет.

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

### Скачиваем зависимости
    composer install

### Генерим ключ
    php artisan key:generate

### Запускаем контейнеры
    docker-compose up --build -d

### Запускаем воркера в Laravel
    php artisan queue:work
