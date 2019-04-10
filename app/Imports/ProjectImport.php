<?php

namespace App\Imports;

use App\Project;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithProgressBar;

// class ProjectImport implements ToModel
// {
//     /**
//     * @param array $row
//     *
//     * @return \Illuminate\Database\Eloquent\Model|null
//     */
//     public function model(array $row)
//     {
//         //ヘッダー行が存在する場合
//         if(strcmp($row[0], 'プロジェクト名称') == 0) {
//             return null;
//         }

//         return new Project([
//             'project_name'    => $row[0],
//             'order_date'      => $row[1]
//         ]);
//     }

//     public function chunkSize(): int
//     {
//         return 100;
//     }
// }

class ProjectImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithProgressBar
{
    use Importable;

    public function model(array $row)
    {
        return new Project([
            'project_name'              => $row['project_name'],
            'order_date'                => $row['order_date']
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }
    public function chunkSize(): int
    {
        return 100;
    }
}
