<?php
/**
 * Created by PhpStorm.
 * User: Johnson
 * Date: 2018-10-17
 * Time: 16:04
 */

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\SourcePhotos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PhotoGraphController extends Controller
{
    public $successStatus = 200;

    /**
     * 上传源照片文件API
     */
    public function uploadSourcePhoto(Request $request){
        $result['code'] = false;
        $result['msg'] = '文件上传失败';
        if($request->isMethod('POST')){
            $file = $request->file('sourcephoto');
            $projectid = $request->get('projectid');
            //dd($file);
            //判断文件是否上传成功
            if ($file->isValid() && !empty($projectid)){
                //源文件名
                $originalName = $file->getClientOriginalName();
                //扩展名
                $ext = $file->getClientOriginalExtension();
                //minetype
                $mimeType = $file->getMimeType();
                //临时文件绝对路径
                $realPath = $file->getRealPath();
                $uniqid = uniqid();
                $tempFile =  date('YmdHis') . '_' . $uniqid . '.' . $ext;

                //文件转储
                $isSave = Storage::disk('uploadssource')->put($tempFile,file_get_contents($realPath));

                if($isSave){
                    $filePath = 'source/'.$tempFile;
                    $data = [
                        'project_id' => $projectid,
                        'path' => $filePath,
                        'filetype' =>$ext,
                        'created_at' =>date('Y-m-d H:i:s'),
                        'updated_at' =>date('Y-m-d H:i:s'),
                        'media_uniqid'=> $uniqid,
                        'file_name' =>$originalName,
                    ];
                    $line = DB::table('source_photos')->insert($data);
                    if($line){
                        $result['code'] = true;
                        $result['msg'] = '文件上传成功';
                    }
                }
            }
        }
        return response()->json($result, $this->successStatus);
    }

    /**
     * 上传修图后照片文件API
     */
    public function uploadSprettyPhoto(Request $request){
        $result['code'] = false;
        $result['msg'] = '文件上传失败';
        if($request->isMethod('POST')){
            $file = $request->file('sprettyphoto');
            $projectid = $request->get('projectid');
            //dd($file);
            //判断文件是否上传成功
            if ($file->isValid() && !empty($projectid)){
                //源文件名
                $originalName = $file->getClientOriginalName();
                //扩展名
                $ext = $file->getClientOriginalExtension();
                //minetype
                $mimeType = $file->getMimeType();
                //临时文件绝对路径
                $realPath = $file->getRealPath();
                $uniqid = uniqid();
                $tempFile =  date('YmdHis') . '_' . $uniqid . '.' . $ext;

                //文件转储
                $isSave = Storage::disk('uploadssource')->put($tempFile,file_get_contents($realPath));

                if($isSave){
                    $filePath = 'source/'.$tempFile;
                    $data = [
                        'project_id' => $projectid,
                        'path' => $filePath,
                        'filetype' =>$ext,
                        'created_at' =>date('Y-m-d H:i:s'),
                        'updated_at' =>date('Y-m-d H:i:s'),
                        'media_uniqid'=> $uniqid,
                        'file_name' =>$originalName,
                    ];
                    $line = DB::table('spretty_photos')->insert($data);
                    if($line){
                        $result['code'] = true;
                        $result['msg'] = '文件上传成功';
                    }
                }
            }
        }
        return response()->json($result, $this->successStatus);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 显示文件上传界面
     */
    public function showUpload(Request $request){
        if($request->isMethod('POST')) $this->uploadSourcePhoto($request);
        return view('photograph.upload');
    }

    //分页获取源照片列表
    public function getAllSourcePhoto(Request $request){
        $pageSize=$request->get('pageSize');
        $project_id=$request->get('project_id');
        $created_time=$request->get('created_day');
        if($pageSize){
            $sourcePhotos = SourcePhotos::where(['project_id' => $project_id])
                ->where('created_at', 'like' ,$created_time . '%')
                ->orderBy('created_at', 'asc')
                ->paginate($pageSize);
        }
        return response()->json($sourcePhotos, $this->successStatus);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 分页获取修图后照片列表
     */
    public function getAllSprettyPhoto(Request $request){
        $pageSize=$request->get('pageSize');
        $project_id=$request->get('project_id');
        $created_time=$request->get('created_day');
        if($pageSize){
            $sourcePhotos = SprettyPhotos::where(['project_id' => $project_id])
                ->where('created_at', 'like' ,$created_time . '%')
                ->orderBy('created_at', 'asc')
                ->paginate($pageSize);
        }
        return response()->json($sourcePhotos, $this->successStatus);
    }
}