@csrf

<div class="custom-file">
    <input type="file" name="image" class="custom-file-input" id="customFile">
    <label class="custom-file-label" for="customFile">Choose file</label>
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