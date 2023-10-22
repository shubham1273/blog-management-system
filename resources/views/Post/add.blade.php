@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
       
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
      @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
     <div class="card">
                <div class="card-header">{{ __('Create Your Blog') }}</div>
<form action="{{url('post')}}" method="POST"    enctype="multipart/form-data">
    @csrf


  <label for="title">Title:</label><br>
  <input type="text" id="title" name="title" value="{{ old('title') }}
" ><br>
  <label for="content">Content:</label><br>
  <textarea id="w3review" name="content" rows="4" cols="50"  >{{ old('content') }}

</textarea><br><br>
   <div class="d-flex add-btn">
                            
                            <button class="btn btn-success mr-2">Save</button>

                            <a href="{{route('post.index')}}" class="btn btn-primary">Back</a>
                        </div>
</form>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Welcome to Your Blog!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
