# ASAB Budget Manager Prototype

The ASAB Budget Manager prototype is a project that allows for organizations' managers to submit budget requests online. The requests are then easily reviewed by ASAB officers who can accept, deny, and comment on pending applications. Managers are able to view information regarding submitted apps while officers can view all apps regardless of status.

Specific apps are viewed via URL parsing.

## Example Project

This project is hosted on FAU's LAMP servers in order to serve as a fully-functional example of the project.

The host link is: [http://lamp.cse.fau.edu/~hsimon2015/budget/](http://lamp.cse.fau.edu/~hsimon2015/budget/).

## Installation

Clone the repository.
```git
$ git clone https://github.com/hopesimon/Budget-Manager.git
```

Make sure that you have MySQL 5.7.x, PHP, and a server set up. Create a new database and import the SQL file in the `sql` folder of the repository.

Adjust `php/db_connect.php` according to your database credentials.

Open the `index.php` file in your server.

If you do not have some sort of content negotiation, the files will not open since they are missing file extensions. To fix this, adjust all links to direct to `file_name.php` instead of `file_name`. On `admin/admin.php` you will have to ensure that all `<a class = 'no-dec' href='forms?id=$####'>` is changed to `<a class = 'no-dec' href='forms.php?id=$####'>`.



### Requirements
* PHP
* MySQL 5.7.x
* Server

## Front-End Template Credits

This project utilized Bootstrap for front-end development. Additionally, the template [SB Admin 2](https://startbootstrap.com/template-overviews/sb-admin-2/) was used for the admin pages, and the [Bare](https://startbootstrap.com/template-overviews/bare/) template was used for other pages. Both templates are created by Start Bootstrap.

## License
[MIT](https://choosealicense.com/licenses/mit/)
