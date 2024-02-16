## Twig functions
Plugins provide a few twig functions which allows to render blocks and pages.

1.Twig extensions methods:

```php
    'bitbag_get_sulu_page(pageUrl)' -> Fetch the page with the specified url from sulu. 
    'bitbag_render_sulu_page(pageUrl)' -> Render the page. It is using the strategy abstraction for rendering.
    'bitbag_render_sulu_blocks(blocks)' -> Render all passed blocks. You can use it when you are sure that you dont need any other html tags.
    'bitbag_render_sulu_blocks_with_type' -> Render blocks with specified type. You can pass a string (or html) which will be added between blocks and at the end
    'bitbag_render_sulu_block_with_type' -> Render one specified block. If is more then one, then only first is rendered
```
