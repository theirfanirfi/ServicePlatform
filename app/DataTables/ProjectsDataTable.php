<?php

namespace App\DataTables;

use App\Project;
use App\ProjectInvitation;
use App\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class ProjectsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $userList = User::all();

        return datatables($query)
            ->orderColumn('id', '-id $1')
            ->addColumn('action', 'project_datatable_button',['userList'=>$userList])
            ->rawColumns(['name', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Project $model)
    {
        return $model->select(['id', 'user_id', 'name', 'date', 'port', 'closed'])
            ->where('user_id', auth()->user()->id)
            ->orWhereIn('id', ProjectInvitation::where(['invited_user_id' => auth()->user()->id, 'status' => true])->pluck('project_id'));

//        return $this->applyScopes(
//                    Item::select(['item.id', 'item.subcategoria_id', 'item.nombre', 'item.precio'])
//                    ->with(['subcategoria', 'subcategoria.categoria'])
//                );
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
//                    ->addAction(['width' => '80px'])
            ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['data' => 'id', 'name' => 'id', 'title' => 'Id', 'printable' => false],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'date', 'name' => 'date', 'title' => 'Date'],
            ['data' => 'port', 'name' => 'port', 'title' => 'Port'],
            ['data' => 'closed', 'name' => 'closed', 'title' => 'Closed'],
            ['data' => 'action', 'title' => '', 'orderable' => false, 'searchable' => false, 'printable' => false],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Ships_' . date('YmdHis');
    }

    /**
     * Get default builder parameters.
     *
     * @return array
     */
    protected function getBuilderParameters()
    {
        return [
            "dom" => "Bfrtip",
        ];
    }
}
