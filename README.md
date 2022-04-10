#  Supermetrics test-task

## About
- Connection to external API to get token
- Automatically update token if it expires
- Getting an array of posts using PHP
- Saving in MySql database cache layer
- Synchronize only new posts on next connections
- Calculating user stats in MySql to reduce API connections
- React/Redux frontend to display author's statistics
- Some basic backend and frontend tests

## Technology stack
- Docker / docker-composer
- Nginx / PHP / MySql / PhpUnit
- React / Redux with hooks / react-routes / SCSS

## Install

Copy env file:
``cp backend/env.ini.example backend/env.ini``

Clone this repository and run:
``docker-compose up --build``

Next launches:

``docker-compose up``

- Frontend url: http://127.0.0.1:4002
- API url: http://127.0.0.1:4001

- Database: host 127.0.0.1 / port 4003 / user root / password root / database supermetrics