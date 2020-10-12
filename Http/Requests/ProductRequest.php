<?php

namespace Modules\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Products\Models\Product;

class ProductRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $status = implode(',',array_keys(Product::STATUS));
        $packing = implode(',',array_keys(Product::PACKING));

        $method = $this->method();
        if( strtoupper($method)=='POST'){
            return [
                'menu_id' => "required|numeric",
                'brand_id' => "nullable|numeric",
                'name'  => 'required|max:191',
                'slug' => "required|max:191|unique:products,slug",               
                'media' => "nullable",
                'file' => "nullable",
                'video' => "nullable",
                'more_images' => "nullable",
                'amount' => "nullable",
                'cost' => "nullable",
                'control_stock' => "nullable",
                'stock_quantity' => "nullable|numeric",            
                'minimum_quantity' => "nullable|numeric",
                'weight' => "nullable",
                'length' => "nullable", 
                'width' => "nullable",
                'height' => "nullable",                 
                'bar_code' => "nullable",
                'internal_code' => "nullable",
                'release' => "nullable|date",
                'sold' => "nullable|numeric",
                'status' => "nullable|in:$status",
                'packing' => "nullable|in:$packing",
                'summary' => "nullable",
                'body' => "nullable",
                'seo_title' => "nullable",
                'meta_description' => "nullable",
                'meta_keywords' => "nullable"
            ];
        }else{
            $id = $this->request->get('id');
            return [
                'menu_id' => "required|numeric",
                'brand_id' => "nullable|numeric",
                'name'  => 'required|max:191',
                'slug' => "required|max:191|unique:products,slug,{$id},id",
                'media' => "nullable",
                'file' => "nullable",
                'video' => "nullable",
                'more_images' => "nullable",
                'amount' => "nullable",
                'cost' => "nullable",
                'control_stock' => "nullable",
                'stock_quantity' => "nullable|numeric",            
                'minimum_quantity' => "nullable|numeric",
                'weight' => "nullable",
                'length' => "nullable", 
                'width' => "nullable",
                'height' => "nullable",                 
                'bar_code' => "nullable",
                'internal_code' => "nullable",
                'release' => "nullable|date",
                'sold' => "nullable|numeric",
                'status' => "nullable|in:$status",
                'packing' => "nullable|in:$packing",
                'summary' => "nullable",
                'body' => "nullable",
                'seo_title' => "nullable",
                'meta_description' => "nullable",
                'meta_keywords' => "nullable"
            ];
        }

        
    }
}