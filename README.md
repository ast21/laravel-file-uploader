# Пакет для загрузки файлов laravel

Этот пакет содержит роут загрузки файлов POST `/upload` для laravel.

Нужно установить пакет в dev dependencies:
```json
{
    "require": {
        "aebitdev/laravel-file-uploader": "^1.0"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/aebitdev/laravel-file-uploader"
        }
    ],
}
```

Обновить composer:
```shell
composer update
```

Настроить Laravel sanctum
```shell
php artisan vendor:publish --tag="file-uploader"
php artisan migrate
```
