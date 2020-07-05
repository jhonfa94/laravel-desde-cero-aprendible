@extends('layout')

@section('title')
    Portfolio
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">

            @isset($category)
                <div>
                    <h1 class="display-4 mb-0">{{ $category->name }}</h1>
                    <a href="{{ route('projects.index') }}">Regresar al portafolio</a>
                </div>
            @else
                <h1 class="display-4 mb-0">@lang('Projects')</h1>
            @endisset

            @can('create', $newProject)
                <a class="btn btn-primary "
                    href="{{route('projects.create')}}">
                    Crear proyecto
                </a>
            @endcan

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
                        <div class="d-flex justify-content-between align-items-center">
                            <a href=" {{ route('projects.show',$project) }}" class="btn btn-sm btn-primary">Ver más...</a>
                            @if ($project->category_id)
                                <a href="{{ route('categories.show', $project->category) }}" class="badge badge-secondary">{{$project->category->name}} </a>
                            @endif

                        </div>

                    </div>
                </div>

            @empty
               <div class="card">
                   <div class="card-body">
                       No hay proyectos para mostrar
                   </div>
               </div>
            @endforelse


        </div>{{-- div d-felex --}}

        <div class="mt-4">
            {{-- Mostramos la páginación de los registros           --}}
            {{$projects->links()}}
        </div>


        {{-- MOSTRAMOS LOS PROYECTOS ELIMINADOS         --}}
        @auth()
            @can('view-deleted-projects')
                <h4>Papelera</h4>
                <ul class="list-group">
                    @foreach($deletedProjects as $deletedProject)
                        <li class="list-group-item">
                            {{$deletedProject->title}}

                            @can('restore',$deletedProject)

                                <form method="POST" action="{{ route('projects.restore',$deletedProject) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-info">Restaurar</button>
                                </form>
                            @endcan

                            @can('force-delete',$deletedProject)
                                <form method="POST"
                                      action="{{ route('projects.force-delete',$deletedProject) }}"
                                      onsubmit="return confirm('Esta acción no se puede deshacer, ¿Estás seguro de querer eliminar este proyecto?')"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar permanente</button>

                                </form>
                            @endcan
                        </li>
                    @endforeach
                </ul>
            @endcan
        @endauth






    </div>{{-- container --}}





@endsection
