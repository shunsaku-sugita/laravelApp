<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\HelloRequest;
use Validator;

class HelloController extends Controller
{
    public function index(Request $request)
    {
        return view('hello.index', ['msg' => 'フォームを入力：']);
    }

    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mail' => 'email',
            'age' => 'numeric | between:0, 150',
        ]);

        // 失敗した場合true
//        if ($validator->fails()) {
//            return redirect('/hello')
//                        ->withErrors($validator)
//                        ->withInput();
//        }

        // 成功した場合true
        if (!$validator->passes()) {
            return redirect('/hello')
                        ->withErrors($validator) // エラーメッセージをリダイレクト先まで引き継ぐ
                        ->withInput(); // 入力値をリダイレクト先まで引き継ぐ
        }

        return view('hello.index', ['msg' => '正しく入力されました！']);
    }
}
