# clever-posts
Módulo de criação de posts do CMS da cleverweb.com.br

## Instalação
```
composer require maurolacerda-tech/clever-posts:dev-master
```
```
php artisan migrate
```

## Opcionais
Você poderá públicar os arquivos de visualização padrão em seu diretório views/vendor/Post

```
php artisan vendor:publish --provider="Modules\Posts\Providers\PostServiceProvider" --tag=views
```


Para públicar os arquivos de configurações.

```
php artisan vendor:publish --provider="Modules\Posts\Providers\PostServiceProvider" --tag=config
```

