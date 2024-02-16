## Sulu configuration
1. Requirements
   1. Sulu needs to have installed a headless extension https://github.com/sulu/SuluHeadlessBundle

2. Webspace configuration.
   1. Example of configuration. Take a look at the `localizations` and the `portals` tag.
```xml
<?xml version="1.0" encoding="utf-8"?>
<webspace xmlns="http://schemas.sulu.io/webspace/webspace"
          xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
          xsi:schemaLocation="http://schemas.sulu.io/webspace/webspace http://schemas.sulu.io/webspace/webspace-1.1.xsd">

    <name>sylius.com</name>
    <key>sylius</key>

    <security permission-check="true">
        <system>sylius</system>
    </security>

    <localizations>
        <localization language="en">
            <localization language="en" country="us"/>
            <localization language="en" country="gb"/>
        </localization>
        <localization language="pl">
            <localization language="pl" country="PL"/>
        </localization>
    </localizations>

    <default-templates>
        <default-template type="home">homepage</default-template>
        <default-template type="page">blog_page</default-template>
    </default-templates>

    <templates>
        <template type="search">search/search</template>
        <template type="error">error/error</template>
    </templates>

    <excluded-templates>
        <excluded-template>overview</excluded-template>
    </excluded-templates>

    <navigation>
        <contexts>
            <context key="main">
                <meta>
                    <title lang="en">Mainnavigation</title>
                    <title lang="pl">Nawigacja</title>
                </meta>
            </context>
            <context key="category">
                <meta>
                    <title lang="en">Category</title>
                    <title lang="pl">Kategorie</title>
                </meta>
            </context>
        </contexts>
    </navigation>

    <resource-locator>
        <strategy>tree_leaf_edit</strategy>
    </resource-locator>

    <portals>
        <portal>
            <name>sylius</name>
            <key>sylius</key>

            <environments>
                <environment type="dev">
                    <urls>
                        <url language="en">{host}/{localization}</url>
                        <url language="en_us">{host}/{localization}</url>
                        <url language="en_us">{host}/en_US</url>
                        <url language="en_us">{host}/en_GB</url>
                        <url language="pl">{host}/{localization}</url>
                        <url language="pl">{host}/pl_PL</url>
                    </urls>
                </environment>
            </environments>
        </portal>
    </portals>
</webspace>
```
In headless bundle, fallback logic not working like it is described in documentation. Example below:
- Webspace with language is defined: 
```xml
    <localization language="en">
        <localization language="en" country="us"/>
        <localization language="en" country="gb"/>
    </localization>
```
and portal for enviroment dev 
```xml
    <environment type="dev">
        <urls>
            <url language="en">{host}/{localization}</url>
            <url language="en_us">{host}/{localization}</url>
            <url language="en_gb">{host}/{localization}</url>
        </urls>
    </environment>
```

- We have page `about_us` in main `en` locale and when we make request for `en`, the page is returned.
- When we make request for page in `en_GB` locale we received 404 instead the `en` fallback.
- To make all requests for `en_GB` locale fallback to the en we have to change  
```xml
    <url language="en_gb">{host}/{localization}</url> 
```
into 
```xml
    <url language="en">{host}/en_GB</url> 
```
- unfortunately its working for all pages with `en_GB` locale but maybe its a way to do it in other way.


3. Page
   1. The basic page created in sulu can be created from properties and blocks.
   2. Like in the documentation said, the page must use the HeadlessWebsiteController
      ```xml
          <controller>Sulu\Bundle\HeadlessBundle\Controller\HeadlessWebsiteController::indexAction</controller>
      ```
    3. Plugins offers the abstract layer to render page with included blocks. But to do that, a renderer class and a template must be provided.

4. Block
   1. Block have declared by users properties and can be included in the page one or many times depending on the needs.
   2. When create a page template, you should use provided twig extensions to include a render all or a one specific block.
