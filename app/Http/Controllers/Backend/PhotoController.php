<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Throwable;

class PhotoController extends Controller
{
    /**
     * Stores a newly uploaded file in storage.
     *
     * @param Request $request
     * @return JsonResponse|Response|RedirectResponse
     * @throws Throwable
     */
    public function uploadPhoto(Request $request)
    {
        $this->validate($request, ['file' => ['bail', 'image', 'max:4096']], ['file.image' => 'فایل آپلود شده باید از نوع عکس باشد!',
            'file.max' => 'حجم تصویر آپلود شده نمیتواند بیشتر از 8 مگابایت باشد!']);
        $uploadedFile = $request->file('file');
        $fileName = time() . $uploadedFile->getClientOriginalName();
        $originalName = $uploadedFile->getClientOriginalName();
        Storage::disk('local')->putFileAs('public/photos', $uploadedFile, $fileName);
//        $this->removeDuplicateFiles();
        $photo = new Photo();
        $photo->original_name = $originalName;
        $photo->path = $fileName;
        //TODO: We complete $photo->user_id = (?) after we initialized authentication system.
        $photo->user_id = 1;
        //TODO ------------------------------------------------------------------------------
        $photo->saveOrFail();
        return response()->json(['photo_id' => $photo->id]);
    }

//TODO
//    /**
//     * @deprecated
//     */
//    private function removeDuplicateFiles()
//    {
//        $files = Storage::disk('local')->allFiles('public/photos');
//        $photos = Photo::all();
//        foreach ($files as $file) {
//            foreach ($photos as $photo) {
//                if ($file === 'public/photos/' . $this->getFileAbsolutePath('photos', $photo->path)) {
//                    Storage::disk('local')->delete($file);
//                    $photo->delete();
//                }
//            }
//        }
//    }
}
