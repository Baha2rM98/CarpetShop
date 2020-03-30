<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

class PhotoController extends Controller
{
    /**
     * Stores a newly uploaded file in storage.
     *
     * @param  Request  $request
     * @return JsonResponse|Response|RedirectResponse
     * @throws Throwable
     */
    public function uploadPhoto(Request $request)
    {
        $this->photoValidator($request);
        $uploadedFile = $request->file('file');
        $fileName = time().$uploadedFile->getClientOriginalName();
        $originalName = $uploadedFile->getClientOriginalName();
        $photo = new Photo();
        $photo->original_name = $originalName;
        $photo->path = $fileName;
        $photo->saveOrFail();
        Storage::disk('local')->putFileAs('public/photos', $uploadedFile, $fileName);
        return response()->json(['photo_id' => $photo->id]);
    }

    /**
     * Validates uploaded photos
     *
     * @param  Request  $request
     * @return array
     * @throws ValidationException
     */
    private function photoValidator(Request $request)
    {
        return $this->validate($request, ['file' => ['bail', 'image', 'max:4096']], [
            'file.image' => 'فایل آپلود شده باید از نوع عکس باشد!',
            'file.max' => 'حجم تصویر آپلود شده نمیتواند بیشتر از 8 مگابایت باشد!'
        ]);
    }
}
