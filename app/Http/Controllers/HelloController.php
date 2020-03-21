<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\HelloRequest;
use Validator;
use function foo\func;

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
            'age' => 'numeric',
        ];

        $messages = [
            'name.required' => '名前は必ず入力してください。',
            'mail.email' => 'メールアドレスが必要です。',
            'age.numeric' => '年齢を整数で記入してください。',
            'age.min' => '年齢はゼロ歳以上で記入してください。',
            'age.max' => '年齢は200歳以下で記入してください。',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->sometimes('age', 'min:0', function ($input) {
           return !is_int($input->age); //$input->ageの値が整数の場合はfalseを返し、min:0のルールが追加される
        });

        $validator->sometimes('age', 'max:200', function ($input) {
            return !is_int($input->age);
        });

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
