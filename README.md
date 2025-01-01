# Project-AI
## Setup Instructions

### 1. Clone the Project
Start by adding the project to your local machine.

### 2. Install PHP Dependencies
Execute the following command to install all required PHP dependencies:
```bash
composer install
```
3. Create Environment File
Copy the example environment file to create your own configuration:


```bash
cp .env.example .env
```
4. Generate Application Key
Run the command below to generate a unique application key:

```bash
php artisan key:generate
```
5. Install Frontend Dependencies
Install the necessary frontend dependencies using Yarn:

```bash
yarn
```
6. Build Frontend Assets
Compile the frontend assets with this command:

```bash
yarn build
```
7. Start Laravel Development Server
Launch the Laravel development server by running:
bash

```bash
php artisan serve
```
8. Run Development with Hot Reloading
For a development environment with hot reloading, use:

```bash
yarn dev
```
9. Set Directory Permissions
Ensure the bootstrap/cache and storage directories have the correct permissions:

```bash
sudo chmod -R o+rw bootstrap/cache
sudo chmod -R o+rw storage
```
10. Database Configuration
You need to have a database set up or create a new one to proceed. Set your database credentials in the .env file as follows:
javascript

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=DATABASE_NAME
DB_USERNAME=DATABASE_USERNAME
DB_PASSWORD=DATABASE_PASSWORD
```
11. Run Migrations
Finally, execute the following command to run the migrations and set up your database:

```bash
php artisan migrate
```
