<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Laravel\Lumen\Application;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use App\Facades\Lang;

class Controller extends BaseController
{
    protected $locale = "cn";

    public $trans = null;

    public $auth = null;

    public $filter = null;
	
    // 構造函數
    public function __construct(Request $request) {
		// 设置本地语言
		$this->setLocale($request);
        // 生成重定向...
        $this->beforeFilter($request);
        // 保存操作记录
        $this->saveOperationRecord($request);
	}

    // 自定义 beforeFielter
    private function beforeFilter($request) {

        $request_path = $request->path();
        if (preg_match("/^login/", $request_path)) {
            return true;
        }

        $session_cookie = $request->cookie('auth_user');
        if (empty($session_cookie)) {
            echo "<script>window.location='/login';</script>";
            exit();
        }

        $ajax_request = $request->header('X-Requested-With');
        if (empty($ajax_request)) {
            echo view('__portal', ['trans' => $this->trans])->render();
            exit();
        }
    }

    // 记录操作日志
    private function saveOperationRecord($request) {
        if ($request->path()!="manager/operation-list") {
            $opteration = [
                  'manager_id' => 1,
                'manager_name' => 'koocyton@gmail.com',
                  'created_at' => time(),
              'request_method' => $request->method(),
                 'request_uri' => $request->path(),
                   'post_data' => ($request->method()=="POST") ? json_encode($_POST) : ""
            ];
            app('db')->table('manager-operation')->insert($opteration);
        }
    }

    // 没有 beforeFielter
    protected function view($template, Array $assign=[]) {
        // 多语言
        $assign['trans'] = $this->trans;
        // 输出模板
        return response(view($template, $assign));
    }
    
    // 设置本地语言
    protected function setLocale($request) {
        // 从 Cookie 获取本地化设置
        if (!empty($request->cookie('locale'))) {
            $this->locale = $request->cookie('locale');
        }
        // 从 Get 获取本地化设置
        if (!empty($_GET["locale"])) {
            $this->locale = $_GET["locale"];
        }
        // 修正
        $this->locale = in_array($this->locale, ["en", "jp", "kr", "tw" , "cn"]) ? $this->locale : "cn" ;

        // 设置多语言
        $this->trans = app('translator');
        $this->trans->setLocale($this->locale);
    }
}
