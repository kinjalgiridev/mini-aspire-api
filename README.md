# Getting started
## Requirements
-   PHP >= 7.
-   Mcrypt PHP Extension.
-   OpenSSL PHP Extension.
-   Mbstring PHP Extension.
-   Tokenizer PHP Extension.
-   MySQL 8.0

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Clone the repository

    git clone https://github.com/kinjalgiridev/mini-aspire-api.git

Switch to the repo folder

    cd mini-aspire-api

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Generate a new JWT authentication secret key

    php artisan jwt:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run the database migrations (**Make sure you have execute migrations before seeding**)

    php artisan db:seed --class=RoleSeeder
    php artisan db:seed --class=UserSeeder

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**Command list**

    git clone https://github.com/kinjalgiridev/mini-aspire-api.git
    cd mini-aspire-api
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan jwt:generate 
	
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
	php artisan db:seed --class=RoleSeeder
    php artisan db:seed --class=UserSeeder
    php artisan serve

The api can be accessed at [http://localhost:8000/api](http://localhost:8000/api).

## API Specification

> [Full Postman API Spec](https://api.postman.com/collections/6140585-a951d199-4917-4af9-9e85-844bf85d6bd3?access_key=PMAT-01GQJ6JYVQAZG1ZA89RR050S4P)

----------

# Code overview

## Dependencies

- [jwt-auth](https://github.com/tymondesigns/jwt-auth) - For authentication using JSON Web Tokens

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers` - Contains all the controllers
- `app/Http/Middleware` - Contains the JWT auth middleware
- `app/Models` - Contains the models
- `app/Models/BaseModel` - Contains the common logic for status field for Loan and LoanRepayment models
- `app/Policy` - Contains the Policy for models
- `app/Traits` - Contains the Traits class used in models
- `app/Policy` - Contains the Policy for models
- `config` - Contains all the application configuration files
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the api routes defined in api.php file
- `tests` - Contains all the application tests
- `tests/TestCase.php` - Added authorize function to use in other tests

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Content-Type     	| application/json 	|
| Yes      	| X-Requested-With 	| XMLHttpRequest   	|
| Optional 	| Authorization    	| Token {JWT}      	|

Refer the [api specification](#api-specification) for more info.

----------
 
# Authentication
 
This applications uses JSON Web Token (JWT) to handle authentication. The token is passed with each request using the `Authorization` header with `Token` scheme. The JWT authentication middleware handles the validation and authentication of the token. Please check the following sources to learn more about JWT.
 
- https://jwt.io/introduction/
- https://self-issued.info/docs/draft-ietf-oauth-json-web-token.html

----------