# MediaCube Test

The website was made using `Laravel 5.8` and it's designed to manage employees and work departments.

## Getting Started

[Live-demo](http://185.189.255.94:888)

## Getting Started

### Prerequisites

All you need is:
- [Php 7.*](http://php.net/downloads.php)
- [Composer](https://getcomposer.org/download/)
- [Npm](https://www.npmjs.com/get-npm)

Also check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.8/installation#installation)

### Installing

Clone the repository

    git clone git@github.com:pupsick/mediacube-test.git

Switch to the repo folder

    cd mediacube-test

Install all the dependencies using composer

    composer install
    npm install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve
    npm run watch

You can now access the server at http://localhost:8000

## What is done

In the process of implementation i've done:
- SPA
- Project structuring that is easy to raise and expand - both for frontend and backend
- Database design
- Database indexing
- Items listing with paginations
- Just a bit attractive interface

## How much time did i spend on it

5 hours in total, including ~3 hours for makeup + setting environment, and 2 hours for backend.

## What i'd love to add

Just a few things to add:
- Modals for actions confirmation - just because native `confirm` method is usually blocked by 3rd parties software or just manually by users
- Multiselect with `autocomplete` function instead of checkboxes on departments selection
- Just more data-validation
- Search function for employees list
- Caching functionality(firstly - for `Search function` above)
- Few improvements to make it more easier to navigate over the website. i.e. add link for employee, which has the max salary on department.
- Tab `employees` for department page, to make it more easy to get department's employees list
- Data-loading/transitions animations
- Extended statistic for departments.

Guess this list could be endless. Too many ideas how to improve it.:)




