@csrf

@if ($project->image)
    <img class="card-img-top mb-2" 
        style="height: 250px; object-fit:cover;"
        src="/storage/{{$project->image}}" 
        alt="{{ $project->title }}" 
    >                             
@endif

<div class="custom-file mb-2">
    <input type="file" name="image" class="custom-file-input" id="customFile">
    <label class="custom-file-label" for="customFile">Choose file</label>
</div>

<div class="form-group">
    <label for="category_id">Categoría del proyecto</label>
    <select name="category_id" 
            id="category_id"
            class="form-control border-o bg-light- shadow-sm">
        <option value="" >Seleccione</option>
        @foreach ($categories as $id => $name)
            <option value="{{$id}}"
                {{-- {{$id === $project->category_id ? 'selected' : ''}} --}}
                @if ($id == old('category_id', $project->category_id ))  selected   @endif
            >
            {{$name}}
            </option>
        @endforeach
    </select>
</div>


<div class="form-group">
    <label for="tituloProyecto">Título del proyecto </label>
    <input class="form-control border-0 bg-light shadow-sm"
        id="tituloProyecto"  
        type="text" 
        name="title"  
        value="{{old('title', $project->title)}}">
</div>

<div class="form-group">
    <label for="urlProyecto">Url del proyecto</label>
    <input  class="form-control border-0 bg-light shadow-sm" 
        id="urlProyecto" 
        type="text" 
        name="url" 
        value="{{old('url',$project->url)}}">
</div>

<div class="form-group">
    <label for="descripcionProjecto">Descripción del proyecto</label>
    <textarea class="form-control border-0 bg-light shadow-sm"
        name="description" 
        id="description"  
        rows="2">
        {{old('description',$project->description)}}
    </textarea>
</div>

<button class="btn btn-primary btn-block"
    type="submit">
    {{__($btnText)}}
</button>

<a class="btn btn-link btn-block" 
    href="">
    Cancelar
</a>