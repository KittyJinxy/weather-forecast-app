<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Weather Forecast Search By IP Project by ~Marie

## Description
This project is a 5-days weather forecast search by IP app that allows users to search for the weather searching by IP. When the user goes to the page it will display the weather using his IP by default, however he can search with other IPs to see the 5-days weather forecast. Each result will be saved in the database. If the user search for the same IP, the result will be displayed from the database instead of making a new request to the API.

The search can also be made via CLI which will return the result in the terminal and be saved in the databse.

## Pre-requisites
- Docker (https://docs.docker.com/get-docker/) Version 20.10.21
- Composer (https://getcomposer.org/download/) Version 2.3.5
- PHP (https://www.php.net/downloads.php) Version 8.1.10

## Start the project
Please note that the project is using Docker and Docker Compose.

There are 2 ways to start the project depending on your OS performance.
- Using only Docker (recommended)
- Using Docker and PHP on your machine (If docker is too slow on your machine)

Please choose the one that suits you best and follow the instructions below.

### Using only Docker

From the root of the project, run the following command:
```sh
docker compose up
```
Wait for the containers to be built and then visit the site locally: http://127.0.0.1:8000

### Using Docker and PHP on your machine
> This is the recommended way to start the project if docker is too slow on your machine.

From the root of the project, run the following command to start the database (and phpmyadmin if you want to see the database):
```sh
docker compose up mysql phpmyadmin
```
Wait for the containers to be built and then run the following command to start the app:
```sh
# Install the dependencies
composer install

# Migration of the database
php artisan migrate

# Start the app
php artisan serve
```
Wait for the app to be built and then visit the site locally: http://127.0.0.1:8000

> Note: If you want to restart the app, you'll need to run the last command again.

## How to use the app

### The web interface

After starting the project, you can use the web interface to search for the weather forecast by IP.

It's very simple, just visit the site locally: http://127.0.0.1:8000 and you'll see the weather forecast by default using your own IP.

> Note: It will use 127.0.0.1 locally due to the fact that the app is running on your machine.

The application is displaying the user's weather forecast by default using his own IP. The user can type in the input field an IP and then click on the search button to find another 5-days weather forecast associated with that IP address.

If the IP is valid it will display the result on the page and save it in the database, if the search is already saved in the database, it will output the results from the database, otherwise if the IP isn't valid,  it will display an error message saying that the IP address is not valid.

### Using the CLI

There are 2 ways to use the CLI depending on how you started the project.

#### Prerequisite with only Docker startup

First please make sure that the containers are running.
Then enter in the container by running the following command:
```sh
docker exec -it weather-app-weatherforecast-1 sh
```
After that please be sure to be in the root of the project.

Then to use the CLI please refer to the instructions below in the section `How to use the CLI`.
#### Prerequisite using Docker and PHP on your machine
First please make sure that the containers are running and the app is started.
After that please be sure to be in the root of the project.

Then to use the CLI please refer to the instructions below.

#### How to use the CLI
To have documentation about the commands, please run the following command:
```sh
php artisan 
```

Run the following command to search for the weather forecast by IP:
```sh
php artisan weather:forecast xxx.xxx.xxx.xxx
```

It will check that the IP is valid and then output the result in the terminal.
If it's the first time you search for this IP, it will make a request to the API and save the result in the database, otherwise it will output the result from the database.

> #### Important note
> - *The weather API I'm using has a limit of requests as it's a free plan. If you do too many requests, you'll end up having a 503 error*

## Credits
This project was developed by `~Marie` for a coding challenge.

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
