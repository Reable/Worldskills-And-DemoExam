<?php

namespace App\Http\Controllers;

use App\Models\NewsModel;
use App\Models\SubscribeModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public function all_news(Request $request){
        $news = NewsModel::all();

        return response()->json([
            'news'=>$news
        ],200);
    }
    public function my_news(Request $request){
        $id = $request->route('id');

        $news = NewsModel::where('user_id',$id)->get();
        if(count($news) <= 0){
            return response()->json([
                'error'=>(object)[
                    'message'=>'Ваших новостей не существует'
                ]
            ],200);
        }else if(count($news) >=1){
            return response()->json([
                'news'=>$news
            ],200);
        }
    }
    public function add_news_post(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id'=>'required',
            'company'=>'required|min:3|max:100',
            'title'=>'required|min:2|max:100',
            'category'=>'required|min:3|max:100',
            'description'=>'required|min:10|max:500',
            'image'=>'required|mimes:png,jpg,svg|image'
        ]);
        if($validator->fails()){
            return response()->json([
                'error'=>(object)[
                    'message'=>'Validation errors',
                    'errors'=>$validator->errors()
                ]
            ],422);
        }

        $path = $request->file('image')->store('images/news');

        $news = new NewsModel();

        $news->user_id = $request->input('user_id');
        $news->company = $request->input('company');
        $news->title = $request->input('title');
        $news->category = $request->input('category');
        $news->description = $request->input('description');
        $news->subs = count(SubscribeModel::where('company',$request->input('company'))->get());
        $news->image = $path;

        $news->save();

        return response()->json([
            'data'=>(object)[
                'message'=>'Новость успешно создана',
            ]
        ],200);
    }
    public function subscribe(Request $request){
        $user_id = $request->get('user_id');
        $company = $request->get('company');

        if($news = NewsModel::where('company',$company)->get()){
            if(UserModel::where('id',$user_id)->first()){
                foreach ($news as $new){
                    $new->subs = $new->sub + 1;
                }
                $news->save();
                $subs = new SubscribeModel();

                $subs->company = $company;
                $subs->user_id = $user_id;

                $subs->save();

                return response()->json([
                    'data'=>(object)[
                        'message'=>'Вы успешно подписались на новость у данной компании',
                        'news'=>$news
                    ]
                ],200);
            }
        }

        return response()->json([
            'error'=>(object)[
                'message'=>'Ошибка подписки',
                'errors'=>[
                    'news'=>'Данной компании или пользователя не обнаруженно'
                ]
            ]
        ],200);
    }
}
