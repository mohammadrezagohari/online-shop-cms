<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable=["title","description","author_id","image","selected_content","product_category_id","article_category_id"];


    public function author(){

        return $this->belongsTo(User::class);
    }

    public function productCategory(){

        return $this->belongsTo(ProductCategory::class);
    }


    public function articleCategory(){

        return $this->belongsTo(ArticleCategory::class);
    }

    public function scopeWhereTitle($query,$title)
    {
        return $query->where('title','like',"%{$title}%");
    }


    public function scopeWhereAuthorId($query,$author_id)
    {
        return $query->where('author_id','=',$author_id);
    }

    public function scopeWhereSelectedContent($query)
    {
        return $query->where('selected_content','=',1);
    }


    public function scopeWhereProductCategoryId($query,$product_category_id)
    {
        return $query->where('product_category_id','=',$product_category_id);
    }

    public function scopeWhereArticleCategoryId($query,$article_category_id)
    {
        return $query->where('article_category_id','=',$article_category_id);
    }


    public function scopeWhereMostVisited($query)
    {
        return $query->orderBy('count_viewer','desc');
    }

    public function scopeWhereNewest($query)
    {
        return $query->orderBy('created_at','desc');
    }

    



}
