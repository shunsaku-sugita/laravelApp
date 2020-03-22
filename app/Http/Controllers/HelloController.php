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
        return view('hello.index', ['msg'=> 'フォームを入力ください。']);
    }

    public function post(HelloRequest $request)
    {
        return view('hello.index', ['msg' => '正しく入力されました！']);
    }
}
