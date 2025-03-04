# WB API Client

Laravel приложение для получения и хранения данных из API Wildberries. Приложение получает данные о продажах, заказах, остатках товаров и доходах через API Wildberries и сохраняет их в локальной базе данных.

## Требования

- PHP 8.2+
- Laravel 10+
- MySQL 5.7+
- Composer

## Установка

1. Клонировать репозиторий:
```bash
git clone <repository-url>
cd wb-api-client
```

2. Установить зависимости через composer:
```bash
composer install
```

3. Создать и настроить файл .env:
```bash
cp .env.example .env
```

## Настройки базы данных

Измените следующие настройки в файле `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wb_api_data
DB_USERNAME=root
DB_PASSWORD=
```

## Запуск миграций

```bash
php artisan migrate
```

## Настройка API ключа

Добавьте ключ API WB в файл `.env`:

```
WB_API_KEY=E6kUTYrYwZq2tN4QEtyzsbEBk3ie
```

## Использование

Для получения данных выполните команду:

```bash
php artisan wb:fetch-data
```

Параметры:
- `--days=N`: За сколько дней получать данные (по умолчанию: 7)

Пример:
```bash
php artisan wb:fetch-data --days=30
```

## Структура базы данных

### sales (Продажи)
- `id` - Автоинкрементный ID
- `sale_id` - ID продажи (уникальный)
- `g_number` - Номер товара
- `date` - Дата продажи
- `last_change_date` - Дата последнего изменения
- `supplier_article` - Артикул поставщика
- `tech_size` - Технический размер
- `barcode` - Штрихкод
- `total_price` - Общая цена
- `discount_percent` - Процент скидки
- `is_supply` - Поставка
- `is_realization` - Реализация
- `promo_code_discount` - Скидка по промокоду
- `warehouse_name` - Название склада
- `country_name` - Название страны
- `oblast_okrug_name` - Название области/округа
- `region_name` - Название региона
- `income_id` - ID дохода
- `sale_dt` - Время продажи
- `for_pay` - К оплате
- `finished_price` - Финальная цена
- `price_with_disc` - Цена со скидкой
- `is_storno` - Статус сторно
- `sticker` - Стикер
- `srid` - SR ID

### orders (Заказы)
- `id` - Автоинкрементный ID
- `odid` - ID заказа (уникальный)
- `date` - Дата заказа
- `last_change_date` - Дата последнего изменения
- `supplier_article` - Артикул поставщика
- `tech_size` - Технический размер
- `barcode` - Штрихкод
- `total_price` - Общая цена
- `discount_percent` - Процент скидки
- `warehouse_name` - Название склада
- `oblast` - Область
- `income_id` - ID дохода
- `nm_id` - NM ID
- `subject` - Предмет
- `category` - Категория
- `brand` - Бренд
- `is_cancel` - Отменен
- `cancel_dt` - Время отмены
- `sticker` - Стикер
- `srid` - SR ID

### stocks (Остатки товаров)
- `id` - Автоинкрементный ID
- `barcode` - Штрихкод
- `warehouse_name` - Название склада
- `supplier_article` - Артикул поставщика
- `tech_size` - Технический размер
- `quantity` - Количество
- `is_supply` - Поставка
- `is_realization` - Реализация
- `quantity_full` - Полное количество
- `in_way_to_client` - В пути к клиенту
- `in_way_from_client` - В пути от клиента
- `nm_id` - NM ID
- `subject` - Предмет
- `category` - Категория
- `brand` - Бренд
- `tech_size_temp` - Временный технический размер
- `price` - Цена
- `discount` - Скидка

### incomes (Доходы)
- `id` - Автоинкрементный ID
- `income_id` - ID дохода (уникальный)
- `number` - Номер
- `date` - Дата
- `last_change_date` - Дата последнего изменения
- `supplier_article` - Артикул поставщика
- `tech_size` - Технический размер
- `barcode` - Штрихкод
- `quantity` - Количество
- `total_price` - Общая цена
- `date_close` - Дата закрытия
- `warehouse_name` - Название склада
- `nm_id` - NM ID
- `status` - Статус
