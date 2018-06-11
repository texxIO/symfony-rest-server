# symfony-rest-server
A simple Symfony REST server


Install
========

1. GIT clone

2. From the app folder run:

   `composer install`

3. Set up the database details during the install process and the app key

4. Create the database user with the details you provided at step 3 

5. Create the database ( if you have the database created manually you can skip this step):
   
    `php bin/console doctrine:database:create`
    
        
6. Create the tables:
 
    `php bin/console doctrine:schema:update --force`

