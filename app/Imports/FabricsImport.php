<?php

namespace App\Imports;

use App\Models\Fabric;
use App\Models\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FabricsImport implements ToModel, WithHeadingRow
{
    private $duplicates = []; // Store duplicate fabric titles
    private $totalRows = 0; // Store total rows processed

    public function model(array $row)
    {
        $this->totalRows++; // Count total rows

        // Get or create the collection ID
        $collection = Collection::firstOrCreate(['title' => $row['collection_title']]);

        // Check if fabric exists with the same title in the same collection
        $existingFabric = Fabric::where('title', $row['title'])
            ->where('collection_id', $collection->id)
            ->first();

        if ($existingFabric) {
            $this->duplicates[] = $row['title']; // Store duplicate fabric title
            return null; // Skip duplicate entry
        }

        return new Fabric([
            'collection_id' => $collection->id,
            'title' => $row['title'],
            'threshold_price' => $row['threshold_price'] ?? 0,
            'image' => $row['image'] ?? null,
            'status' => strtolower($row['status']) === 'active' ? 1 : 0,
        ]);
    }

    public function getDuplicateError()
    {
        // If all rows are duplicates, return error message
        if ($this->totalRows > 0 && count($this->duplicates) === $this->totalRows) {
            return 'All data in the file already exists.';
        }

        // If some duplicates exist but not all
        // if (!empty($this->duplicates)) {
        //     return 'These fabrics already exist: ' . implode(', ', $this->duplicates);
        // }

        return null;
    }
}
