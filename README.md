# ASAB Budget Manager Prototype

The ASAB Budget Manager prototype is a project that allows for organizations' managers to submit budget requests online. The requests are then easily reviewed by ASAB officers who can accept, deny, and comment on pending applications. Managers are able to view information regarding submitted apps while officers can view all apps regardless of status.

Specific apps are viewed via URL parsing.

## Installation

Clone the repository.
```git
$ git clone https://github.com/hopesimon/Budget-Manager.git
```

Make sure that you have MySQL 5.7.x, PHP, and a server set up. Create a new database and import the SQL file in the `sql` folder of the repository.

Adjust `php/db_connect.php` according to your database credentials.

Open the `index.php` file in your server.

If files are not opening properly, adjust all links to direct to `file_name.php` instead of `file_name`.



### Requirements
* PHP
* MySQL 5.7.x
* Server

## Front-End Template Credits

This project utilized Bootstrap for front-end development. Additionally, the template [SB Admin 2](https://startbootstrap.com/template-overviews/sb-admin-2/) was used for the admin pages, and the [Bare](https://startbootstrap.com/template-overviews/bare/) template was used for other pages. Both templates are created by Start Bootstrap.

## License
[MIT](https://choosealicense.com/licenses/mit/)
