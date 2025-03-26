## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

`APP_SECRET`

`DATABASE_URL`

`MAILER_DSN`


## Installation

Install project

```bash
  cd build
  docker-compose up -d
  docker exec -it php bash
  cd ../project
  composer install
  php bin/console doctrine:migrations:execute --force
  php bin/console doctrine:fixtures:load
```


## Running Tests

To run tests, run the following command

```bash
  php vendor/bin/phpunit tests
  php vendor/bin/phpstan analyse src tests
```


## API Reference

### Create product

```http
  POST /products
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | **Required**. name |
| `price` | `float` | **Required**. price |
| `categoryIds` | `array` | **Required**. category IDs |

#### Example request
```json
{
  "name": "test1",
  "price": 123.99,
  "categoryIds": [
    8
  ]
}
```

#### Example response (200)
```json
{
  "id": 15,
  "name": "test1",
  "price": 123.99,
  "categories": [
    {
      "id": 8,
      "code": "HndTools"
    }
  ]
}
```

#### Example response (400)
```json
{
  "message": "VALIDATION_ERROR",
  "code": 0,
  "details": {
    "price": "This value should be positive."
  }
}
```

***

### Assign product to categories

```http
  PATCH /products/{productId}/categories
```

| Parameter     | Type    | Description                |
|:--------------|:--------|:---------------------------|
| `productId`   | `query` | **Required**. product ID   |
| `categoryIds` | `array` | **Required**. category IDs |

#### Example request
```json
{
  "categoryIds": [
    7
  ]
}
```

#### Example response (200)
```json
{
  "id": 15,
  "name": "test1",
  "price": 123.99,
  "categories": [
    {
      "id": 7,
      "code": "MkupCosm"
    }
  ]
}
```

#### Example response (400)
```json
{
  "message": "VALIDATION_ERROR",
  "code": 0,
  "details": {
    "categoryIds": "This collection should contain 1 element or more."
  }
}
```

***

### Product details

```http
  GET /products/{productId}
```

| Parameter     | Type    | Description                |
|:--------------|:--------|:---------------------------|
| `productId`   | `query` | **Required**. product ID   |

***

### Delete product

```http
  DELETE /products/{productId}
```

| Parameter     | Type    | Description                |
|:--------------|:--------|:---------------------------|
| `productId`   | `query` | **Required**. product ID   |

When the resource is successfully deleted - No Content (204) is returned.

***

### Product list

```http
  GET /products
```

***

### Category list

```http
  GET /categories
```

