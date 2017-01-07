<?php
namespace App\Http\Controllers;

use App\Helper\SecurityHelper;
use App\Http\Controllers\Controller as BaseController;
use App\Model\User;
use Illuminate\Http\Response;

class ProjectController extends BaseController
{
    /*
     * 接口调试界面
     */
    public function apiDebug($key)
    {
        $assign = ["key" => $key];
        $user = User::where('account', 'koocyton@gmail.com')->first();
        // channel-menu
        if ($key == "channel-menu") {
            $token = $user->token;
            $token_secret = $user->token_secret;
            $request_url = "http://be.doopp.com/channel-menu";
            $request_method = "GET";
            $assign["authorization"] = SecurityHelper::authorization($token, $token_secret, $request_url, $request_method);
        }
        // channel-detail
        if ($key == "channel-detail") {
            $token = $user->token;
            $token_secret = $user->token_secret;
            $request_url = "http://be.doopp.com/channel-detail";
            $request_method = "GET";
            $assign["authorization"] = SecurityHelper::authorization($token, $token_secret, $request_url, $request_method);
        }
        // 返回 view
        return $this->display('project_api_debug', $assign);
    }

    /*
     * 数据管理
     */
    public function dataManage($key)
    {
        // 预定义变量
        $assign = ['key' => $key];

        // 获取数据
        if (in_array($key, ['channel', 'news', 'user'])) {
            $skip = empty($_GET['po']) ? 0 : $_GET['po'] - 1;
            $class_name = "App\\Model\\" . ucfirst($key);
            $model = new $class_name();
            $assign['fields'] = $model->getFields();
            $assign['data'] = $model->withTrashed()->skip($skip)->take(30)->orderBy('id', 'desc')->get();
        }

        // 分页信息
        $assign['paging'] = [
            // 当前页的起始数
            'current' => empty($_GET['po']) ? 1 : $_GET['po'],
            // 总数
            'total' => $model->withTrashed()->count(),
            // 每页显示多少条记录
            'limit' => 30,
        ];

        // 返回 view
        return $this->display('project_data_manage', $assign);
    }

    /*
     * 打开或关闭某条记录
     */
    public function dataSwitch($key, $id)
    {
        $class_name = "App\\Model\\" . ucfirst($key);
        $model = new $class_name();
        // 获得数据
        $line = $model->withTrashed()->where(['id' => $id])->first();
        // 打开或关闭
        $deleted_at = empty($line->deleted_at) ? time() : null;
        // 更新
        $model->withTrashed()->where(['id' => $id])->update(['deleted_at' => $deleted_at]);
        // 刷新页面
        return response('<script>$(window).trigger("popstate");</script>');
    }

    /*
     * 打开或关闭某条记录
     */
    public function dataEditor($key, $id)
    {
        $class_name = "App\\Model\\" . ucfirst($key);
        $model = new $class_name();
        $assign = ['key' => $key, 'id' => $id, 'data' => []];
        // 获得数据
        $assign['data'] = $model->withTrashed()->where(['id' => $id])->first();
        // 返回 view
        return $this->display('project_data_editor', $assign);
    }

    /*
     * 打开或关闭某条记录
     */
    public function dataUpdate($key, $id)
    {
        $class_name = "App\\Model\\" . ucfirst($key);
        $model = new $class_name();
        $assign = ['key' => $key, 'id' => $id, 'data' => []];
        // 获得数据
        $assign['data'] = $model->withTrashed()->where(['id' => $id])->first();
        // 返回 view
        return $this->display('project_data_editor', $assign);
    }
}
