# balpom/href
## Very simple interface for HTTP links with link mapping.

### Href object

Href object implements very simple HrefInterface, which has two methods: link() and mapping().
This may be very useful for any website parsing (like web.archive.org, anonymouse.org, etc.), which work as webproxy and modify original site links.

Simple sample for [http://ipmy.ru/](http://ipmy.ru/), which proxying by [http://web.archive.org/](http://web.archive.org/):
link() method returned *http://ipmy.ru/* string, mapping() method, as variant, returned *http://web.archive.org/web/20230329035950/http://ipmy.ru/* string.

### HrefCollection object

HrefCollection object implements very simple HrefCollectionInterface, which has three methods: getAll(), getByLink(string $uri) and getByMapping(string $uri), and contains collection of unique Href objects.

getAll() method returns array, which contain Href objects.
getByLink($uri) and getByMapping($uri) methods returns Href objects or false, if collection not consist Href object with requested $uri.

### Requirements 
- **PHP >= 8.1**

### Installation
#### Using composer (recommended)
```bash
composer require balpom/href
```

### License
MIT License See [LICENSE.MD](LICENSE.MD)
