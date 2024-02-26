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

6. Implement `\BitBag\SyliusSuluPlugin\Entity\ChannelInterface`


7. Add doctrine mapping. Choose xml, attributes or annotations, depending what you use on project.

Xml
```xml
<?xml version="1.0" encoding="UTF-8"?>

<doctrine-mapping
    xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                            http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd"
>
    <entity name="App\Entity\Channel\Channel" table="sylius_channel">
        <field name="suluUseLocalizedUrls" column="sulu_use_localized_url" type="boolean"/>
    </entity>
</doctrine-mapping>

```

Attributes or Annotations
```php

/**
 * @ORM\Entity
 * @ORM\Table(name='sylius_channel')
 */
#[ORM\Entity]
#[ORM\Table(name: 'sylius_channel')]
class Channel extends BaseChannel
{

    use SuluChannelConfigurationTrait;

    /** @ORM\Column(type='boolean', nullable=false name='sulu_use_localized_url') */
    #[ORM\Column(type: 'boolean', nullable: false, name: 'sulu_use_localized_url')]
    protected bool $suluUseLocalizedUrls = false;
}

```

8. Finish the installation by updating the database schema

```
$ bin/console cache:clear
$ bin/console doctrine:migrations:diff
$ bin/console doctrine:migrations:migrate
```

## Testing & running the plugin
```bash
$ composer install
$ cd tests/Application

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
