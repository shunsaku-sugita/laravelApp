<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\HelloRequest;
use Validator;
use Illuminate\Support\Facades\DB;

class HelloController extends Controller
{
    public function index(Request $request)
    {
        $items = DB::select('select * from people');
        return view('hello.index', ['items' => $items]);
    }
    public function post(Request $request)
    {
        $validate_rule = [
            'msg' => 'required',
        ];

        $this->validate($request, $validate_rule);
        $msg = $request->msg;
        $response = new Response(
            view('hello.index', ['msg' => '「'. $msg. '」をクッキーに保存しました。']));
        $response->cookie('msg', $msg, 100); // 引数は「割り当てるキー」「値」「保存する分数」
        return $response;
    }
}
