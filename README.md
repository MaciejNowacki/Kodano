
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

#### Products details

```http
  GET /products
```



