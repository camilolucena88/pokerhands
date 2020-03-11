<h1 align="center">Poker Test</h1>

## Guide to get started with Poker Test

First install Laravel 6.0 and Composer

https://getcomposer.org/

https://laravel.com/docs/6.x

## Requirements

PHP >= 7.3
Laravel 6.0

## How to

git clone https://github.com/camilolucena88/pokerhands

## Update Dependencies

composer update

## Set up Database

Copy and rename the .env.example to .env and get the APP_KEY

php artisan php artisan key:generate

## Migration

Run the following commands for migrations and seeders (Required Data)
>php artisan migrate:fresh

>php artisan db:seed --class=DatabaseSeeder

## Test

Run phpunit to confirm that everything is working.

If you have not set an in-memory database, please run again in order to have a clean database

 >php artisan migrate:fresh
 
 >php artisan db:seed --class=DatabaseSeeder

## Views

First you would have to login, feel free to use any email address, however, there is the system that it will act as player 2.

After you have set everything, you will be able to play, first you would be ask to upload the file as required (.txt) with the format:

8C TS KC 9H 4S 7D 2S 5D 3S AC

Each line of the file contains ten cards (space separated). the
first five are Player 1's cards and the last five are Player 2's cards.
