<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Photo;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::latest('created_at')->paginate(10);
        return View('photos.create')->with('photos',$photos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return View('photos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
 
        $fileName = $input['fileName']->getClientOriginalName();
        $fileName = time()."@".$fileName;
        $image = Image::make($input['fileName']->getRealPath());
 
        //画像リサイズ ※追加
        $image->resize(100, null, function ($constraint) {
              $constraint->aspectRatio();
        });
 
        // $image->save(storage_path() . '/images/' . $fileName);
        // $path = '/images/' . $fileName;
        $path = Storage::disk('public')->putFileAs(
            'images', $request->file('fileName'), $fileName
        );
 
        //↓ 追加 ↓
        $photo = new Photo();
        $photo->path = 'images/' . $fileName;
        $photo->save();
 
        return redirect('/photos')->with('status', 'ファイルアップロードの処理完了！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
