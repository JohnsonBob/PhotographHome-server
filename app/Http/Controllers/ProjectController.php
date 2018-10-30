<?php
/**
 * Created by PhpStorm.
 * User: Johnson
 * Date: 2018-10-18
 * Time: 11:53
 */

namespace App\Http\Controllers;


use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

/**
 * Class ProjectController
 * @package App\Http\Controllers
 * 项目Controller
 * 2018年10月18日11:53:50
 */
class ProjectController extends Controller
{

    /**
     * @param Request $request
     * 创建项目
     */
    public function createProject(Request $request){
        $validator = Validator::make($request->all(), [
            'project_name' => 'required',
            'desc' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        if(!$validator->fails()){
            $input = $request->all();
            $userid = Auth::id();
            $input['user_id'] = $userid;
            $project = Project::create($input);
            if(!empty($project)){
                return response()->json(['code'=>true,'msg' => '项目创建成功',
                    'project_name'=>$project->project_name,
                    'project_id'=>$project->id],200);
            }
        }
        return response()->json(['code'=>false,'msg' => '项目创建失败'],200);
    }

    public function deleteProject(Request $request){
        $userid = Auth::id();
        $project_id = $request->get('project_id');
        $project = Project::find($project_id);
        if(!empty($project)){
            if($project->user_id == $userid){
                $result = $project->delete();
                if($result){
                    return response()->json(['code'=>true,'msg' => '项目删除成功!'],200);
                }else{
                    return response()->json(['code'=>false,'msg' => '删除项目失败!'],200);
                }
            }else{
                return response()->json(['code'=>false,'msg' => '删除项目失败,不能删除其他人的项目!'],200);
            }
        }
        return response()->json(['code'=>false,'msg' => '删除项目失败,该项目不存在!'],200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取项目列表
     */
    public function getProject(){
        $userid = Auth::id();
        $projectList = Project::where(['user_id' => $userid])->get();
        if($projectList){
            return response()->json(['code'=>true,'msg' => '获取项目成功!', 'data' => $projectList],200);
        }
        return response()->json(['code'=>true,'msg' => '获取项目失败!'],200);
    }


}