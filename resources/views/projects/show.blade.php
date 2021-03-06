@extends('layout')

@section('title', 'Portafolio -'.$project->title)


@section('content')
    {{-- {{$project}} --}}
    <div class="container">

        <div class="row">
            <div class="col-12 col-sm-10 col-lg-8 mx-auto">

                @if ($project->image)
                    <img class="card-img-top"
                        src="/storage/{{$project->image}}"
                        alt="{{ $project->title }}"
                    >
                @endif

                <div class="bg-white p-5 shadow rounded">

                    <h1 class="mb-0"> {{$project->title}}</h1>
                        @if ($project->category_id)
                            <a href="{{ route('categories.show', $project->category) }}" class="badge badge-secondary mb-1">{{$project->category->name}} </a>
                        @endif

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
                                    @can('update',$project)
                                        <a class="btn btn-primary"
                                            href="{{ route('projects.edit', $project) }}">
                                            {{__('Edit')}}
                                        </a>
                                    @endcan

                                    @can('delete',$project)
                                        <a class="btn btn-danger"
                                            href="#"
                                            onclick="document.getElementById('delete-project').submit()" >
                                            {{__('Delete')}}
                                        </a>

                                        <form id="delete-project" class="d-none"
                                            method="POST"
                                            action="{{route('projects.destroy',$project)}}">

                                            @csrf
                                            @method('DELETE')
                                        </form>

                                     @endcan

                                </div>


                            @endauth

                        </div>






                </div>{{-- card --}}
            </div>{{-- col --}}

        </div>{{-- row --}}



    </div>{{-- container --}}
@endsection


{{-- "id": 3,
"title": "Tercer proyecto",
"description": "Descripción tercer proyecto",
"created_at": "2020-06-08T10:47:28.000000Z",
"updated_at": "2020-06-08T10:46:31.000000Z" --}}
