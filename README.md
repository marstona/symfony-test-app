# Application

Symfony application for recruitment purposes.

[Task details](docs/TASK.md)

## Runing development application
```
cd .docker
docker compose -f docker-compose.dev.yml --env-file .env.dev up
```

Visit web app: http://localhost/
```
username: admin@example.com
password: 11!!qqQQ
```

Mailbox: http://localhost:1080/

## Runing application tests
```
cd .docker
docker compose -f docker-compose.test.yml --env-file .env.test up -d
docker exec -it php.test /bin/sh
php vendor/bin/codecept run
```

## Tech Stack:
- PHP 8.2
- Symfony 6.2
- MySQL
- Nginx
- RabbitMQ
- MailCatcher
- Supervisor
- Docker

## Used approach:
- DDD
- CQRS
- Event Driven
- Clean / Hexagonal architecture

## Other Tools:
- Codeception
- PHPStan
- Psalm
- ECS (easy-coding-standard)
- PHP-CS-Fixer
- Deptrac


![coedcept.png](docs%2Fcoedcept.png)

![phpstan.png](docs%2Fphpstan.png)

![deptrac.png](docs%2Fdeptrac.png)

![ecs.png](docs%2Fecs.png)

![psalm.png](docs%2Fpsalm.png)



