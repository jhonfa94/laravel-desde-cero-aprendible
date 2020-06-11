@extends('layout')

@section('title')
    Crear Proyecto
@endsection

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-12 col-sm-10 col-mg-8 col-lg-6 mx-auto" >

                @include('partials.validation-errors')
                @include('partials.session-status')

                <form class="bg-white py-3 px-4 shadow rounded" 
                    action="{{route('projects.store')}}" 
                    method="post">        

                    <h1 class="display-4">Nuevo proyecto</h1>
                    <hr>

                    @include('projects._form', ['btnText' => 'Save']) 
                </form>

            </div>
        </div>

        
    </div>{{-- container --}}







@endsection