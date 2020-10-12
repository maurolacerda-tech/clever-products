# clever-products
Módulo de criação de produtos do CMS da cleverweb.com.br

## Instalação
```
composer require maurolacerda-tech/clever-products:dev-master
```
```
php artisan migrate
```

## Opcionais
Você poderá públicar os arquivos de visualização padrão em seu diretório views/vendor/Product

```
php artisan vendor:publish --provider="Modules\Products\Providers\ProductServiceProvider" --tag=views
```


Para públicar os arquivos de configurações.

```
php artisan vendor:publish --provider="Modules\Products\Providers\ProductServiceProvider" --tag=config
```

