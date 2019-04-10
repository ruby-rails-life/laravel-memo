<?php

namespace App\Imports;

use App\Project;
use Maatwebsite\Excel\Concerns\ToModel;

class ProjectImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //ヘッダー行が存在する場合
        if(strcmp($row[0], 'プロジェクト名称') == 0) {
            return null;
        }

        return new Project([
            'project_name'    => $row[0],
            'order_date'      => $row[1]
        ]);
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
