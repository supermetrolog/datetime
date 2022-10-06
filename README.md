# Тестовый проект

## Установка 
  - `git clone`
  - `docker-compose up (в корне проекта)`
  - `docker-compose exec php php /app/console/index.php (в корне проекта)`
  
## Использование API

  - Получения локального времени в городе по переданному идентификатору города и метке времени по UTC+0.

        (GET) http://localhost:8000/?city_id=29936786-b63d-45b2-9bda-b1c6fc6e6bb3&utc_zero_time=1675633364
        
  - Обратное преобразование из локального времени и идентификатора города в метку времени по UTC+0.
  
        (GET) http://localhost:8000/utctime.php?city_id=29936786-b63d-45b2-9bda-b1c6fc6e6bb3&local_time=1675636964

## Использование CLI

  - Внешний запуск процесса обновления данных. (в корне проекта запускать команду)

        docker-compose exec php php /app/console/index.php 

## Затраченное время *(примерно)*

  - 4 часа на то чтобы разобраться с заданием и timezonedb api, и написать SDK для этой апишки
  - 2-3 часа на то чтобы написать бизнес логику
  - 2 часа для настройки docker-compose 
  - 2 часа разработка возможности сохранения данных в бд 
  - 1 час рефакторинг 
  
## Примечание

  Конечно код не идеален и его можно доработать. Например, сделать нормальный роутинг (на который я решил забить, чтобы сделать быстрее) или избавиться от дублирования кода.
  И времени на это ушло многовато т.к я давненько не писал проекты с нуля на чистом php). Еще я не писал тесты т.к ушло бы еще больше времени на изучение как минимум phpUnit. Тесты писал только на golang...
