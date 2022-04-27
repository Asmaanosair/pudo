---
title: API Reference

language_tabs:
- javascript
- php
- python
- bash

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://pudo.delivery/docs/collection.json)

<!-- END_INFO -->

#Integration API


<!-- START_28369bbffb8a4d93dcb425c88971dc43 -->
## Create an Order
 use this API to send an order to Pudo control panel

> Example request:

```javascript
const url = new URL(
    "https://pudo.delivery/api/agent/order/create"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Authorization": "{API-KEY}",
    "Api-Version": "v1",
};

let body = {
    "api_id": "GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.",
    "branch_id": "342334.",
    "order_price": 40,
    "discount": 0,
    "number_of_products": 4,
    "deliver_fees": 10,
    "pay_on_pickup": 10,
    "collect_on_delivery": 10,
    "Payment": "quo",
    "pick_up_lng": "21.24354345.",
    "pick_up_lat": "21.24354345.",
    "shipment_number": 44343,
    "shipment_weight": "2kg.",
    "delivery_lng": "21.24354345.",
    "delivery_lat": "22.134566566.",
    "customer_name": "temporibus",
    "customer_mobile": "1234567890.",
    "delivery_time": "2020-03-01 16:22:11.",
    "products": "[{\"name\":\"product name\",\"quantity\": 2,\"note\":\"if any note or leave it null\"},{\"name\":\"product name\",\"quantity\": 2,\"note\":\"if any note or leave it null\"}]."
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://pudo.delivery/api/agent/order/create',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Authorization' => '{API-KEY}',
            'Api-Version' => 'v1',
        ],
        'json' => [
            'api_id' => 'GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.',
            'branch_id' => '342334.',
            'order_price' => 40.0,
            'discount' => 0.0,
            'number_of_products' => 4.0,
            'deliver_fees' => 10.0,
            'pay_on_pickup' => 10.0,
            'collect_on_delivery' => 10.0,
            'Payment' => 'quo',
            'pick_up_lng' => '21.24354345.',
            'pick_up_lat' => '21.24354345.',
            'shipment_number' => 44343.0,
            'shipment_weight' => '2kg.',
            'delivery_lng' => '21.24354345.',
            'delivery_lat' => '22.134566566.',
            'customer_name' => 'temporibus',
            'customer_mobile' => '1234567890.',
            'delivery_time' => '2020-03-01 16:22:11.',
            'products' => '[{"name":"product name","quantity": 2,"note":"if any note or leave it null"},{"name":"product name","quantity": 2,"note":"if any note or leave it null"}].',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://pudo.delivery/api/agent/order/create'
payload = {
    "api_id": "GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.",
    "branch_id": "342334.",
    "order_price": 40,
    "discount": 0,
    "number_of_products": 4,
    "deliver_fees": 10,
    "pay_on_pickup": 10,
    "collect_on_delivery": 10,
    "Payment": "quo",
    "pick_up_lng": "21.24354345.",
    "pick_up_lat": "21.24354345.",
    "shipment_number": 44343,
    "shipment_weight": "2kg.",
    "delivery_lng": "21.24354345.",
    "delivery_lat": "22.134566566.",
    "customer_name": "temporibus",
    "customer_mobile": "1234567890.",
    "delivery_time": "2020-03-01 16:22:11.",
    "products": "[{\"name\":\"product name\",\"quantity\": 2,\"note\":\"if any note or leave it null\"},{\"name\":\"product name\",\"quantity\": 2,\"note\":\"if any note or leave it null\"}]."
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'X-Authorization': '{API-KEY}',
  'Api-Version': 'v1'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```bash
