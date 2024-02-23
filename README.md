# Payment Processor test task

## Installation

You can up Docker container:
```shell
docker-compose up -d
```
or do it directly

Open root of project via terminal and specify:
```shell
composer install
```
OR via Docker
```shell
docker exec checkout composer install
```

The minimum requirements is a PHP 8.1 if you run app without Docker

## Testing

```shell
composer run test
```
Via Docker:
```shell
 docker exec checkout composer run test
```

## Documentation
 1. [General](docs/general_info.md)
