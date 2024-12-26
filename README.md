# Laravel Project API

Цей проект — це RESTful API для керування проектами та завданнями.

---

## 1. Встановлення проекту

### 1.1. Скачайте проект
Клонуйте проект із репозиторію:
```bash
git clone https://github.com/poslovskij/test_api.git
cd test_api
```
### 1.2. Налаштуйте середовище
Скопіюйте .env.example у .env:
```bash
cp .env.example .env
```
**Налаштуйте змінні у .env.** <br>
Для Docker ваш .env має виглядати так:
```bash
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=test_api
DB_USERNAME=root
DB_PASSWORD=root

DOCKER_WEB_PORT=8089
ADMINER_PORT=8099

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
```
### 1.3. Запустіть Docker
Переконайтеся, що Docker встановлений і працює.<br>
**Запустіть контейнери:**
```bash
docker-compose up -d
```
**Виконайте команди для підготовки Laravel:**

- Зайдіть у контейнер PHP:
```bash
docker-compose exec php bash
```
- Встановіть залежності Composer:
```bash
composer install
```
- Згенеруйте APP_KEY:
```bash
php artisan key:generate
```
- Запустіть міграції:
```bash
php artisan migrate
```
---
## 2. Основні запити API
Всі запити виконуються до базового URL:
```bash
http://localhost:8089/api
```
### 2.1. Авторизація
*__Реєстрація:__*
- Метод: `POST`
- URL: `/register`
- Тіло запиту:
```json
{
    "name": "Joshua",
    "email": "test@gmail.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```
- Очікувана відповідь:
```json
{
    "message": "User registered successfully",
    "token": "your-generated-token",
    "user": {
        "id": 1,
        "name": "Joshua",
        "email": "test@gmail.com"
    }
}
```
*__Вхід:__*
- Метод: `POST`
- URL: `/login`
- Тіло запиту:
```json
{
    "email": "test@gmail.com",
    "password": "password123"
}
```
- Очікувана відповідь:
```json
{
    "message": "Login successful",
    "token": "your-generated-token",
    "user": {
        "id": 1,
        "name": "Joshua",
        "email": "test@gmail.com"
    }
}
```
*__Вихід:__*
- Метод: `POST`
- URL: `/logout`
- Заголовок: `Authorization: Bearer {your-token}`
- Очікувана відповідь:
```json
{
    "message": "Logged out successfully"
}
```
---
### 2.2. Робота з проектами
*__Створення проекту:__*
- Метод: `POST`
- URL: `/projects`
- Заголовок: `Authorization: Bearer {your-token}`
- Тіло запиту:
```json
{
    "name": "My Project", 
    "description": "This is my project"
}
```
- Очікувана відповідь:
```json
{
    "id": 1,
    "name": "My Project",
    "description": "This is my project",
    "created_at": "2024-12-26T10:00:00.000000Z",
    "updated_at": "2024-12-26T10:00:00.000000Z"
}
```
*__Список проектів:__*
- Метод: `GET`
- URL: `/projects`
- Заголовок: `Authorization: Bearer {your-token}`

*__Отримання проекту за ID:__*
- Метод: `GET`
- URL: `/projects/{project_id}`
- Заголовок: `Authorization: Bearer {your-token}`

*__Оновлення проекту:__*
- Метод: `PUT`
- URL: `/projects/{project_id}`
- Заголовок: `Authorization: Bearer {your-token}`
- Тіло запиту:
```json
{
    "name": "Updated Project",
    "description": "Updated description"
}
```

*__Видалення проекту:__*
- Метод: `DELETE`
- URL: `/projects/{project_id}`
- Заголовок: `Authorization: Bearer {your-token}`
---
### 2.3. Робота з завданнями

*__Створення завдання:__*
- Метод: `POST`
- URL: `/projects/{project_id}/tasks`
- Заголовок: `Authorization: Bearer {your-token}`
- Тіло запиту:
```json
{
    "title": "My Task",
    "description": "This is a task"
}
```

*__Список завдань проекту:__*
- Метод: `GET`
- URL: `/projects/{project_id}`
- Заголовок: `Authorization: Bearer {your-token}`

*__Оновлення завдання:__*
- Метод: `PUT`
- URL: `/tasks/{task_id}`
- Заголовок: `Authorization: Bearer {your-token}`
- Тіло запиту:
```json
{
    "title": "Updated Task",
    "description": "Updated description",
    "is_completed": true
}
```

*__Видалення завдання:__*
- Метод: `DELETE`
- URL: `/tasks/{task_id}`
- Заголовок: `Authorization: Bearer {your-token}`

---

## 3. Завершення
1. Виконайте вище описані запити через Postman або інший інструмент.
2. У разі помилок перевірте логи:
```bash
docker-compose exec php tail -f storage/logs/laravel.log
```