curl -X POST \
    "https://pudo.delivery/api/agent/order/create" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "X-Authorization: {API-KEY}" \
    -H "Api-Version: v1" \
    -d '{"api_id":"GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.","branch_id":"342334.","order_price":40,"discount":0,"number_of_products":4,"deliver_fees":10,"pay_on_pickup":10,"collect_on_delivery":10,"Payment":"quo","pick_up_lng":"21.24354345.","pick_up_lat":"21.24354345.","shipment_number":44343,"shipment_weight":"2kg.","delivery_lng":"21.24354345.","delivery_lat":"22.134566566.","customer_name":"temporibus","customer_mobile":"1234567890.","delivery_time":"2020-03-01 16:22:11.","products":"[{\"name\":\"product name\",\"quantity\": 2,\"note\":\"if any note or leave it null\"},{\"name\":\"product name\",\"quantity\": 2,\"note\":\"if any note or leave it null\"}]."}'

```



### HTTP Request
`POST api/agent/order/create`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_id` | string |  required  | your API ID
        `branch_id` | string |  required  | The branch_id of the Branch to be the same on your system
        `order_price` | float |  required  | the price of the order products without any discounts or fees
        `discount` | float |  optional  | the discount amount
        `number_of_products` | number |  optional  | the discount amount
        `deliver_fees` | float |  required  | the delivery fees amount
        `pay_on_pickup` | float |  required  | the pay on pickup amount
        `collect_on_delivery` | float |  required  | the collect on delivery amount
        `Payment` | Method |  optional  | COD =>Cash On Delivery = 1
        `pick_up_lng` | string |  optional  | the longitude value for the pickup location
        `pick_up_lat` | string |  optional  | the latitude value for the pickup location
        `shipment_number` | number |  required  | the shipment_number
        `shipment_weight` | string |  optional  | optional the shipment_weight
        `delivery_lng` | string |  required  | the longitude value for the delivery location
        `delivery_lat` | string |  required  | the latitude value for the delivery location
        `customer_name` | string |  optional  | the name of the customer needs the order Example salem:.
        `customer_mobile` | string |  optional  | the mobile of the customer needs the order
        `delivery_time` | dateTime |  required  | must be like
        `products` | Array |  optional  | the list of products will be in this order
    
<!-- END_28369bbffb8a4d93dcb425c88971dc43 -->

<!-- START_5f597fed2d3132318f4058abcdd1dc18 -->
## Show  Order Details

> Example request:

```javascript
const url = new URL(
    "https://pudo.delivery/api/agent/order/show"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Authorization": "{API-KEY}",
    "Api-Version": "v1",
};

let body = {
    "api_id": "GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.",
    "order_id": "342334."
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://pudo.delivery/api/agent/order/show',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Authorization' => '{API-KEY}',
            'Api-Version' => 'v1',
        ],
        'json' => [
            'api_id' => 'GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.',
            'order_id' => '342334.',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://pudo.delivery/api/agent/order/show'
payload = {
    "api_id": "GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.",
    "order_id": "342334."
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'X-Authorization': '{API-KEY}',
  'Api-Version': 'v1'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```bash
curl -X POST \
    "https://pudo.delivery/api/agent/order/show" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "X-Authorization: {API-KEY}" \
    -H "Api-Version: v1" \
    -d '{"api_id":"GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.","order_id":"342334."}'

```



### HTTP Request
`POST api/agent/order/show`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_id` | string |  required  | your API ID
        `order_id` | string |  required  | The order_id of the order to be the same on your system
    
<!-- END_5f597fed2d3132318f4058abcdd1dc18 -->

<!-- START_e4666a5c94c93aaaa64f9c3192d5e158 -->
## Update an Order
 use this API to update an order programmatically on Pudo.

> Example request:

