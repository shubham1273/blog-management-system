<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Post::with('user')->orderBy('id', 'desc')->paginate('5');
           
       
        return view('post.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('post.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // Validate the incoming form data here using Laravel's validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);
        
        if ($validator->fails()) {
            // dd($validator);
            return redirect('home')->withErrors($validator)->withInput();
        }

        Post::create([
        'title' => $request->input('title'),
        'user_id' => \Auth::user()->id,
        'content' => $request->input('content'),
    ]);

       
            // Redirect back or return a response
             return redirect('post')->with('success', 'Post added successfully'); 
            
       
               
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $data = Post::where('id',$id)->with('comments')->first();
        return view('post.view',compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Post::where('id',$id)->first();
        return view('post.edit',compact('data'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {


       $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);
        
        if ($validator->fails()) {
            // dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }


         $post = Post::find($request->input('id'));
         $post->update([
        'title' => $request->input('title'),
        'content' => $request->input('content'),
    ]);

       
            // Redirect back or return a response
             return redirect('post')->with('success', 'Post Updated successfully'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $comment = Comment::where('post_id', $id);
        $comment->delete(); // Delete the comment

        $post = Post::findOrFail($id); // Find the post by its ID
        $post->delete(); // Delete the post

    

    return redirect()->route('post.index')->with('success', 'Post deleted successfully');
    }



    public function storeComment(Request $request)
    {
        // Validate the incoming form data here using Laravel's validation rules
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|max:60',
            'email' => 'nullable|email|max:50',
            'comment' => 'required|max:150'
        ]);
        
        if ($validator->fails()) {
            // dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Comment::create([
            'user_name' => $request->input('user_name'),
            'email' => $request->input('email'),
            'post_id' => $request->input('post_id'),
            'comment' => $request->input('comment'),
        ]);
       
        // Redirect back or return a response
         return redirect()->back()->with('success', 'Comment added successfully'); 
            
       
               
    }
}
