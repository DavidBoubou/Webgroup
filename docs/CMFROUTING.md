# Symfony CMF (Dangereux)
https://symfony.com/bundles/CMFRoutingBundle/current/quick_tour/the_big_picture.html#final-thoughts
https://symfony.com/bundles/CMFRoutingBundle/current/quick_tour/the_router.html
https://symfony.com/bundles/CMFRoutingBundle/current/quick_tour/the_model.html


## CMFRoutingBundle ****************
Symfony bundle to provide the CMF chain router to handle multiple routers, and the dynamic router to load routes from a database or other sources

## Context
Fournit deux routes pour symfony: les routes dynamique stocké dans les base de données et les routes compilé par Symfony.
Symfony CMF est une collection de bundles lequel fournit des fonctionnalité commune  que l'on a besoin quand on construit un CMS avec la framework symfony.
Faire une application symfony avec des composant CMS.
hen choosing to use a framework, you need to spend much time creating CMS features for the project. On the other hand, when choosing to use a CMS, it's more difficult to build custom application functionality. It is impossible or at least very hard to customize the core parts of the CMS.
Utilise PHP 5

>>> composer.json
{
"name": "symfony/framework-standard-edition",
"license": "MIT",
"type": "project",
"description": "The \"Symfony Standard Edition\" distribution",
"autoload": {
    "psr-0": { "": "src/", "SymfonyStandard": "app/" }
},
"minimum-stability": "dev",
"prefer-stable": true,
"require": {
    "php": ">=5.3.3",
    "symfony-cmf/menu-bundle": "1.0.*@beta",
    "doctrine/phpcr-bundle": "1.0.*@beta",
    "phpcr/phpcr": "2.1.*@beta",
    "phpcr/phpcr-utils": "1.0.*@beta",
    "phpcr/phpcr-implementation": "2.1.*@beta",
    "doctrine/phpcr-odm": "1.0.*@beta",
    "doctrine/common": "2.4.*@dev",
    "symfony-cmf/core-bundle": "1.0.*@beta",
    "jackalope/jackalope-doctrine-dbal": "1.0.*@beta",
    "symfony/symfony": "2.5.*",
    "doctrine/orm": "~2.2,>=2.2.3",
    "doctrine/doctrine-bundle": "~1.2",
    "twig/extensions": "~1.0",
    "symfony/assetic-bundle": "~2.3",
    "symfony/swiftmailer-bundle": "~2.3",
    "symfony/monolog-bundle": "~2.4",
    "sensio/distribution-bundle": "~3.0",
    "sensio/framework-extra-bundle": "~3.0",
    "incenteev/composer-parameter-handler": "~2.0",
    "zendesk/zendesk_api_client_php": "dev-master",
    "guzzlehttp/guzzle": "~6.0",
    "knplabs/knp-paginator-bundle": "^2.5",
    "seegno/bootstrap-bundle": "dev-master",
    "symfony/filesystem": "^2.8",
    "liip/search-bundle": "^1.0",
    "symfony-cmf/menu-bundle": "1.0.*@beta",
    "doctrine/phpcr-bundle": "*",
    "phpcr/phpcr": "2.1.*@beta",
    "phpcr/phpcr-utils": "1.0.*@beta",
    "phpcr/phpcr-implementation": "*",
    "doctrine/phpcr-odm": "1.0.*@beta",
    "doctrine/common": "2.4.*@dev",
    "symfony-cmf/core-bundle": "1.0.*@beta",
    "jackalope/jackalope-doctrine-dbal": "1.0.*@beta"
},
"require-dev": {
    "sensio/generator-bundle": "~2.3"
},
"scripts": {
    "post-root-package-install": [
        "SymfonyStandard\\Composer::hookRootPackageInstall"
    ],
    "post-install-cmd": [
        "Incenteev\\ParameterHandler\\ScriptHandler::buildParameters",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::buildBootstrap",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::clearCache",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installAssets",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installRequirementsFile",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::removeSymfonyStandardFiles"
    ],
    "post-update-cmd": [
        "Incenteev\\ParameterHandler\\ScriptHandler::buildParameters",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::buildBootstrap",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::clearCache",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installAssets",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installRequirementsFile",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::removeSymfonyStandardFiles"
    ]
},
"config": {
    "bin-dir": "bin"
},
"extra": {
    "symfony-app-dir": "app",
    "symfony-web-dir": "web",
    "incenteev-parameters": {
        "file": "app/config/parameters.yml"
    },
    "branch-alias": {
        "dev-master": "2.5-dev"
    }
}}


## Symfony CMF Sandbox
 composer create-project symfony-cmf/sandbox cmf-sandbox
### Setting up the database
- enabled the sqlite PHP extension
$ cd cmf-sandbox
$ cp app/config/phpcr_doctrine_dbal.yml.dist app/config/phpcr.yml
    # Or when you're on a Windows PC:
    # $ copy app\config\phpcr_doctrine_dbal.yml.dist app\config\phpcr.yml
$ php bin/console doctrine:database:create
$ php bin/console doctrine:phpcr:init:dbal --force
$ php bin/console doctrine:phpcr:repository:init
$ php bin/console doctrine:phpcr:fixtures:load -n
