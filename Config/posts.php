<?php

return [
    'name' => 'Posts',
    'controller' => 'PostsController',
    'actions' => 'get;index,get;create;create,post;store;store,get;edit;edit/{post},put;update;{post},delete;destroy;{post},post;status;{post}/status,post;user;{post}/user',
    'fields' => 'name,slug,date_publish,media,status,format,user_id,summary,body,seo_title,meta_description,meta_keywords,menu_id',
    'menu' => true,
    'author' => 'Mauro Lacerda - contato@maurolacerda.com.br',
    'folder' => 'posts'
];