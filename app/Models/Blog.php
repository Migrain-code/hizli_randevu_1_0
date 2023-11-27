<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Blog extends Model
{
    use HasFactory, HasTranslations;

    protected $translatable = ['titles', 'descriptions', 'meta_titles', 'slug'];

    public function getTitle()
    {
        return $this->translate('titles');
    }

    public function getSlug()
    {
        return $this->translate('slug');
    }

    public function getDescription()
    {
        return $this->translate('descriptions');
    }
    public function getMetaTitle()
    {
        return $this->translate('meta_titles');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'blog_id', 'id')->where('status', 1);
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function social()
    {
        return $this->hasOne(BlogSocial::class, 'blog_id', 'id');
    }
}
