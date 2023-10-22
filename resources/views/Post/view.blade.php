@extends('layouts.app')

@section('content')
<style>
    .container2 {
        display: flex;
        justify-content: space-between;
    }
    .box {
        width: 30%; /* Adjust the width as needed */
        margin: 5px;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

    <div class="card">
        <div class="card-header">{{ __('View Blog') }}</div>
                
        <div class="card-body">
            <div class="row">
                <div class="cols-12">
                    <div class="card m-2">
       
                        <div class="card-body">
                          <h4 class="card-title">{{$data->title}}</h4>
                          <small class="text-muted cat">
                            Author: <strong>{{$data->user->name}}</strong>
                          </small>
                          <p class="card-text">{{$data->content}}</p>
                          
                        </div>
                        <div class="card-footer text-muted d-flex justify-content-between bg-transparent border-top-0">
                          <div class="views">{{$data->created_at}}
                          </div>
                          <div class="stats">

                            <div class="container2">
                                @if(\Auth::user()->id == $data->user_id)
                                    <div class="box">
                                        <a href="{{route('post.edit',$data->id)}}" class="btn btn-primary btn-sm">
                                        Edit
                                    </a>
                                    </div>
                                    <div class="box">
                                        <form method="POST" action="{{ route('post.destroy', $data->id) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                          Delete
                                        </button>
                                    </form>
                                    </div>

                                @endif
                                <div class="box">
                                    <a href="{{route('post.index')}}" class="btn btn-primary btn-sm">
                                     Back
                                    </a>
                                </div>
                            </div>
                            
                            

                            
                          </div>
                </div>
            </div>




        <!-- comment Section  -->

        <h3 class="text-center">
            Comments
        </h3>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
               
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="border-primary p-4 mb-4">
            <form action="{{url('store-comment')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-2">
                    <input type="hidden" name="post_id" value="{{$data->id}}">
                    
                    <label for="user_name">User Name</label>
                    <input type="text" class="form-control" id="user_name" placeholder="User Name" name="user_name" value="{{old('user_name') }}">

                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" placeholder="Email (optional)" name="email" value="{{old('email') }}">

                    <label for="comment">Comment</label>
                    <input type="text" class="form-control" id="comment" placeholder="Comment ...." name="comment" value="{{old('comment') }}">
                </div>    

          
                <div class="d-flex add-btn">                  
                    <button class="btn btn-success mr-2">Save</button>
                </div>
            </form>
        </div>



        <div class="row">
            @foreach($data->comments as $comm)
                <div class="cols-12">
                    <div class="card mb-2">
                      <div class="card-body">
                        <p class="card-text">{{$comm->comment}}</p>
                        Author : <strong>{{$comm->user_name}}</strong> | <strong>{{$comm->email}}</strong> 
                      </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- comment Section Ends -->

                          
        </div>
    </div>
</div>
</div>
</div>
@endsection