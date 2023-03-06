# ZuniPHP

### ZuniPHP -> RubricatePHP
the framework turned into components:  
https://rubricate.github.io  
  
### Clone
```
git clone https://github.com/4app/zuniphp.git myproject
```
Define the following requirement in your composer.json file:
```composer
{
    "autoload":{
            "psr-4": {
            "": "app/",
            "Zuni\\": "system/Zuni/"
        }
    }
}
```

create a directory called: "web" (suggested name)
```
$ mkdir web
$ cd web
```

- create a file "web/.htaccess"
- Copy the four lines below and paste in the file ".htaccess":
```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?zuniphp_uri=$1

```
create the "web/index.php" file
```
<?php

$pathRoot = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR;
require $pathRoot . 'vendor/autoload.php';

$app = new Zuni\App();
$app->run();

```

Run:

```
$ cd web
$ php -S localhost:8888
```

In your browser visit: http://localhost:8888


directory tree:
```
myproject/
|___ app/
|___ system/
|___ vendor/
-----|__ autoload.php
|___ web/
---- |___ index.php
---- asset/
---- |__ css/style.css
---- |__ js/script.js
---- |__ img/...
```
