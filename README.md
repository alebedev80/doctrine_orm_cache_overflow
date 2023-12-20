# Issue reproduction

https://github.com/doctrine/orm/issues/11112

## How to install

```bash
git clone git@github.com:alebedev80/doctrine_orm_cache_overflow.git
cd doctrine_orm_cache_overflow
docker-compose up
```

## How to run

```bash
docker exec -it doctrine_orm_cache_overflow-php-1 php src/test.php
```

