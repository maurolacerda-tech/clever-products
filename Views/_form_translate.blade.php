{{ Form::hidden('menu_id', $menu_id) }}

<div class="row">
    <div class="col-sm-8">
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
            <div class="col-sm-12">
                <div class="form-group">
                    {{ Form::label('seo_title', 'SEO Title') }} 
                    {{ Form::text('seo_title', null, ['class' => $errors->has('seo_title') ?  'form-control is-invalid' : 'form-control']) }}
                    @include('admin.partials._help_block',['field' => 'seo_title'])
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
    <div class="col-sm-4">
        <div class="row">
            <div class="col-sm-12">
                &nbsp;
            </div>
        </div>
    </div>
</div>