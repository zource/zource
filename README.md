# zource

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

The open source company management application.

## Work In Progress

This application is still work in progress.

## License

Zource is released under a proprietary license.
Please see [License File](LICENSE.md) for more information.

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
 $ git clone https://github.com/zource/zource.git
 $ cd zource
 ```

2. Install the PHP dependencies:

 ```bash
 $ composer install --no-dev -o
 ```

3. Install the Node.JS dependencies, run Bower and run Grunt:

 ```bash
 $ npm install
 $ bower install
 $ grunt
 ```

4. Setup the database connection and fill in the correct data:

 ```bash
 $ cp config/autoload/doctrine.orm.global.php config/autoload/doctrine.orm.local.php
 $ vi config/autoload/doctrine.orm.local.php
 ```

5. Create the database schema:

 ```bash
 $ php public/index.php orm:schema-tool:create
 ```

6. Create a user account:

 ```bash
 $ php public/index.php zource:account:create
 $ Account created with id xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
 ```

7. Create an identity for your account to login with:

 ```bash
 $ php public/index.php zource:identity:create xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx username AwesomeUser
 ```
 *Note that you can replace `AwesomeUser` with anything you would like as your username.*

8. Next create a group with all permissions allowed and add the account to the group

 ```bash
 $ php public/index.php zource:group:create --name=Administrators
 $ Group created with id xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
 $ php public/index.php zource:group:member --add=account-uuid xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
 $ php public/index.php zource:group:permission allow xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
 ```
 
9. You're done, visit Zource and login with your credentials.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Credits

- [All Contributors][link-contributors]

[ico-version]: https://img.shields.io/packagist/v/zource/zource.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-proprietary-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/zource/zource/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/zource/zource.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/zource/zource.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/zource/zource.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/zource/zource
[link-travis]: https://travis-ci.org/zource/zource
[link-scrutinizer]: https://scrutinizer-ci.com/g/zource/zource/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/zource/zource
[link-downloads]: https://packagist.org/packages/zource/zource
[link-contributors]: ../../contributors
