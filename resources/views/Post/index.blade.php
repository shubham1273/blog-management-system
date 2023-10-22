@extends('layouts.app')

@section('content')

<style>
    img, svg {
        vertical-align: middle;
        width: 20px !important;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Posts') }}<a href="{{route('post.create')}}" class="btn btn-primary" style="
    float: right;">Add Post</a></div>



              @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
       
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

       <div class="container">
  <div class="row">
    @forelse($data as $post)
    <div class="col-12">
      <div class="card m-2">
       
        <div class="card-body">
          <h4 class="card-title">{{$post->title}}</h4>
          <small class="text-muted cat">
            Author: <strong>{{$post->user->name}}</strong>
          </small>
            @php
                $txtlength = strlen($post->content);
                if($txtlength > 150){
                    $content = substr($post->content, 0, 150). '....';
                } else {
                    $content = $post->content;
                }
            @endphp
          <p class="card-text">{{$content}}</p>
          
        </div>
        <div class="card-footer text-muted d-flex justify-content-between bg-transparent border-top-0">
          <div class="views">{{$post->created_at}}
          </div>
          <div class="stats">
            <a href="{{route('post.show',$post->id)}}" class="btn btn-info btn-sm">
             View Post
            </a>
            @if(\Auth::user()->id == $post->user_id)
                <a href="{{route('post.edit',$post->id)}}" class="btn btn-primary btn-sm">
                    Edit            
                </a>

                <form method="POST" action="{{ route('post.destroy', $post->id) }}">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger btn-sm">
                      Delete
                    </button>
                </form>
            @endif
            
            
            
          </div>
           
        </div>
      </div>
    </div>
    @empty
    <h4 class="text-center">No Post Available</h4>
    @endforelse
  </div>
  {{ $data->links() }} <!-- Pagination links -->
</div>           

    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
