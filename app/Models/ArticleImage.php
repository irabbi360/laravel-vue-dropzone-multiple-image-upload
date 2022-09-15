<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleImage extends Model
{
    use HasFactory;

    protected $table = 'article_images';

    protected $fillable = ['article_id', 'image_id'];

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }
}
