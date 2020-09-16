{{ Form::hidden('menu_id', $menu_id) }}


<div class="row">
    <div class="col-sm-8">
        <div class="card table-card"> 
            <div class="card-body">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('media', 'Upload') }}
                            <input type="file" name="media" class="dropify" @if(isset($post->media)) data-default-file="{{ url("storage/posts/".$post->media) }}"@endif data-height="150" data-max-file-size="12M" data-allowed-file-extensions="jpg png jpeg gif mp3 mp4 wmv"  />
                        </div>
                    </div>
                </div>            
            
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('name', 'Título') }}
                            {{ Form::text('name', null, ['class' => $errors->has('name') ?  'form-control is-invalid' : 'form-control', 'onkeyup' => "slugGenerate(this,'Modules\\\Posts\\\Models\\\Post')"]) }}
                            @include('admin.partials._help_block',['field' => 'name'])
                        </div>
                    </div>
                </div>            
            
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('summary', 'Resumo') }}
                            {{ Form::textarea('summary', null, ['class' => $errors->has('summary') ?  'form-control is-invalid' : 'form-control']) }}
                            @include('admin.partials._help_block',['field' => 'summary'])
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('body', 'Descrição') }}
                            {{ Form::textarea('body', null, ['class' => $errors->has('body') ?  'form-control is-invalid html-editor' : 'form-control html-editor']) }}
                            @include('admin.partials._help_block',['field' => 'body'])
                        </div>
                    </div>
                </div>
            
                <h6>Meta Tags</h6>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('slug', 'URL Amigável', ['class' => 'form-label']) }} 
                            {{ Form::text('slug', null, ['class' => $errors->has('slug') ?  'form-control is-invalid' : 'form-control']) }}                            
                            @include('admin.partials._help_block',['field' => 'slug'])
                        </div>
                    </div>
            
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('seo_title', 'SEO Title') }} 
                            {{ Form::text('seo_title', null, ['class' => $errors->has('seo_title') ?  'form-control is-invalid' : 'form-control']) }}
                            @include('admin.partials._help_block',['field' => 'seo_title'])
                        </div>
                    </div>
            
                </div>
            
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('meta_description', 'Meta Description') }} 
                            {{ Form::text('meta_description', null, ['class' => $errors->has('meta_description') ?  'form-control is-invalid' : 'form-control']) }}
                            @include('admin.partials._help_block',['field' => 'meta_description'])
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('meta_keywords', 'Meta Keywords') }} <p>Para adicionar o próximo item use a tecla <code>enter</code> ou <code>,</code> </p>
                            {{ Form::text('meta_keywords', null, ['class' => $errors->has('meta_keywords') ?  'form-control tags is-invalid ' : 'form-control tags']) }}
                            @include('admin.partials._help_block',['field' => 'meta_keywords'])
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card table-card"> 
            <div class="card-body">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('status', 'Status') }}
                            {{
                                Form::select('status',$status_list,null,['class' => $errors->has('status') ?  'select2 form-control is-invalid' : 'select2 form-control'])
                            }}
                            @include('admin.partials._help_block',['field' => 'status'])
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('date_publish', 'Data de Públicação') }}<span class="text-danger">*</span>
                            {{ Form::date('date_publish', null,['class' => $errors->has('date_publish') ?  'form-control is-invalid' : 'form-control'])}}
                            @include('admin.partials._help_block',['field' => 'date_publish'])
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('categories', 'Categorias') }}
                            {{
                                Form::select('categories', $categories_list,$categories_selected,['class' => $errors->has('categories') ?  'select2 form-control is-invalid' : 'select2 form-control', 'multiple' => 'multiple', 'name' => 'categories[]'])
                            }}
                            @include('admin.partials._help_block',['field' => 'categories'])
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('format', 'Formato') }}
                            {{
                                Form::select('format', $format_list,null,['class' => $errors->has('format') ?  'select2 form-control is-invalid' : 'select2 form-control'])
                            }}
                            @include('admin.partials._help_block',['field' => 'format'])
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('tags', 'Tags') }}
                            {{
                                Form::select('tags', $tags_list,$tags_selected,['class' => $errors->has('tags') ?  'select2 form-control is-invalid' : 'select2 form-control', 'multiple' => 'multiple', 'name' => 'tags[]'])
                            }}
                            @include('admin.partials._help_block',['field' => 'tags'])
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>





    




