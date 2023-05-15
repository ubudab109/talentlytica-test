# Talentlytica Fullstack Engineer Test

## Framework
- Laravel 8
- Vue 2

## Prerequisite
- PHP ^7.3|^8.0
- VUE 2
- NODE ^16.15.0
- NPM ^8.5.5 or Yarn ^1.22 (PREFER NPM)
- MySQL
- Operating System (Windows or Linux)

## Setup
- Create database with any name (Prefer `talentlytica_test`)
- Create file `.env` then copy paste from `.env.example`
- Change the `DB_` prefix variable with Your own

## Installation
- Run composer install
- Run `php artisan key:generate` to replace freshly key application
- Run `php artisan:migrate` to migrate the table
- Run `php artisan db:seed` to seed the data
- Run `npm install` or `yarn install`

## How To Run
- After installation successfuly. Run `php artisan serve`
- Then run `npm run dev` or `npm run watch`

## View
- First View (Login)
![image](https://github.com/ubudab109/talentlytica-test/assets/62287144/a6b712ba-4b30-4eaa-b0fe-3cb1743748cb)
- Participant list view
![image](https://github.com/ubudab109/talentlytica-test/assets/62287144/3ccdef64-71ca-4429-a93d-d204150c08bd)
- Detail participant view
![image](https://github.com/ubudab109/talentlytica-test/assets/62287144/b96afb29-16eb-422e-9aca-5c30d061c98a)

## Authorization
### There are 2 type of user
- Admin (Can View List, Create, Edit, Delete, Detail)
- User (Can View List, Detail)

## Credential
- Admin (username: admin, password: admin)
- User (username: user, password: user)


