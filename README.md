## HTTP-NOTIFICATION-SYSTEM

This project focuses on http notification system in which a server (or set of servers) will keep track of topics->subscribers where a topic is a string and a subscriber is an HTTP endpoint. When a message is published on a topic, it should be forwarded to all subscriber endpoints.

### Clone the app:
```
https://github.com/Eazybright/http-notification-system.git
```

#### Database Setup
This application needs a MySQL database running on the host machine to work.

* Update the database `.env` variables in the project root folder i.e:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=http_notification
DB_USERNAME=YOUR_MYSQL_USERNAME
DB_PASSWORD=YOUR_MYSQL_PASSWORD
```

### Running the app
* `cd` into the project folder (if you're not already there)
* `composer install` to install the dependencies
* `php artisan serve --port=9000` for the subsriber server
* `php artisan serve` for the publisher server. Optionally you can add `--port=8000` argument to the command but laravel runs the port `8000` by default
* Open your favourite API testing tool to access the endpoints

### API Documentation
Documentation available at: <a href="https://documenter.getpostman.com/view/12783380/2s8YsnWFQq">https://documenter.getpostman.com/view/12783380/2s8YsnWFQq</a>

### Running Test
To testing the application using PHPUnit, run:
```
./vendor/bin/phpunit 
```

To run specific tests, you can sustitute the filter argument with the name of the available test methods:
```
./vendor/bin/phpunit --filter=testSubsciberGetMessage
```
