<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\FilterManager;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $options = [
            'take' => $request->input('take'),
            'skip' => $request->input('skip'),
            'sort' => $request->input('sort'),
        ];

        //Sort comments also by childs
        $query = Comment::with(['replies' => function($query) use ($options) {
            $query->orderBy('created_at', $options['sort'] ? $options['sort'] : 'asc');
        }])->where('comment_level', 1);

        //Apply the filters using the helper class
        $query = FilterManager::filter($query, $options);

        $response = ["data" => $query->get(), "meta" => ["total" => $query->count()]];
        return response()->json($response, 200);
    }

    public function show(Request $request, $id)
    {
        $response = Comment::with('replies')->findOrFail($id);
        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $data = $request->input('data') ? $request->input('data') : [];

        //Validate request
        $rules = [
            'name' => 'required',
            'comment' => 'required',
            'reply_to' => 'nullable|exists:comments,id',
            'comment_level' => 'numeric|min:1|max:3'
        ];

        $validator = Validator::make($data, $rules);
        $validator->validate();

        //It validation pass, create the object
        $comment = Comment::create($data);

        $response = ["data" => $comment];
        return response()->json($response, 201);
    }
}
