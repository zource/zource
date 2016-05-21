# zource

The open source company management application.

## Work In Progress

This application is still work in progress.

## Installation

## Automatic Installation

**WARNING:** This is still WIP and does not work yet. Please follow the manual installation steps. 

To install Zource, several steps need to be taken. These steps are not 
complex but are time intensive. Therefor we have created an installation 
script.
 
```bash
curl -s https://raw.githubusercontent.com/zource/zource-installer/master/install.sh | sudo bash
```

## Manual Installation

1. Clone the project and enter its directory.

 ```bash
 git clone https://github.com/zource/zource.git
 cd zource
 ```

2. Install the PHP dependencies:

 ```bash
 composer install --no-dev -o
 ```

3. Install the Node.JS dependencies and run Grunt:

 ```bash
 npm install
 grunt
 ```

4. Setup the database connection and fill in the correct data:

 ```bash
 cp config/autoload/doctrine.orm.global.php config/autoload/doctrine.orm.local.php
 vi config/autoload/doctrine.orm.local.php
 ```

5. Create the database schema:

 ```bash
 php public/index.php orm:schema-tool:create
 ```

6. Create a user account:

 ```bash
 php public/index.php zource:account:create
 Account created with id xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
 ```

7. Create an identity for your account to login with:

 ```bash
 php public/index.php zource:identity:create xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx username AwesomeUser
 ```
 *Note that you can replace `AwesomeUser` with anything you would like as your username.*

8. You're done, visit Zource and login with your credentials.
