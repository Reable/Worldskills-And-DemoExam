<?php

namespace App\Http\Controllers;

use App\Models\NewsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    //
    public function add_news(Request $request){
        $validator = Validator::make($request->all(),[
           'company'=>'required|min:3|max:100',
           'title'=>'required|min:3|max:100',
           'category'=>'required|min:2|max:100',
           'description'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'error'=>(object)[
                    'message'=>'Ошибка валидации',
                    'status'=>422,
                    'errors'=>$validator->errors(),
                ]
            ],422);
        }

        $path = $request->file('image')->store('images');

        $news = new NewsModel();

        $news->user_id = $request->input('user_id');
        $news->company = $request->input('company');
        $news->title = $request->input('title');
        $news->category = $request->input('category');
        $news->description = $request->input('description');
        $news->image = $path;
        $news->subs = 0;

        $news->save();

        return response()->json([
            'data'=>(object)[
                'message'=>'Новость добавлена',
                'news'=>$news
            ]
        ]);
    }
    public function all_news(Request $request){
        $news = NewsModel::all();
        return response()->json([
            'data'=>(object)[
                'news'=>$news
            ]
        ],200);
    }

    public function my_news(Request $request){
        $user_id = $request->route('user_id');

        $my_news = NewsModel::where('user_id',$user_id)->get();

        return response()->json([
            'data'=>(object)[
                'news'=>$my_news
            ]
        ],200);
    }
}
