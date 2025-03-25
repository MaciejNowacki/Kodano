
## Installation

Install project

```bash
  docker-compose up -d
  docker exec -it php bash
  cd ../project
  composer install
  php bin/console doctrine:migrations:execute --force
  php bin/console doctrine:fixtures:load
```


## API Reference

#### Create product

```http
  POST /products
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | **Required**. name |
| `price` | `float` | **Required**. price |
| `categoryIds` | `array` | **Required**. category IDs |


#### Assign product to categories

```http
  PATCH /products/{productId}/categories
```

| Parameter     | Type    | Description                |
|:--------------|:--------|:---------------------------|
| `productId`   | `query` | **Required**. product ID   |
| `categoryIds` | `array` | **Required**. category IDs |


#### Product details

```http
  GET /products/{productId}
```

| Parameter     | Type    | Description                |
|:--------------|:--------|:---------------------------|
| `productId`   | `query` | **Required**. product ID   |

#### Delete product

```http
  DELETE /products/{productId}
```

| Parameter     | Type    | Description                |
|:--------------|:--------|:---------------------------|
| `productId`   | `query` | **Required**. product ID   |


#### Product list

```http
  GET /products
```

#### Category list

```http
  GET /categories
```

