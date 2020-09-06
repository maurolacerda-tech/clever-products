<?php

namespace Modules\Posts\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['name','slug','date_publish','media','status','format','user_id','summary','body','seo_title','meta_description','meta_keywords','menu_id'];

    const STATUS = [
        'active' => 'Ativo',
        'inactive' => 'Inativo'
    ];

    const FORMAT = [
        'image' => 'Imagem',
        'video' => 'Vídeo',
        'audio' => 'Áudio'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDatePublishBrAttribute()
    {
        return date('d/m/Y', strtotime($this->date_publish));
    }

}