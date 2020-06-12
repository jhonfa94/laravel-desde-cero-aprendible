# Estructuras de control

Las estructuras de control en blade se puedeen realizar tanto de forma tradicional en php como en la nueva estructura de blade

## Estrucutra de control foreach en blade
@foreach ($portafolio as $key => $value) :
    <li> {{ $value['title'] }}</li>  
@endforeach

## Estructura de control if en blade
@if ($portafolio)
    @foreach ($portafolio as $key => $value) :
        <li> {{ $value['title'] }}</li>  
    @endforeach  
@else
    <li>No hay proyectos para mostrar</li>  
@endif

## Estructura de control isset en blade 
@isset ($portafolio)
    @foreach ($portafolio as $key => $value) :
        <li> {{ $value['title'] }}</li>            
    @endforeach  
@else
    <li>No hay proyectos para mostrar</li>          
@endisset

## Directiva de control forelse en blade
@forelse ($portafolio as $portafolioItem)
        <li> {{ $portafolioItem['title'] }}</li>    
@empty
        <li> No hay proyectos para mostrar </li>                
@endforelse

## Varialbe $loop
Dentro del foreach podemos ver la variable loop el cual nos muestra en detalle el objeto que se esta imprimiendo