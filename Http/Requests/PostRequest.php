<?php

namespace Modules\Posts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $method = $this->method();
        if( strtoupper($method)=='POST'){
            return [
                'name'  => 'required|max:191',
                'slug' => "required|max:191|unique:posts,slug",
                'date_publish' => "required|date",
                'media' => "nullable|max:191",
                'status' => "nullable|in:active,inactive", 
                'format' => "nullable|in:image,video,audio",  
                'user_id' => "nullable|numeric",         
                'summary' => "nullable",
                'body' => "nullable",
                'seo_title' => "nullable",
                'meta_description' => "nullable",
                'meta_keywords' => "nullable",
                'menu_id' => "required|numeric"
            ];
        }else{
            $id = $this->request->get('id');
            return [
                'name'  => 'required|max:191',
                'slug' => "required|max:191|unique:posts,slug,{$id},id",
                'date_publish' => "required|date",
                'media' => "nullable|max:191",
                'status' => "nullable|in:active,inactive", 
                'format' => "nullable|in:image,video,audio",  
                'user_id' => "nullable|numeric",         
                'summary' => "nullable",
                'body' => "nullable",
                'seo_title' => "nullable",
                'meta_description' => "nullable",
                'meta_keywords' => "nullable",
                'menu_id' => "required|numeric"
            ];
        }

        
    }
}