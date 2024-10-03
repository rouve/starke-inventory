<?php

namespace App\Http\Controllers;

use App\Models\Batch;

class BatchItemItemsOutController extends Controller
{
    public function update(Batch $batch, $batchItem): int
    {
        request()->validate([
            'count' => 'required|integer|min:1',
        ]);

        $user = auth()->user();

        return $batch->items()->where('item_no', $batchItem)->update([
            'count_2_user_id' => $user->id,
            'count_2' => request()->get('count')
        ]);
    }
}
