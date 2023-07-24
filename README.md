# Projet InoVin de Cédric Boriat 

### Application to determine users' wine tasting profile.

### Logged-in users complete tasting sheets.
### They discover their tasting profile determined by the application.


## members :
- Aurélie Lozach
- Youssouf Soudjay Abdulkader
- Rémi Meslin
- David Gibon
- Nicolas Palay


### Prerequisites

1. Check composer is installed
2. Check yarn & node are installed

### for start the Projet :
- create .env.local and add your database (mettre un sdn pour l'envoie d'email)
- composer install
- yarn install
- yarn encore dev
- symfony console doctrine:database:create
- symfony console make:migration
- symfony console doctrine:migrations:migrate
- symfony console doctrine:fixtures:load
- symfony server:start
  Run `yarn run dev --watch`

### starting Tasting :
1. login admin
   - email : admin@inovin.fr
   - mp : password
2. create atelier in /admin :
   - name : atelier 1
   - date : 2021-06-01
   - create number atelier ex : 202106011
   - time : 10:00:00
   - where : 1 rue de la paix
   - select 4 wines
3. deconnexion
4. create user in /register   
5. register gout
6. enter in atelier width code workshop
7. start tasting


## Presentation

This starter kit is here to easily start a repository for Wild Code School students.

It's symfony website-skeleton project with some additional library (webpack, fixtures) and tools to validate code standards.

* GrumPHP, as pre-commit hook, will run 2 tools when `git commit` is run :

    * PHP_CodeSniffer to check PSR12
    * PHPStan focuses on finding errors in your code (without actually running it)
    * PHPmd will check if you follow PHP best practices

  If tests fail, the commit is canceled and a warning message is displayed to developper.

* Github Action as Continuous Integration will be run when a branch with active pull request is updated on github. It will run :

    * Tasks to check if vendor, .idea, env.local are not versionned,
    * PHP_CodeSniffer, PHPStan and PHPmd with same configuration as GrumPHP.



### Testing

1. Run `php ./vendor/bin/phpcs` to launch PHP code sniffer
2. Run `php ./vendor/bin/phpstan analyse src --level max` to launch PHPStan
3. Run `php ./vendor/bin/phpmd src text phpmd.xml` to launch PHP Mess Detector
4. Run `./node_modules/.bin/eslint assets/js` to launch ESLint JS linter

### Windows Users

If you develop on Windows, you should edit you git configuration to change your end of line rules with this command:

`git config --global core.autocrlf true`

The `.editorconfig` file in root directory do this for you. You probably need `EditorConfig` extension if your IDE is VSCode.


## Deployment

Some files are used to manage automatic deployments (using tools as Caprover, Docker and Github Action). Please do not modify them.

* [docker-entry.sh](/docker-entry.sh) shell instruction to execute when docker image is built
* [nginx.conf](/ginx.conf) Nginx server configuration
* [php.ini](/php.ini) Php configuration


## Built With

* [Symfony](https://github.com/symfony/symfony)
* [GrumPHP](https://github.com/phpro/grumphp)
* [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
* [PHPStan](https://github.com/phpstan/phpstan)
* [PHPMD](http://phpmd.org)
* [ESLint](https://eslint.org/)
* [Sass-Lint](https://github.com/sasstools/sass-lint)



## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning


## Authors

Wild Code School trainers team

## License

MIT License

Copyright (c) 2019 aurelien@wildcodeschool.fr

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

## Acknowledgments

