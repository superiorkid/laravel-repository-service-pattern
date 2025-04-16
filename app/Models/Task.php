<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        "title",
        "slug",
        "description",
        "category_id",
        "status",
        "priority",
        "due_date",
        "completed_at"
    ];

    protected $casts = [
        "due_date" => "datetime",
        "completed_at" => "datetime"
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }
}
