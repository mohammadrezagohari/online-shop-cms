<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmazingSale extends Model
{
    use HasFactory,SoftDeletes;


    protected $guarded= ["id"];
    protected  $table="amazing_sales";


    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',

    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeWhereProductId($query ,$product_id)
    {
        return $query->where('product_id','=',$product_id);
    }

    public function scopeWhereStatus($query,$status)
    {
        return $query->where('status','=',$status);
    }


}


