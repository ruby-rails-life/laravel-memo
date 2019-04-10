<?php

namespace App\Exports;

use App\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

// class ProjectExport implements FromCollection
// {
//     *
//     * @return \Illuminate\Support\Collection
    
//     public function collection()
//     {
//         return Project::all();
//     }
// }

class ProjectExport implements FromView
{

    private $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return $this->view;
    }
}
