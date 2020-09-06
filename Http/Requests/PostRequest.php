<?php

namespace Modules\Services\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'  => 'required|max:191',
            'slug' => "required|max:191",
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