# Shortly URL shortening

## Project prupose

The application was created for the final project in the subject `"Hypertext languages and web development".` The project was inspired by the ["Frontend Mentor - URL shortening API landing page"](https://www.frontendmentor.io/challenges/url-shortening-api-landing-page-2ce3ob-G) challenge. The challenge itself has been expanded with additional pages [[gallery of subpages]](https://github.com/KoTubA/URL-Shortener/tree/main/design) and its own short link creation system, where registered users can add, edit and delete their own links.

<img src="./design/desktop-preview.jpg" alt="Design preview for the Shortly URL shortening API coding challenge" width="100%"/>

## Features

All of the following features use asynchronous query [(AJAX)](https://developer.mozilla.org/en-US/docs/Web/Guide/AJAX):

-   Creating shortened links (also by unregistered users)
-   Editing the names of shortened links
-   Removal of individual and all links

## How to run?

**1. Clone this repository:**

```
git clone https://github.com/KoTubA/URL-Shortener.git
```

or:

```
git clone git@github.com:KoTubA/URL-Shortener.git
```

**2. Create SQL database:**

Create your own database graphically or with the command:

```sql
CREATE DATABASE databasename;
```

Import the `/setup/import.sql` file into the database you created.

**3. Check the database connection configuration data:**

The `Database.php` file allows you to change the configuration of the connection with DB, its default configuration looks like this:

```php
//Database.php

private $host = "localhost";
private $user = "root";
private $pass = "";
private $dbname = "shortly";
```

## Live demo

Link to demo: https://shortly.5v.pl/
