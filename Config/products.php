<?php

return [
    'name' => 'Products',
    'controller' => 'ProductsController',
    'actions' => 'get;index,get;create;create,post;store;store,get;edit;edit/{product},put;update;{product},delete;destroy;{product},post;status;{product}/status,post;user;{product}/user',
    'fields' => 'categories,brand_id,name,slug,media,file,video,more_images,amount,cost,control_stock,stock_quantity,minimum_quantity,weight,length,width,height,bar_code,internal_code,release,sold,status,packing,summary,body,seo_title,meta_description,meta_keywords,menu_id',
    'menu' => true,
    'author' => 'Mauro Lacerda - contato@maurolacerda.com.br',
    'folder' => 'products',
    'resize' => 'peq,150,150;med,480,480'
];