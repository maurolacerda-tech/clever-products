<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'menu_id',
        'brand_id',
        'name',
        'slug',
        'media',
        'file',
        'video',
        'more_images',
        'amount',
        'cost',
        'control_stock',
        'stock_quantity',
        'minimum_quantity',
        'weight',
        'length',
        'width',
        'height',
        'bar_code',
        'internal_code',
        'release',
        'sold',
        'status',
        'packing',
        'summary',
        'body',
        'seo_title',
        'meta_description',
        'meta_keywords'
    ];

    const STATUS = [
        'active' => 'Ativo',
        'on_request' => 'Sob-Consulta',
        'inactive' => 'Inativo'
    ];

    const PACKING = [
        'caixa' => 'Caixa',
        'rolo' => 'Rolo',
        'envelope' => 'Envelope'
    ];

    public function categories()
    {
        return $this->belongsToMany(\Modules\Categories\Models\Category::class);
    }
 
    public function getDatePublishBrAttribute()
    {
        return date('d/m/Y', strtotime($this->date_publish));
    }
    
    public function setAmountAttribute($value)
    {    
        if(!is_null($value))   
            $this->attributes['amount'] = \Functions::_moedaDb($value);
        else
            $this->attributes['amount'] = null;
    }

    public function setCostAttribute($value)
    {        
        if(!is_null($value))
            $this->attributes['cost'] = \Functions::_moedaDb($value);
        else
            $this->attributes['cost'] = null;
    }

    public function setMoreImagesAttribute($value)
    {
        if(substr($value, -1) == ',')   
            $this->attributes['more_images'] = substr($value, 0, -1);
        else
            $this->attributes['more_images'] = $value;

    }

    public function getMoreImagesJsonAttribute()
    {
        $more_images = $this->more_images;
        if(!is_null($more_images)){
            $more_images_json = '';
            $more_images_array = explode(',',$more_images);
            foreach($more_images_array as $more_images_item){
                if(!empty($more_images_item)){
                    
                    $path = "storage/products/".$more_images_item;
                    $path_image = url($path);
                    $extension = pathinfo($path)['extension'];
                    
                    $data_image = getimagesize(storage_path('app/public/products/'.$more_images_item));
                    $mime = $data_image['mime'];
                    //dd($data_image);
                    if($more_images_json!=''){
                        $more_images_json .= ',{
                            name: "'.$more_images_item.'",
                            file: "'.$path_image.'",
                            type: "image/jpg"
                        }';
                    }else{
                        $more_images_json = '{
                            name: "'.$more_images_item.'",
                            file: "'.$path_image.'",
                            type: "image/jpg"
                        }';
                    }
                }
            }
            return '['.$more_images_json.']';
        }else{
            return '';
        }
    }
}