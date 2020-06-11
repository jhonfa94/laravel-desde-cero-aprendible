@extends('layout')

@section('title', 'Portafolio -'.$project->title)


@section('content')
    {{-- {{$project}} --}}
    <div class="container">

        <div class="bg-white p-5 shadow rounded">

            <h1> {{$project->title}}</h1>

                <p class="text-secondary">
                    {{$project->description}}
                </p>

                <p class="text-black-50">
                    {{$project->created_at->diffForHumans()}}
                </p>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{route('projects.index')}}"> Regresar </a>

                    @auth
                        <div class="btn-group btn-group-sm">
                            
                            <a class="btn btn-primary" 
                                href="{{ route('projects.edit', $project) }}">
                                {{__('Edit')}}
                            </a>

                            <a class="btn btn-danger" 
                                href="#"
                                onclick="document.getElementById('')submit()" >
                                {{__('Delete')}}
                            </a>
                        

                        </div>
                        
                        <form id="delete-project" class="d-none"
                            method="POST" 
                            action="{{route('projects.destroy',$project)}}">

                            @csrf
                            @method('DELETE')
                        </form>           
                        
                    @endauth

                </div>




         

        </div>{{-- card --}}
        

    </div>{{-- container --}}
@endsection


{{-- "id": 3,
"title": "Tercer proyecto",
"description": "Descripción tercer proyecto",
"created_at": "2020-06-08T10:47:28.000000Z",
"updated_at": "2020-06-08T10:46:31.000000Z" --}}