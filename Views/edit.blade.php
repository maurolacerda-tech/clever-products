@extends('admin.layout.default')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="{{$menu_icon}} bg-orange"></i>
                <div class="d-inline">
                    <h5>{{$menu_name}}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard.index')}}"><i class="ik ik-home"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{$menu_name}}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="row clearfix">

        <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active show" id="pills-timeline-tab" data-toggle="pill" href="#tab-pt-br" role="tab" aria-controls="pills-timeline" aria-selected="true">
                    Português Brasil
                </a>
            </li>
            @foreach ($languages as $language)
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#tab-{{$language->code}}" role="tab" aria-controls="pills-profile" aria-selected="false">
                    {{$language->name}}
                </a>
            </li>
            @endforeach
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade active show" id="tab-pt-br" role="tabpanel" aria-labelledby="pills-timeline-tab">
                {{ Form::model($product, ['url' => ['/panel/'.$slug, $product->id], 'method' => 'PUT', 'files' => true ]) }}
                    {{ Form::hidden('id', $product->id) }}
                    @include('Product::_form')                        
                    <div class="col-sm-12 text-right">
                        <a href="{{ url('/panel/'.$slug) }}" class="text-orange">Cancelar</a>
                        <button type="submit" class="btn2 btn-dark ml-2">Atualizar</button>
                    </div>
                {{ Form::close() }}
            </div>
            @foreach ($languages as $language)
            <div class="tab-pane fade" id="tab-{{$language->code}}" role="tabpanel" aria-labelledby="pills-timeline-tab">
                @php
                    $colectionTranslation = $language->translation($menu_id, $product->id);
                @endphp
                {{ Form::model($colectionTranslation, ['route' => ['admin.translations.store'], 'method' => 'POST']) }}
                <input type="hidden" name="menu_id" value="{{$menu_id}}">
                <input type="hidden" name="code" value="{{$language->code}}">
                <input type="hidden" name="parent_id" value="{{$product->id}}">
                    @include('Product::_form_translate')                        
                    <div class="col-sm-12 text-right">
                        <a href="{{ url('/panel/'.$slug) }}" class="text-orange">Cancelar</a>
                        <button type="submit" class="btn2 btn-dark ml-2">Atualizar</button>
                    </div>
                {{ Form::close() }}
            </div>
            @endforeach
        </div>
     
</div>
@endsection

@section('styles')
<style>
    .select2-container{
        width: 100% !important;
    }
    form{width: 100%;}
</style>
@endsection


@section('scriptjs')
    @isset ($combine_filds['more_images'])
        @php
            $more_images_json = isset($product->more_images_json) ? $product->more_images_json : '';
        @endphp
        <script>
            $(document).ready(function() {
                carregaMultiplasImages( {!! $more_images_json !!} );
            });
        </script>
    @endisset
@endsection