@extends('layout')

@section('title')
    Crear Proyecto
@endsection

@section('content')

    <div class="container">
        
        <div class="row">
            <div class="col-12 col-sm-10 col-mg-8 col-lg-6 mx-auto" >
                   

                @include('partials.validation-errors')


                <form class="bg-white py-3 px-4 shadow rounded"
                    method="post"
                    action="{{route('projects.update',$project)}}" 
                    >

                    <h1 class="display-4">Editar  proyecto</h1>     
                    <hr>
                    
                    @method('PUT')
                    @include('projects._form',['btnText' => 'Update'])    
                </form>

            </div> {{-- col --}}

        </div>{{-- row --}}

        
    </div>{{-- container --}}








@endsection