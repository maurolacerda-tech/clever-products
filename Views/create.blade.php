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
    
    {{ Form::open(['url' => 'panel/'.$slug.'/store', 'files' => true ]) }}
        @include('Post::_form')                        
        <div class="col-sm-12 text-right">
            <a href="{{ url('/panel/'.$slug) }}" class="text-orange">Cancelar</a>
            <button type="submit" class="btn2 btn-dark ml-2">Criar</button>
        </div>
    {{ Form::close() }}

        
</div>
@endsection