## Introduction

This is an automatic game card concept.


## Prerequisites

-   [PHP 7.x](https://www.php.net/manual/en/install.php)


## Install

```sh
# Clone project
git clone git@github.com:newrare/card.git card

# Open project
cd card

# Start local serveur
php -S localhost:8000 -t public/
```


## Starting

Open your navigator to http://localhost:8000/game/start

Reload this page for simulate a new game.


## Project structure

-   **Service**:
    -   `src/AppBundle/Service`: Card, Game, Player
-   **Controller**:
    -   `GameController`: start


## Todo

The players have a level of children. They will always play their strongest card. This point should be improved.
Add logger method and test method call result and debug.
Add Tests

## Licence

MIT

