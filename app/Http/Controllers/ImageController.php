<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = new Article();
        $article->title = $request->title;
        $article->body = $request->body;

        if($article->save()) {
            $files = [];
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as  $file) {
                    $name = time().rand(1,100).'.'.$file->extension();
                    $file->move(public_path('images'), $name);
                    $files[] = ['article_id' => $article->id, 'image_id' => $name];
                }
            }

            DB::table('article_images')->insert($files);

            return response()->json(['message'=>'Article created', 'data'=>$article], 200);
        }

        return response()->json(['message'=>'error article create fail!'], 503);
    }
}
