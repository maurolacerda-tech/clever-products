{{ Form::hidden('menu_id', $menu_id) }}
<input type="hidden" name="image_remove" id="image_remove">

<div class="row">
    <div class="col-sm-8">
        <div class="card table-card"> 
            <div class="card-body">

                @isset ($combine_filds['name'])
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('name', $combine_filds['name']) }}
                            {{ Form::text('name', null, ['class' => $errors->has('name') ?  'form-control is-invalid' : 'form-control', 'onkeyup' => "slugGenerate(this,'Modules\\\Products\\\Models\\\Product')"]) }}
                            @include('admin.partials._help_block',['field' => 'name'])
                        </div>
                    </div>
                </div>
                @endisset

                @isset ($combine_filds['media'])
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('media', $combine_filds['media']) }}
                            <input type="file" name="media" class="dropify" @if(isset($product->media)) data-default-file="{{ url("storage/products/".$product->media) }}"@endif data-height="150" data-max-file-size="4M" data-allowed-file-extensions="jpg png jpeg gif"  />
                        </div>
                    </div>
                </div>
                @endisset

                @isset ($combine_filds['file'])
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('file', $combine_filds['file']) }}
                            <input type="file" name="file" class="dropify" @if(isset($product->file)) data-default-file="{{ url("storage/products/".$product->file) }}"@endif data-height="150" data-max-file-size="12M" data-allowed-file-extensions="jpg png jpeg gif pdf doc docx xls xlsx"  />
                        </div>
                    </div>
                </div>
                @endisset

                @isset ($combine_filds['video'])
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('video', $combine_filds['video']) }}
                            {{ Form::text('video', null, ['class' => $errors->has('video') ?  'form-control is-invalid' : 'form-control', 'onkeyup' => "slugGenerate(this,'Modules\\\Products\\\Models\\\Product')"]) }}
                            @include('admin.partials._help_block',['field' => 'video'])
                        </div>
                    </div>
                </div>
                @endisset

                
                <div class="row">
                    @isset ($combine_filds['bar_code'])
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('bar_code', $combine_filds['bar_code']) }}
                            {{ Form::text('bar_code', null, ['class' => $errors->has('bar_code') ?  'form-control is-invalid' : 'form-control']) }}
                            @include('admin.partials._help_block',['field' => 'bar_code'])
                        </div>
                    </div>
                    @endisset
                    @isset ($combine_filds['internal_code'])
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('internal_code', $combine_filds['internal_code']) }}
                            {{ Form::text('internal_code', null, ['class' => $errors->has('internal_code') ?  'form-control is-invalid' : 'form-control', 'onkeyup' => "slugGenerate(this,'Modules\\\Posts\\\Models\\\Post')"]) }}
                            @include('admin.partials._help_block',['field' => 'internal_code'])
                        </div>
                    </div>
                    @endisset
                </div>
                
                @isset ($combine_filds['summary'])
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('summary', $combine_filds['summary']) }}
                            {{ Form::textarea('summary', null, ['class' => $errors->has('summary') ?  'form-control is-invalid' : 'form-control']) }}
                            @include('admin.partials._help_block',['field' => 'summary'])
                        </div>
                    </div>
                </div>
                @endisset
            
                @isset ($combine_filds['body'])
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('body', $combine_filds['body']) }}
                            {{ Form::textarea('body', null, ['class' => $errors->has('body') ?  'form-control is-invalid html-editor' : 'form-control html-editor']) }}
                            @include('admin.partials._help_block',['field' => 'body'])
                        </div>
                    </div>
                </div>
                @endisset
            
                @if (isset($combine_filds['slug']) || isset($combine_filds['seo_title']) || isset($combine_filds['meta_description']) || isset($combine_filds['meta_keywords']) )
                <h6>Meta Tags</h6>
                <div class="row">
                    @isset ($combine_filds['slug'])
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('slug', $combine_filds['slug'], ['class' => 'form-label']) }} 
                            {{ Form::text('slug', null, ['class' => $errors->has('slug') ?  'form-control is-invalid' : 'form-control']) }}                            
                            @include('admin.partials._help_block',['field' => 'slug'])
                        </div>
                    </div>
                    @endisset
            
                    @isset ($combine_filds['seo_title'])                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('seo_title', $combine_filds['seo_title']) }} 
                            {{ Form::text('seo_title', null, ['class' => $errors->has('seo_title') ?  'form-control is-invalid' : 'form-control']) }}
                            @include('admin.partials._help_block',['field' => 'seo_title'])
                        </div>
                    </div>
                    @endisset
            
                </div>
            
                @isset ($combine_filds['meta_description'])
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('meta_description', $combine_filds['meta_description']) }} 
                            {{ Form::text('meta_description', null, ['class' => $errors->has('meta_description') ?  'form-control is-invalid' : 'form-control']) }}
                            @include('admin.partials._help_block',['field' => 'meta_description'])
                        </div>
                    </div>
                </div>
                @endisset
            
                @isset ($combine_filds['meta_keywords'])
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('meta_keywords', $combine_filds['meta_keywords']) }} <p>Para adicionar o próximo item use a tecla <code>enter</code> ou <code>,</code> </p>
                            {{ Form::text('meta_keywords', null, ['class' => $errors->has('meta_keywords') ?  'form-control tags is-invalid ' : 'form-control tags']) }}
                            @include('admin.partials._help_block',['field' => 'meta_keywords'])
                        </div>
                    </div>
                </div>
                @endisset
                @endif
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card table-card"> 
            <div class="card-body">                
                <button type="submit" class="btn2 btn-dark">Salvar</button>
                <a href="{{ url('/panel/'.$slug) }}" class="text-orange pull-right">Cancelar</a>
            </div>
        </div>

        <div class="card table-card"> 
            <div class="card-body">

                <div class="row">
                    @isset ($combine_filds['status'])
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('status', $combine_filds['status']) }}
                            {{
                                Form::select('status',$status_list,null,['class' => $errors->has('status') ?  'select2 form-control is-invalid' : 'select2 form-control'])
                            }}
                            @include('admin.partials._help_block',['field' => 'status'])
                        </div>
                    </div>
                    @endisset
                    @isset ($combine_filds['control_stock'])
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('control_stock', $combine_filds['control_stock'],['class'=>'d-block']) }}
                            {{ Form::checkbox('control_stock',1,null,['class'=>"js-status"]) }}
                        </div>
                    </div>
                    @endisset
                </div>

                <div class="row">
                    @isset ($combine_filds['stock_quantity'])
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('stock_quantity', $combine_filds['stock_quantity']) }}
                            {{ Form::number('stock_quantity', null, ['class' => $errors->has('stock_quantity') ?  'form-control is-invalid' : 'form-control']) }}
                            @include('admin.partials._help_block',['field' => 'stock_quantity'])
                        </div>
                    </div>
                    @endisset

                    @isset ($combine_filds['minimum_quantity'])
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('minimum_quantity', 'Mínimo em estoque') }}
                            {{ Form::number('minimum_quantity', null, ['class' => $errors->has('minimum_quantity') ?  'form-control is-invalid' : 'form-control']) }}
                            @include('admin.partials._help_block',['field' => 'minimum_quantity'])
                        </div>
                    </div>
                    @endisset
                </div>

                <div class="row">
                    @isset ($combine_filds['amount'])
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('amount', $combine_filds['amount']) }}
                            {{ Form::text('amount', null, ['class' => $errors->has('amount') ?  'form-control is-invalid money_pt-br' : 'form-control money_pt-br']) }}
                            @include('admin.partials._help_block',['field' => 'amount'])
                        </div>
                    </div>
                    @endisset

                    @isset ($combine_filds['cost'])
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('cost', $combine_filds['cost']) }}
                            {{ Form::text('cost', null, ['class' => $errors->has('cost') ?  'form-control is-invalid money_pt-br' : 'form-control money_pt-br']) }}
                            @include('admin.partials._help_block',['field' => 'cost'])
                        </div>
                    </div>
                    @endisset

                </div>

                @isset ($combine_filds['release'])
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('release', $combine_filds['release']) }}
                            {{ Form::date('release', null,['class' => $errors->has('release') ?  'form-control is-invalid' : 'form-control'])}}
                            @include('admin.partials._help_block',['field' => 'release'])
                        </div>
                    </div>
                </div>
                @endisset

                @isset ($combine_filds['categories'])
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('categories', $combine_filds['categories']) }}
                            {{
                                Form::select('categories', $categories_list,$categories_selected,['class' => $errors->has('categories') ?  'select2 form-control is-invalid' : 'select2 form-control', 'multiple' => 'multiple', 'name' => 'categories[]'])
                            }}
                            @include('admin.partials._help_block',['field' => 'categories'])
                        </div>
                    </div>
                </div>
                @endisset

                @isset ($combine_filds['brand_id'])
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('brand_id', $combine_filds['brand_id']) }}
                            {{
                                Form::select('brand_id', $brands_list,null,['class' => $errors->has('brand_id') ?  'select2 form-control is-invalid' : 'select2 form-control'])
                            }}
                            @include('admin.partials._help_block',['field' => 'brand_id'])
                        </div>
                    </div>
                </div>
                @endisset

                @isset ($combine_filds['packing'])
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('packing', $combine_filds['packing']) }}
                            {{
                                Form::select('packing', $packing_list,null,['class' => $errors->has('packing') ?  'select2 form-control is-invalid' : 'select2 form-control'])
                            }}
                            @include('admin.partials._help_block',['field' => 'packing'])
                        </div>
                    </div>
                </div>
                @endisset

                <div class="row">
                    @isset ($combine_filds['weight'])
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('weight', $combine_filds['weight']) }}
                            {{Form::select('weight', config('delivery.weight'),null,['class' => $errors->has('weight') ?  'form-control is-invalid' : 'form-control'])}}
                            @include('admin.partials._help_block',['field' => 'weight'])
                        </div>
                    </div>
                    @endisset

                    @isset ($combine_filds['length'])
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('length', $combine_filds['length']) }}
                            {{ Form::number('length', null, ['class' => $errors->has('length') ?  'form-control is-invalid' : 'form-control', 'onkeyup' => "slugGenerate(this,'Modules\\\Posts\\\Models\\\Post')"]) }}
                            @include('admin.partials._help_block',['field' => 'length'])
                        </div>
                    </div>
                    @endisset

                </div>
                <div class="row">
                    @isset ($combine_filds['width'])
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('width', $combine_filds['width']) }}
                            {{ Form::number('width', null, ['class' => $errors->has('width') ?  'form-control is-invalid' : 'form-control']) }}
                            @include('admin.partials._help_block',['field' => 'width'])
                        </div>
                    </div>
                    @endisset

                    @isset ($combine_filds['height'])
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('height', $combine_filds['height']) }}
                            {{ Form::number('height', null, ['class' => $errors->has('height') ?  'form-control is-invalid' : 'form-control', 'onkeyup' => "slugGenerate(this,'Modules\\\Posts\\\Models\\\Post')"]) }}
                            @include('admin.partials._help_block',['field' => 'height'])
                        </div>
                    </div>
                    @endisset

                </div>

                @isset ($combine_filds['more_images'])
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {{ Form::label('more_images', $combine_filds['more_images']) }}
                                <input type="file" name="more_images[]" class="multiple_images" multiple="multiple"  />
                            </div>
                        </div>
                    </div>
                @endisset

            </div>
        </div>
    </div>
</div>





    




