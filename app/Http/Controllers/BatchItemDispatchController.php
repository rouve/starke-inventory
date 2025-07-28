<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class BatchItemDispatchController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(Batch $batch): int
    {
        request()->validate([
            'item_no' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        $exploded = explode('/', request()->get('item_no'));

        if(isset($exploded[1])){
            $batchItem = $batch->items()->where('item_no', $exploded[1])->first();

            return $batchItem->update([
                'count_1_user_id' => $user->id,
                'count_1' => $batchItem->count_1 + 1,
            ]);
        }

        return 0;
    }

    public function destroy(Batch $batch): int|bool
    {
        request()->validate([
            'item_no' => 'required|string|max:255',
        ]);

        $batchItem = $batch->items()->where('item_no', request('item_no'))->first();

        if($batchItem){
            return $batchItem->update([
                'count_1' => 0
            ]);
        }

        return false;
    }
}
