@extends('layout')

@section('title','Contact')

@section('content')

    {{-- CONFIRMAMOS SI PRESENTAMOS ERRORES EN EL CÓDIGO --}}
    {{-- @if ($errors->all())
        @foreach ($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach        
    @endif --}}
    
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-10 col-mg-8 col-lg-6 mx-auto" >
                
                
                <form class="bg-white shadow rounded py-3 px-4"
                    method="POST"  
                    action="{{ route('messages.store') }}">

                    <h1 class="display-4">{{__('Contact')}}</h1>
                    <hr>

                    @csrf

                

                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input class="form-control bg-light shadow-sm  @error('name') is-invalid @else border-0 @enderror "
                            type="text" 
                            name="name" 
                            id="name" 
                            placeholder="Nombre..." 
                            value="{{old('name')}}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>
                                        {{$message}}
                                    </strong>
                                </span>
                            @enderror
                        {{-- {!!$errors->first('name', '<small>:message</small><br>') !!} --}}
                    </div>
                    

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control bg-light shadow-sm @error('email') is-invalid  @else border-0 @enderror"
                            type="email" 
                            name="email" 
                            id="email" 
                            placeholder="Email..." 
                            value="{{old('email')}}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>
                                        {{$message}}
                                    </strong>
                                </span>
                            @enderror
                            {{-- {!! $errors->first('email','<small>:message</small><br>') !!} --}}
                    </div>
                    

                    <div class="form-group">
                        <label for="subjet">Asunto</label>
                        <input class="form-control bg-light shadow-sm @error('subjet') is-invalid  @else border-0 @enderror"
                            type="text" 
                            name="subjet" 
                            id="subjet" 
                            placeholder="Asunto..." 
                            value="{{old('subjet')}}">
                            @error('subjet')
                                <span class="invalid-feedback" role="alert">
                                    <strong>
                                        {{$message}}
                                    </strong>
                                </span>
                            @enderror
                            {{-- {!! $errors->first('subjet','<small>:message</small><br>') !!} --}}
                    </div>
                    

                    <div class="form-group">
                        <label for="content">Mensaje</label>
                        <textarea class="form-control bg-light shadow-sm @error('content') is-invalid  @else border-0 @enderror"
                            name="content" 
                            id="content" 
                            rows="2" 
                            placeholder="Mensaje...">
                            {{old('content')}}
                        </textarea> 
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>
                                    {{$message}}
                                </strong>
                            </span>
                        @enderror
                        {{-- {!! $errors->first('content','<small>:message</small><br>') !!} --}}

                    </div>
                    


                    <button type="submit" class="btn btn-primary btn-lg btn-block">{{__('Send')}}</button>

                </form>    
            </div>{{-- col --}}
            
        </div>{{-- row --}}
    </div>{{-- container --}}
    

@endsection