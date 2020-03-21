<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\HelloRequest;
use Validator;

class HelloController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->query(), [
           'id' => 'required',
           'pass' => 'required',
        ]);

        if ($validator->fails()) {
            $msg = 'クエリに問題があります。';
        } else {
            $msg = 'ID/PASSを受け付けました。フォームを入力してください。';
        }

        return view('hello.index', ['msg'=> $msg]);
    }

    public function post(Request $request)
    {
        $rules = [
            'name' => 'required',
            'mail' => 'email',
            'age' => 'numeric | between:0, 150',
        ];

        $messages = [
            'name.required' => '名前は必ず入力してください。',
            'mail.email' => 'メールアドレスが必要です。',
            'age.numeric' => '年齢を整数で記入してください。',
            'age.between' => '年齢は０〜１５０の間で入力してくださ。',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

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
