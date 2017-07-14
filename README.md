# simpleBlog
A simple blog application implemented using PHP, AngularJS,MYSQL and Bootstrap

# system requirements (tested with)
 1) Apache 2.4.18 (ubuntu 16.04)
 
 2) Mysql / mariadb  
 
 3) PHP 7.0 +
 
 # libraries
 
 1) I took inspiration from codeigniter and implemented my own php framework for server side MVC.
 2) Angularjs 1.6.5
 3) Bootstrap for front end design
 4) Jquery 3.2.1 (only added because bootstrap.min.js need jquery)
 
# setup
1) Place entire folder into /var/www directory of your server.

2) database schema is in application/database/schema.sql. Please import it into your mysql before running. It will create a database mg_blog and all tabels automatically.

3) please add your mysql server credentials into  application/database/mysql.json file.

4) .htaccess file included already for apache.

5) just launch http://localhost (or whatever server address settings you have) in browser.


