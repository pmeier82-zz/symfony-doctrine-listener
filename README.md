
# Doctrine LifecycleEvent Listener Boilerplate for debugging

This is a complete boiler plate to test doctrine lifecycle event listeners. I use it to have a buttom up approach to find some configuration issues with my current project.

## 1) Problem Definition

More or less over night my doctrine lifecycle event listeners ceased to work. They are not called at all. After some x-debugging I am reasonable sure there is a reasonable attempt to register them. So it seems my doctrine configs faulty or some other bundle highjacks the default connection event manager.

## 2) The setup

A simple symfony 2standard edition setup with these steps:

  * provide: empty directory, empty mysql-db listener_test

  * curl -sS https://getcomposer.org/installer

  * `./composer.phar create-project symfony/framework-standard-edition test/ 2.3.4

  * fill in parameters

  * verify stuff works by browsing the acme page

  * removing acme bundle and app/console generate:bundle a new one

  * fill in parameters

  * create an entity + crud

  * create a listener class with service declaration

There are two trivial entities with no associations. As easy as can be.

    ITEM(id:int, name:str, shelve_number:int)
    SHELVE(id:int, number:int)

The listener will check if a shelve with `item::shelve_number` exists, and create one if not.

## 3) Incremental steps to reproduce the error

These steps have been taken in order:

### Adding `doctrine/doctrine-fixtures-bundle`

procedure: adding `"doctrine/doctrine-fixtures-bundle": "dev-master"` to `composer.json`.

A data fixture inserting two `Item`s is available. I use this to check if the shelve is created, indicating the listener is working.

STATUS: ok!

### Adding `knplabs/knp-menu-bundle`

procedure: adding `"knplabs/knp-menu-bundle"     : "1.*"` to `composer.json`.

A simple menu for navigation is implemented.

STATUS: ok!

### Adding `knplabs/knp-paginator-bundle`

procedure: adding `"knplabs/knp-paginator-bundle": "2.3.*"` to `composer.json`.

A simple pagination for index crud page is implemented.

STATUS: ok!

### Base classes for entities and controllers

procedure: outsource most of the logic in to abc's, where only parameters and handler methods are left to the implementations.

STATUS: ok!

### Adding `egeloen/google-map-bundle`

procedure: adding `"egeloen/google-map-bundle": "2.*"` to `composer.json`

A dummy gmap with a marker and rect is added to the hompage.

Status: ok!

***

Symfony Standard Edition
========================

Welcome to the Symfony Standard Edition - a fully-functional Symfony2
application that you can use as the skeleton for your new applications.

This document contains information on how to download, install, and start
using Symfony. For a more detailed explanation, see the [Installation][1]
chapter of the Symfony Documentation.

1) Installing the Standard Edition
----------------------------------

When it comes to installing the Symfony Standard Edition, you have the
following options.

### Use Composer (*recommended*)

As Symfony uses [Composer][2] to manage its dependencies, the recommended way
to create a new project is to use it.

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Then, use the `create-project` command to generate a new Symfony application:

    php composer.phar create-project symfony/framework-standard-edition path/to/install

Composer will install Symfony and all its dependencies under the
`path/to/install` directory.

### Download an Archive File

To quickly test Symfony, you can also download an [archive][3] of the Standard
Edition and unpack it somewhere under your web server root directory.

If you downloaded an archive "without vendors", you also need to install all
the necessary dependencies. Download composer (see above) and run the
following command:

    php composer.phar install

2) Checking your System Configuration
-------------------------------------

Before starting coding, make sure that your local system is properly
configured for Symfony.

Execute the `check.php` script from the command line:

    php app/check.php

The script returns a status code of `0` if all mandatory requirements are met,
`1` otherwise.

Access the `config.php` script from a browser:

    http://localhost/path/to/symfony/app/web/config.php

If you get any warnings or recommendations, fix them before moving on.

3) Browsing the Demo Application
--------------------------------

Congratulations! You're now ready to use Symfony.

From the `config.php` page, click the "Bypass configuration and go to the
Welcome page" link to load up your first Symfony page.

You can also use a web-based configurator by clicking on the "Configure your
Symfony Application online" link of the `config.php` page.

To see a real-live Symfony page in action, access the following page:

    web/app_dev.php/demo/hello/Fabien

4) Getting started with Symfony
-------------------------------

This distribution is meant to be the starting point for your Symfony
applications, but it also contains some sample code that you can learn from
and play with.

A great way to start learning Symfony is via the [Quick Tour][4], which will
take you through all the basic features of Symfony2.

Once you're feeling good, you can move onto reading the official
[Symfony2 book][5].

A default bundle, `AcmeDemoBundle`, shows you Symfony2 in action. After
playing with it, you can remove it by following these steps:

  * delete the `src/Acme` directory;

  * remove the routing entry referencing AcmeDemoBundle in `app/config/routing_dev.yml`;

  * remove the AcmeDemoBundle from the registered bundles in `app/AppKernel.php`;

  * remove the `web/bundles/acmedemo` directory;

  * remove the `security.providers`, `security.firewalls.login` and
    `security.firewalls.secured_area` entries in the `security.yml` file or
    tweak the security configuration to fit your needs.

What's inside?
---------------

The Symfony Standard Edition is configured with the following defaults:

  * Twig is the only configured template engine;

  * Doctrine ORM/DBAL is configured;

  * Swiftmailer is configured;

  * Annotations for everything are enabled.

It comes pre-configured with the following bundles:

  * **FrameworkBundle** - The core Symfony framework bundle

  * [**SensioFrameworkExtraBundle**][6] - Adds several enhancements, including
    template and routing annotation capability

  * [**DoctrineBundle**][7] - Adds support for the Doctrine ORM

  * [**TwigBundle**][8] - Adds support for the Twig templating engine

  * [**SecurityBundle**][9] - Adds security by integrating Symfony's security
    component

  * [**SwiftmailerBundle**][10] - Adds support for Swiftmailer, a library for
    sending emails

  * [**MonologBundle**][11] - Adds support for Monolog, a logging library

  * [**AsseticBundle**][12] - Adds support for Assetic, an asset processing
    library

  * **WebProfilerBundle** (in dev/test env) - Adds profiling functionality and
    the web debug toolbar

  * **SensioDistributionBundle** (in dev/test env) - Adds functionality for
    configuring and working with Symfony distributions

  * [**SensioGeneratorBundle**][13] (in dev/test env) - Adds code generation
    capabilities

  * **AcmeDemoBundle** (in dev/test env) - A demo bundle with some example
    code

All libraries and bundles included in the Symfony Standard Edition are
released under the MIT or BSD license.

Enjoy!

[1]:  http://symfony.com/doc/2.3/book/installation.html
[2]:  http://getcomposer.org/
[3]:  http://symfony.com/download
[4]:  http://symfony.com/doc/2.3/quick_tour/the_big_picture.html
[5]:  http://symfony.com/doc/2.3/index.html
[6]:  http://symfony.com/doc/2.3/bundles/SensioFrameworkExtraBundle/index.html
[7]:  http://symfony.com/doc/2.3/book/doctrine.html
[8]:  http://symfony.com/doc/2.3/book/templating.html
[9]:  http://symfony.com/doc/2.3/book/security.html
[10]: http://symfony.com/doc/2.3/cookbook/email.html
[11]: http://symfony.com/doc/2.3/cookbook/logging/monolog.html
[12]: http://symfony.com/doc/2.3/cookbook/assetic/asset_management.html
[13]: http://symfony.com/doc/2.3/bundles/SensioGeneratorBundle/index.html
