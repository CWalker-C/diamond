<?php

namespace App\Http\Controllers\Upload;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use zgldh\QiniuStorage\QiniuStorage;

class UploadPictureController extends Controller
{
    /**
     * 使用七牛云上传文件
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function uploadPicture(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filetype = ['jpg', 'jpeg', 'gif', 'bmp', 'png'];
            if (!in_array($extension, $filetype)) {
                return response()->json([
                    'code'  => 3001,
                    'msg'   => '文件不是图片'
                ]);
            }
            $upload = new UploadController();
            if (($imgurl = $upload->upload($file, 'diamond')) == false) {
                return '头像上传失败';
            } else {
                $imgurl = 'pfpeyrylm.bkt.clouddn.com/' . $imgurl;

                return response()->json([
                    'code'  => 2000,
                    'data'  => [
                        'imageUrl' => $imgurl
                    ]
                ]);
            }
        } else {
            return response()->json([
                'code'  => '3002',
                'msg'   => '没有文件'
            ]);
        }

    }
}
