## Page caching

1. The cache mechanizm is realized by use of symfony caching http client https://symfony.com/doc/current/http_client.html#caching-requests-and-responses. 
Responses from sulu are caching per sylius channel and could be invalidate per channel. Cache purging is available in channel grid.
Cache catalog is defined as app parameter `bitbag.sulu_cache_dir:  "%kernel.cache_dir%/sulu"`, you can override it as well. 
Additionally cache is grouped by locale e.g: `var/cache/dev/sulu/en_US/...` 


2. Global sulu settings for cache ttl

```yaml
parameters:
  sulu_http_cache.cache.max_age: 46204
  sulu_http_cache.cache.shared_max_age: 46204
```
If you use custom controller in sulu then you can override global cache ttl.

3. If you need possibility to invalidate cache per request (per page), you can add button in sulu admin panel and implement similar solution like this:
https://symfony.com/doc/current/http_cache/cache_invalidation.html

4. By default http_cache on dev is enabled by this plugin, if you need change this, override 
```yaml
 when@dev:
     framework:
         http_cache: false
```
