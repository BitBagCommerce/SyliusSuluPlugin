## Installation


1. *We work on stable, supported and up-to-date versions of packages. We recommend you to do the same.*

```bash
$ composer require bitbag/sulu-plugin
```

2. Add plugin dependencies to your `config/bundles.php` file:

```php
return [
    ...
    BitBag\SyliusSuluPlugin\BitBagSyliusSuluPlugin::class => ['all' => true],
];
```

3. Import required config in your `config/packages/_sylius.yaml` file:
```yaml
# config/packages/_sylius.yaml

imports:
    ...
    - { resource: "@BitBagSyliusSuluPlugin/config/config.yaml" }
```

4. Import routing in your `config/routes.yaml` file:

```yaml

# config/routes.yaml
...

bitbag_sylius_sulu_plugin:
    resource: "@BitBagSyliusSuluPlugin/Resources/config/routing.yml"
```

5. Use Channel trait in your channel entity.
```
use BitBag\SyliusSuluPlugin\Entity\SuluChannelConfigurationTrait;

class Channel extends BaseChannel
{

    use SuluChannelConfigurationTrait;
```

5. Finish the installation by updating the database schema

```
$ bin/console cache:clear
$ bin/console doctrine:migrations:diff
$ bin/console doctrine:migrations:migrate
```

## Testing & running the plugin
```bash
$ composer install
$ cd tests/Application
```
Copy file `package.json.~1.XX.0.dist` to `package.json` where `~1.XX.0` is the Sylius version you are using.

```bash
$ cp package.json.~1.12.0.dist package.json
```

```bash
$ yarn install
$ yarn encore dev
$ APP_ENV=test bin/console assets:install
$ APP_ENV=test bin/console doctrine:schema:create
$ APP_ENV=test symfony server:start --port=8080 -d
$ cd ../..
$ open http://localhost:8080
$ vendor/bin/behat
$ vendor/bin/phpspec run
```
