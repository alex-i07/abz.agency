# Intro

This application stores employees list in a relational database as a adjacency list and displays it as a tree. Each employee has one chief.

## Features

All employees of first level are displayed on main page. Subordinates are loaded with lazy loading using ajax when user clicks to open a node.
If user is authorized he can do: 
- sorting by name, employee position, employment date and salary;
- searching, search is performed by back-end then results are transferred to front-end;
- user can upload photo and change info about employees;
- there is ability to move employee using drag-n-drop in the treel
- user can create new employees.


## Getting Started

Clone the project repository by running the command below if you use SSH

```bash
git clone git@github.com:ximee/abz.agency.git
```

If you use https, use this instead

```bash
git clone https://github.com/ximee/abz.agency.git
```

After cloning,run:

```bash
composer install
```

and:

```bash
npm install
```

Duplicate `.env.example` and rename it `.env`

Then run:

```bash
php artisan key:generate
```

#### Database Migrations

Be sure to fill in your database details in your `.env` file before running the migrations:

```bash
php artisan migrate
```

#### Faker

You can fill DB with dummy data. Check Faker options in .env file.
This option shows total employee number that would be created by faker:
```bash
EMPLOYEES_NUMBER
```
```bash
PERCENTAGE
```
Number of values of this string denote how many levels of hierarchy in company are;
values itself show percentage of whole employees number on each hierarchy level;
separate them by comma, after last one comma is not needed

To launch seeding use command:

```bash
php artisan db:seed
```