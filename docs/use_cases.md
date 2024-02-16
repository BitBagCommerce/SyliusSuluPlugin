## Use cases:

1. Adding page.
   1. After creating new page type in the sulu e.g page with type `about_us` you have to do a few things to handle this type.
      1. Create a new renderer class which implements `\BitBag\SyliusSuluPlugin\Renderer\Page\SuluPageRenderStrategyInterface`
      2. Register new class as a service with tag `bitbag.sylius_sulu_plugin.strategy.page_renderer`
      3. Add new template in correct catalog like you configured in the `getTemplate()` method. This template probably will be a copy from the sulu.
      4. Choosing a correct renderer is based on the strategy pattern, so make sure that your template code is unique.

1. Adding Block
   1. Page can be created from the blocks, each block can contains other properties, so we also use a strategy pattern to the block rendering. To add a new block follow the next steps:
       1. Create a new renderer class which implements `\BitBag\SyliusSuluPlugin\Renderer\Block\SuluBlockRenderStrategyInterface`
       2. Register new class as a service with tag `bitbag.sylius_sulu_plugin.strategy.block_renderer`
       3. Add new template in correct catalog like you configured in the `getTemplate()` method. This template probably will be a copy from the sulu.
       4. Choosing a correct renderer is based on the strategy pattern, so make sure that your block code is unique.
       5. In page use a twig extension method to render a block by its type. If everything is correctly configured then block should be displayed in the page. 
