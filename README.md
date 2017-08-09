# Silex in Docker containers #
----------------------------------
Репозиторий предназначен для запуска приложения в задачи которого входит создание коротких ссылок для редиректов по ним:

- принимает POST запрос в JSON формате на основной домен http://localhost:7771

        {"url": "https://google.ru"}

- возвращает ответ в JSON:

        {url: "http://$_ENV['HTTP_HOST']/ZdPwbK"}

Для проверки работы можно выполнить в консоле:

        $ curl http://localhost:7771 -d '{"url":"https://vk.com/mcsim"}' -H 'Content-Type: application/json'
        Ответ: {"url":"http:\/\/localhost:7771\/0dN6dL"}

Для врменного хранения ссылок используется Redis.

Для работы приложения необходимы:
- Docker
- docker-compose
- Git (Git-Bash для Windows пользователей)

Репозиторий представляет из себя набор конфигурационных файлов docker-compose для запуска приложения в различных окружениях [ dev | prod | test ]

### Возможности: ###

    Supported commands:
    ====================================================================================================
    set-env           - set application environment [dev | prod | test]
    check-env         - print message with current application environment name
    check-config      - check current environment configuration .yml file
    start                - start application environment
    ps                - list of working containers in current environment
    stop              - stop application environment
    restart           - restart application environment
    build             - build docker containers for application
    build-nocache     - force build docker containers for application without docker cached images
    create            - create application in ./app directory
    install           - composer install
    update            - composer update
    ===============================================================================================================
    Для определения в каком окружении должно работать приложение выполните: './silex set-env [ dev | prod | test ]'
    ===============================================================================================================
    
Для Быстрого старта выполните команду:
    
    ./init.dev.sh
    
Скрипт создает dev окружение, скачивает и запускает fabpot/silex-skeleton  на [http://localhost:7771](http://localhost:7771)

./init.dev.sh

    #!/usr/bin/env bash
    ./silex set-env dev
    ./silex start
    ./silex install

Для запуска необходимо выдать права файлу silex

        chmod +x silex

Затем:

        ./silex set-env dev
        ./silex start
        ./silex install

Если не создалась табличка в БД то можно вручную залить дамп через adminer по адресу [http://localhost:7772](http://localhost:7772)

Дамп Базы лежит тут https://github.com/maxim-avramenko/silex/blob/master/docker/source/mariadb/db_dump/db_yupe/db_silex.sql


Помощь
------
Документация
- [Docker](https://docs.docker.com/)
- [docker-compose](https://docs.docker.com/compose/overview/)
- [Git-bash for Windows users](https://git-for-windows.github.io/)
