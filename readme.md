# Cobiro

This project was developed as part of a test proposed by Cobiro for a
PHP/Laravel developer oportunity

The project was developed with:

-   **API** = Laravel 5.8

This project also has **redis** (for cache), **docker**, **postgres**, and was developed aplying **TDD** techniques

## Goals

Bellow is a list of primaries and secondaries features requested

**Task Description**

Fork or Download this repository and implement the logic to manage a menu.
A Menu has a depth of N and maximum number of items per layer M. Consider N and M to be dynamic for bonus points.
It should be possible to manage the menu by sending API requests. Do not implement a frontend for this task.
Feel free to add comments or considerations when submitting the response at the end of the README.

**Bonus Points**

-   [x] Allow API users to inform menu's max children
-   [ ] Allow API users to inform menu's max depth
-   [ ] 10 vs 1.000.000 menu items - what would you do differently
-   [x] Write documentation
-   [x] Use PHPCS
-   [x] Use PHPCSFixer
-   [x] Use PHPStan
-   [x] Use Docker
-   [x] Use Cache
-   [ ] Use data structures

## Getting Started

These instructions will get you a copy of the project up and running on your local machine.

### Prerequisites

-   **API**
-   PHP >= 7.1.3
-   BCMath PHP Extension
-   Ctype PHP Extension
-   JSON PHP Extension
-   Mbstring PHP Extension
-   OpenSSL PHP Extension
-   PDO PHP Extension
-   Tokenizer PHP Extension
-   XML PHP Extension
-   Composer
-   Docker

You can also visit the [Laravel Documentation website](https://https://laravel.com/docs/5.8) for more information.

### Installing

1. Once you took care of the requeriments, lets install the software.
2. Clone this repository to your computer, and access the folder you chose
3. once inside lets install it!
4. run "composer install"
5. then rename the ".env.example" to ".env"
6. once that is done run "php artisan key:generate".
7. in order to get database and cache server up we need to get docker running
8. to do so, first install and run Docker
9. after that, in the project main folder run "docker-compose up"
10. this will get you a postgres and redis servers running
11. the next one is "php artisan migrate" from the main folder. This will generate create the database.
12. That is it. Now lets run it.
13. still on the folder run "php artisan serve" this will run the backend on localhost:8000 port;
14. in case this port is busy, the system will pick another one and inform you. :satisfied:

### Testing

Besides the feature tests implemented with PHPUnit there is also a [insomnia configuration file](https://gitlab.com/ll-tests/cobiro/blob/master/cobiro_insomnia.json) added to the project files, in case you want to test it manually

## API

### Endpoints

for wild cards I will us {parameter}

**Endpoints**

### `POST /menus`

Create a menu.

#### Input

```json
{
    "name": "value",
    "max_children": 0
}
```

#### Output

```json
{
    "name": "value",
    "max_children": 0,
    "id": 1
}
```

### `GET /menus/{menu}`

Get the menu.

#### Output

```json
{
    "id": 1,
    "name": "value",
    "max_children": 0
}
```

### `PUT|PATCH /menus/{menu}`

Update the menu.

#### Input

```json
{
    "name": "value",
    "max_children": 0
}
```

#### Output

```json
{
    "name": "value",
    "max_children": 0,
    "id": 1
}
```

### `DELETE /menus/{menu}`

Delete the menu.

### `POST /menus/{menu}/items`

Create menu items.

#### Input

```json
[
    {
        "name": "Item 1"
    },
    {
        "name": "Item 2"
    }
]
```

#### Output

```json
[
    {
        "id": 1,
        "menu_id": 1,
        "name": "Item 1",
        "layer": 1
    },
    {
        "id": 2,
        "menu_id": 1,
        "name": "Item 2",
        "layer": 2
    }
]
```

### `GET /menus/{menu}/items`

Get all menu items.

#### Output

```json
[
    {
        "id": 1,
        "menu_id": 1,
        "name": "Item 1",
        "layer": 1
    },
    {
        "id": 2,
        "menu_id": 1,
        "name": "Item 2",
        "layer": 2
    }
]
```

### `DELETE /menus/{menu}/items`

Remove all menu items.

### `POST /items`

Create an item.

#### Input

```json
{
    "name": "Item 1"
}
```

#### Output

```json
{
    "name": "Item 1",
    "id": 1
}
```

### `GET /items/{item}`

Get the item.

#### Output

```json
{
    "name": "Item 1",
    "id": 1
}
```

### `PUT|PATCH /items/{item}`

Update the item.

#### Input

```json
{
    "name": "Item 1"
}
```

#### Output

```json
{
    "id": 1,
    "menu_id": null,
    "name": "Item 1",
    "layer": null
}
```

### `DELETE /items/{item}`

Delete the item.

### `GET /menus/{menu}/layers/{layer}`

Get all menu items in a layer.

#### Output

```json
[
    {
        "id": 1,
        "menu_id": 1,
        "name": "Item 1",
        "layer": 1
    },
    {
        "id": 2,
        "menu_id": 1,
        "name": "Item 2",
        "layer": 2
    }
]
```

### `DELETE /menus/{menu}/layers/{layer}`

Remove a layer and relink `layer + 1` with `layer - 1`, to avoid dangling data.

**Genéric Error response**

```
{
  "error": "There is no instance of user with the given id",
  "code": 404
}
```

**Validation Error response**

```
{
    "error":[
        "errors": [
            [name=> "field name is required"],
            [email=> "field email should be a valid email"],
        ],
    "code": 422
    ]
}
```

## Built With

-   [Laravel](https://laravel.com) - PHP Framework

I Hope you guys like it, so I can join the team :)

### Thats all Folks