```javascript
const url = new URL(
    "https://pudo.delivery/api/agent/order/update"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Authorization": "{API-KEY}",
    "Api-Version": "v1",
};

let body = {
    "api_id": "GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.",
    "Order_id": "342334.",
    "order_price": 40,
    "discount": 0,
    "number_of_products": 4,
    "deliver_fees": 10,
    "Payment": "quo",
    "pick_up_lng": "21.24354345.",
    "pick_up_lat": "21.24354345.",
    "delivery_lng": "21.24354345.",
    "delivery_lat": "22.134566566.",
    "customer_name": "aut",
    "customer_mobile": "1234567890.",
    "delivery_time": "2020-03-01 16:22:11",
    "shipment_number": 44343,
    "shipment_weight": "2kg."
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://pudo.delivery/api/agent/order/update',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Authorization' => '{API-KEY}',
            'Api-Version' => 'v1',
        ],
        'json' => [
            'api_id' => 'GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.',
            'Order_id' => '342334.',
            'order_price' => 40.0,
            'discount' => 0.0,
            'number_of_products' => 4.0,
            'deliver_fees' => 10.0,
            'Payment' => 'quo',
            'pick_up_lng' => '21.24354345.',
            'pick_up_lat' => '21.24354345.',
            'delivery_lng' => '21.24354345.',
            'delivery_lat' => '22.134566566.',
            'customer_name' => 'aut',
            'customer_mobile' => '1234567890.',
            'delivery_time' => '2020-03-01 16:22:11',
            'shipment_number' => 44343.0,
            'shipment_weight' => '2kg.',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://pudo.delivery/api/agent/order/update'
payload = {
    "api_id": "GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.",
    "Order_id": "342334.",
    "order_price": 40,
    "discount": 0,
    "number_of_products": 4,
    "deliver_fees": 10,
    "Payment": "quo",
    "pick_up_lng": "21.24354345.",
    "pick_up_lat": "21.24354345.",
    "delivery_lng": "21.24354345.",
    "delivery_lat": "22.134566566.",
    "customer_name": "aut",
    "customer_mobile": "1234567890.",
    "delivery_time": "2020-03-01 16:22:11",
    "shipment_number": 44343,
    "shipment_weight": "2kg."
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'X-Authorization': '{API-KEY}',
  'Api-Version': 'v1'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```bash
curl -X POST \
    "https://pudo.delivery/api/agent/order/update" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "X-Authorization: {API-KEY}" \
    -H "Api-Version: v1" \
    -d '{"api_id":"GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.","Order_id":"342334.","order_price":40,"discount":0,"number_of_products":4,"deliver_fees":10,"Payment":"quo","pick_up_lng":"21.24354345.","pick_up_lat":"21.24354345.","delivery_lng":"21.24354345.","delivery_lat":"22.134566566.","customer_name":"aut","customer_mobile":"1234567890.","delivery_time":"2020-03-01 16:22:11","shipment_number":44343,"shipment_weight":"2kg."}'

```



### HTTP Request
`POST api/agent/order/update`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_id` | string |  required  | your API ID
        `Order_id` | string |  required  | The Order_id of the order to be the same on your system
        `order_price` | float |  required  | the price of the order products without any discounts or fees
        `discount` | float |  optional  | the discount amount
        `number_of_products` | number |  optional  | the discount amount
        `deliver_fees` | float |  required  | the delivery fees amount
        `Payment` | Method |  optional  | COD =>Cash On Delivery = 1
        `pick_up_lng` | string |  optional  | the longitude value for the pickup location
        `pick_up_lat` | string |  optional  | the latitude value for the pickup location
        `delivery_lng` | string |  required  | the longitude value for the delivery location
        `delivery_lat` | string |  required  | the latitude value for the delivery location
        `customer_name` | string |  optional  | the name of the customer needs the order Example salem:.
        `customer_mobile` | string |  optional  | the mobile of the customer needs the order
        `delivery_time` | dateTime |  required  | must be like
        `shipment_number` | number |  required  | the shipment_number
        `shipment_weight` | string |  optional  | optional the shipment_weight
    
<!-- END_e4666a5c94c93aaaa64f9c3192d5e158 -->

<!-- START_bf1837e4de32a2df1467dd5c2ee33b22 -->
## Delete an Order
 use this API to delete an order programmatically from Pudo.

> Example request:

```javascript
const url = new URL(
    "https://pudo.delivery/api/agent/order/delete"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Authorization": "{API-KEY}",
    "Api-Version": "v1",
};

let body = {
    "api_id": "GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.",
    "order_id": "342334."
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://pudo.delivery/api/agent/order/delete',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Authorization' => '{API-KEY}',
            'Api-Version' => 'v1',
        ],
        'json' => [
            'api_id' => 'GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.',
            'order_id' => '342334.',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://pudo.delivery/api/agent/order/delete'
payload = {
    "api_id": "GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.",
    "order_id": "342334."
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'X-Authorization': '{API-KEY}',
  'Api-Version': 'v1'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```bash
