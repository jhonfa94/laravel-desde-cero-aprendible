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
        
        <div class="d-flex flex-wrap justify-content-between align-items-start">
            @forelse ($projects as $project)
                <div class="card" style="width: 18rem;">
                    @if ($project->image)
                        <img class="card-img-top" style="height: 150px; object-fit:cover;"
                            src="/storage/{{$project->image}}" 
                            alt="{{ $project->title }}" 
                        >                             
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">
                            <a {{ route('projects.show',$project) }}>
                                {{ $project->title }}
                            </a>

                        
                        </h5>
                        <h6 class="card-subtitle">{{$project->created_at->format('d/m/Y')}}</h6>
                        <p class="card-text text-truncate">{{ $project->description }}</p>
                        <a href=" {{ route('projects.show',$project) }}" class="btn btn-sm btn-primary">Ver más...</a>
                    </div>
                </div>
                
            @empty
               <div class="card">
                   <div class="card-body">
                       No hay proyectos para mostrar
                   </div>
               </div>
            @endforelse

            <div class="mt-4">
                {{$projects->links()}}  
            </div>

        </div>{{-- div d-felex --}}
            
        
    </div>{{-- container --}}





@endsection