# Getting Started

```php
use Versio\Configuration;
use Versio\HttpMethods;
use Versio\Endpoints\Categories;

$httpClient = new HttpMethods(
    $client,
    $requestFactory,
    $uriFactory, 
    new Configuration($username, $password)
);

$categories = new Categories($httpClient);
```