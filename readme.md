# Thank you for reading me!

> Thank you so much for giving me this opportunity to showcase what I can be capable of and more if time allowed. 


* To execute this program a PHP server is required.
* Valet or Laragon may speed up the process as they come bundled with all the requirements needed.
* You can run urls like http://roomraccoon-tafara.test on local machine (laragon/valet)

* PHP 8.2 is required as a minimum as some methods use the true, false return types. PHP 8 - Constructor property
  promotion, Union Types, static return type declaration,

* A live version can be accessed on http://roomraccoon.tafarashamu.co.za

## Required Programs:
> Mysql ^8.0.32 / Mysql client
> PHP ^8.2
> Composer
> Laragon/Valet/Docker setup

## Installation: make sure you have set up the required programs as mentioned above:
> Copy the folder in the root folder on your server,
> Link the public folder to run the index file on your preferred server,
> I have also attached the sql file in the Database folder with all the queries to create database and tables in a MySQL DB client.
> Make sure the .env file has the right database details.
> You can then launch the program on your browser using the local url or virtual host you created e.g. http://roomraccoon-tafara.test
> 
> 
> On launch, you will be greeted by a login page, the default operator login credentials are: 
> USERNAME: suvin
> PASSWORD: password
>
> You can also test with wrong details to see the error messages.
> I have also attached the sql file with all the queries to create database and tables in MySQL DB client.
> 
> You should be able to create a customer, invoices and simulate the invoice payment page.
> 
> The dashboard earnings are based on the payments made and the total amount of invoices due/paid.
> 
> 
> You can view a customer and their invoices on the customer dashboard
> Customer payment link will be displayed on unpaid invoices
> Customer balance will be triggered by new invoice entries and payment entries
> 
> 
## The program folder structure:
> The app folder this is where user can add controllers, form request validations, models app configurations
> The Core folder is the heart of the program. Users can add new classes when adding new features to the whole program
> Logs when errors displaying is set to false error logs will be created instead of being displayed
> Public folder where application assets can be added i.e. css, javaScripts, images etcetera.
> Views folders where program representation files are created i.e. dashboards.
> Test folder, phpunit test are created.