curl -X POST \
    "https://pudo.delivery/api/agent/order/delete" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "X-Authorization: {API-KEY}" \
    -H "Api-Version: v1" \
    -d '{"api_id":"GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.","order_id":"342334."}'

```



### HTTP Request
`POST api/agent/order/delete`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_id` | string |  required  | your API ID
        `order_id` | string |  required  | The order_id of the order to be the same on your system
    
<!-- END_bf1837e4de32a2df1467dd5c2ee33b22 -->

<!-- START_ffc68bb8bfbc50343eaf4910fdaea859 -->
## Assign Order to a driver
 this api to assign and order already existing on Pudo to a driver

> Example request:

```javascript
const url = new URL(
    "https://pudo.delivery/api/agent/order/assignToDriver"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Authorization": "{API-KEY}",
    "Api-Version": "v1",
};

let body = {
    "api_id": "GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.",
    "order_id": "342334.",
    "driver_id": "65435."
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://pudo.delivery/api/agent/order/assignToDriver',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Authorization' => '{API-KEY}',
            'Api-Version' => 'v1',
        ],
        'json' => [
            'api_id' => 'GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.',
            'order_id' => '342334.',
            'driver_id' => '65435.',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://pudo.delivery/api/agent/order/assignToDriver'
payload = {
    "api_id": "GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.",
    "order_id": "342334.",
    "driver_id": "65435."
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'X-Authorization': '{API-KEY}',
  'Api-Version': 'v1'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```bash
curl -X POST \
    "https://pudo.delivery/api/agent/order/assignToDriver" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "X-Authorization: {API-KEY}" \
    -H "Api-Version: v1" \
    -d '{"api_id":"GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.","order_id":"342334.","driver_id":"65435."}'

```



### HTTP Request
`POST api/agent/order/assignToDriver`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_id` | string |  required  | your API ID
        `order_id` | string |  required  | The order_id of the order to be the same on your system
        `driver_id` | required |  optional  | The order_id of the driver
    
<!-- END_ffc68bb8bfbc50343eaf4910fdaea859 -->

<!-- START_0813c3d3ff2cabe3c42f357cc3e7a3fa -->
## Reassign Order to another Driver
 this api to reassign and order already existing on Pudo and assigned to a driver to another driver

> Example request:

```javascript
const url = new URL(
    "https://pudo.delivery/api/agent/order/reassignToDriver"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Authorization": "{API-KEY}",
    "Api-Version": "v1",
};

let body = {
    "api_id": "GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.",
    "order_id": "342334.",
    "driver_id": "65435."
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://pudo.delivery/api/agent/order/reassignToDriver',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Authorization' => '{API-KEY}',
            'Api-Version' => 'v1',
        ],
        'json' => [
            'api_id' => 'GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.',
            'order_id' => '342334.',
            'driver_id' => '65435.',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://pudo.delivery/api/agent/order/reassignToDriver'
payload = {
    "api_id": "GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.",
    "order_id": "342334.",
    "driver_id": "65435."
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'X-Authorization': '{API-KEY}',
  'Api-Version': 'v1'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```bash
curl -X POST \
    "https://pudo.delivery/api/agent/order/reassignToDriver" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "X-Authorization: {API-KEY}" \
    -H "Api-Version: v1" \
    -d '{"api_id":"GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.","order_id":"342334.","driver_id":"65435."}'

```



### HTTP Request
`POST api/agent/order/reassignToDriver`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_id` | string |  required  | your API ID
        `order_id` | string |  required  | The order_id of the order to be the same on your system
        `driver_id` | required |  optional  | The code of the driver
    
<!-- END_0813c3d3ff2cabe3c42f357cc3e7a3fa -->


