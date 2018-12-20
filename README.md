# Films

## Installation
1. Clone the repository using `git clone`
1. Upload dump.sql file in MySQL database using `mysql -u <username> -p <databasename> < <filename.sql>`
1. Change database configurations in config/db.php

## Architecture description
The majority of the application is housed in the "app" directory:
   * Core - the classes for organization of the architecture of application. There is routing, dependency injection, the object-oriented request representation and validation classes.
   * Entities - the classes that are an object oriented representation of database tables
   * Repositories - the classes of the pattern Repository. In my application i work with database only with the help of these classes.
   * Services - so called Service Layer. The whole business logic of the application is here.
   * Controllers - the application implements the MVC pattern. Controllers are situated in this directory, they act as intermediaries between models and views.
   * App.php - class that launches the application. It uses routing to define which controller and its method should be executed.
All the routes of an application are defined in the routes.php file in the root of the project. 
There is also a "config" directory where project configuration files are (for now there is only one file for database configuration). In the "views" directory there are templates to display pages.
There are more files in the project root:
   * autoload.php - PSR autoload that creates one namespace(App) for "app" directory 
   * bindings.php - bind interfaces to implementations. This is necessary for dependency injection, so that the DI container would know which class instance to create if interface is specified in the method parameters.
   * dump.sql - MySql database dump
   * helpers.php - helper functions 
   * routes.php - the list of possible routes
   * index.php - application entry point