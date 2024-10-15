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
            'count' => 'required|integer|min:1',
        ]);

        $user = auth()->user();

        $exploded = explode('/', request()->get('item_no'));

        if(isset($exploded[1])){
            return $batch->items()->where('item_no', $exploded[1])->update([
                'count_1_user_id' => $user->id,
                'count_1' => request()->get('count')
            ]);
        }

        return 0;
    }
}
