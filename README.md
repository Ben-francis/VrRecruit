Vreasy Task's confirmation
==========================

Introduction
------------

Welcome! We’ve created this project hoping that will help us nto getting a feeling of how you work. If anything is unclear, please do not hesitate to contact us with questions! (<mailto:mauro@vreasy.com>)

At Vreasy we work with several technologies. At the web-application level, we currently use PHP ([ZF1](https://github.com/zendframework/zf1)), [AngularJS](http://angularjs.org/) and a bit of [jQuery](http://jquery.com/).
We are working into moving our software into SOA approach. So we build thin json APIs and we run most of what the user sees in the client side.

You can find the briefing for this task in [The Vreasy Developer’s Quiz document](https://docs.google.com/document/d/19kYCiaYKmg6AqUn2ckrFZd9VGLudOrmlcXpIZ2Vz8yQ/edit?usp=sharing)

Getting started
---------------
1. Setup project dependencies:
    1. php >= 5.4,
    1. Apache Server >= 2.4
    1. MySQL >= 5.4
    1. npm Package manager
    1. composer Dependency Manager for PHP
2. Clone this branch of the project

    ```
    git clone -b task-confirmation https://github.com/Vreasy/VrRecruit.git
    ```
3. [Install composer](http://getcomposer.org/doc/00-intro.md) and projects dependencies

    ```
    composer install --dev
    ```
4. Create the database and setup the db user permissions (See the [db.ini](blob/master/task-confirmation/application/configs/db.ini)).
    4. DB User: ```vreasy```
    4. DB Password: ```;FeA336101-vreasy_task_confirmation```
    4. Development db ```vreasy_task_confirmation```
    4. Test db ```vreasy_task_confirmation_test```
5. Run [ruckusing](https://github.com/ruckus/ruckusing-migrations) migrations

    ```
    php vendor/ruckusing/ruckusing-migrations/ruckus.php db:migrate
    php vendor/ruckusing/ruckusing-migrations/ruckus.php db:migrate ENV=test
    ```
6. Install npm and client side dependencies

    ```
    npm install
    node_modules/bower/bin/bower install
    ```
7. Check the test suite is working for you:

    ```
    php vendor/codeception/codeception/codecept build
    php vendor/codeception/codeception/codecept run --debug
    ```
    It should output something like ```OK (2 tests, 4 assertions)```
Help
----

Do you have any questions? Ask Mauro (<mailto:mauro@vreasy.com>)