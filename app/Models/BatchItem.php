<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BatchItem extends Model
{
    use HasFactory;
    protected $fillable = ['batch_id', 'item_no', 'name', 'quantity', 'end_1', 'end_2', 'end_3', 'end_4', 'item_length_angle', 'area', 'insulation', 'connector_1', 'connector_2', 'notes', 'long_side', 'count_1', 'count_2', 'variance', 'count_1_user_id', 'count_2_user_id', 'batch_id'];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function scopeNoSecondCount($query){
        return $query->where(function ($query){
            $query->whereIsNull('count_2');
            $query->whereIsNull('count_2_user_id');
        });
    }

    public function scopeNotCounted($query){
        return $query->where(function ($query){
            $query->whereIsNull('count_1');
            $query->whereIsNull('count_2');
        });
    }
}
