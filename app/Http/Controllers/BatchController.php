<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use App\Imports\BatchImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BatchController extends Controller
{
    public function index(): LengthAwarePaginator
    {
        $batches = Batch::query()
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        foreach ($batches as $batch) {
            $completedFirstStep = $batch->items
                ->where('count_1', '>', 0);

            $completedSecondStep = $batch->items
                ->where('count_2', '>', 0);

            if($completedFirstStep->count() === $batch->items->count()) {
                $batch->completedFirstStep = true;
            } else {
                $batch->completedFirstStep = false;
            }

            if($completedSecondStep->count() === $batch->items->count()) {
                $batch->completedSecondStep = true;
            } else {
                $batch->completedSecondStep = false;
            }

            if($batch->completedFirstStep && $batch->completedSecondStep) {
                $batch->finalised = true;
            } else {
                $batch->finalised = false;
            }

            $batch->hasQuantityVariances = $this->hasQuantityVariance($batch);
            $batch->hasCountVariances = $this->hasCountVariance($batch);

            unset($batch->items);
        }

        return $batches;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'file' => 'required|mimes:xlsx,xls,csv,txt|max:2048',
        ]);

        $batch = Batch::query()->create([
            'name' => request('name'),
            'company_name' => request('company_name'),
        ]);

        Excel::import(new BatchImport($batch), request()->file('file'));

        return $batch->load('items');
    }

    public function show(Batch $batch): Batch
    {
        return $batch->load('items');
    }

    public function update(Batch $batch): Batch
    {
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
        ]);

        return Batch::query()->updateOrCreate($batch->toArray());
    }

    public function destroy(Batch $batch): bool
    {
        return $batch->delete();
    }

    public function items(Batch $batch): Batch
    {
        return $batch->load('items');
    }

    private function hasQuantityVariance(Batch $batch): bool
    {
         foreach ($batch->items as $item)
         {
            if ($item->count_1 !== $item->quantity) {
                return true;
            }
        }

         return false;
    }

    private function hasCountVariance(Batch $batch): bool
    {
        foreach ($batch->items as $item)
        {
            if ($item->count_1 !== $item->count_2) {
                return true;
            }
        }

        return false;
    }
}
