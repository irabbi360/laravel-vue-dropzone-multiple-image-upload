<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Image;
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
                    $files[] = $name;
                }
            }
            
            $imagesID = [];

            foreach($files as $file){
                $image = new Image();
                $image->url = $file;
                $image->save();

                $imagesID[] = ['article_id' => $article->id, 'image_id' => $image->id];
            }
            
            DB::table('article_images')->insert($imagesID);
            // Image::insert($files);

            return response()->json(['message'=>'Article created', 'data'=>$article], 200);
        }

        return response()->json(['message'=>'error article create fail!'], 503);
    }

    public function getArticle($id)
    {
        $article = Article::with('articleImage','articleImage.image')->find($id);
        
        return $article;
    }
}
