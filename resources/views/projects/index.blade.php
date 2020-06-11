@extends('layout')

@section('title')
    Portfolio
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="display-4 mb-0">Portfolio</h1>
            @auth        
                <a class="btn btn-primary " 
                    href="{{route('projects.create')}}">
                    Crear proyecto
                </a>
            @endauth        

        </div>

        <p class="lead text-secondary">
            Proyectos realizados. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Amet quo aliquid, delectus repudiandae cum necessitatibus velit suscipit numquam optio hic corporis, sapiente eos facilis quia saepe quam impedit et quisquam.
        </p>

        <hr>
        
        <ul class="list-group">
            @forelse ($projects as $project)
                <li class="list-group-item border-0 mb-3 shadow-sm"> 
                    <a class="d-flex justify-content-between align-items-center text-secondary"
                         href="{{ route('projects.show',$project) }}">

                        <span class=" font-weight-bold">
                            {{ $project->title }}
                        </span>

                        <span class="text-black-50">
                            {{ $project->created_at->format('d/m/Y') }}
                        </span>
                    </a>
                    {{-- 
                        <small>{{$project->description}}</small> <br>
                        {{$project->created_at->format('Y-m-d')}} <br>
                        {{$project->created_at->diffForHumans()}}
                    --}}
                </li>
                
            @empty
                <li class="list-group-item border-0 mb-3 shadow-sm">
                    No hay elementos que mostrar
                </li>
                
            @endforelse
            {{$projects->links()}}
            
            
        </ul>
        
    </div>{{-- container --}}





@endsection