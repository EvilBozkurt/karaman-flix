<?php

namespace App\Models;

use App\Contracts\ImageableContract;
use App\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movie extends Model implements ImageableContract
{
    use HasFactory;
    use Imageable;

    /**
     * @var mixed
     */
    protected $guarded = ['id'];

    public function uploadFolder(): string
    {
        return "movies";
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id')->withDefault();
    }
}
