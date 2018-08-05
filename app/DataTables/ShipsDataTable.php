<?php

namespace App\DataTables;

use App\Ship;
use App\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class ShipsDataTable extends DataTable
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
            ->editColumn('name', function($query){
                return sprintf('<a href="%s">%s</a>', route("view_ship", $query->id), $query->name);
            })
            ->orderColumn('id', '-id $1')
            ->addColumn('action', 'ship_datatable_button',['userList'=>$userList])
            ->rawColumns(['name', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Ship $model)
    {
        return $model->select(['id', 'imo', 'name', 'mmsi', 'build',
            DB::raw('(SELECT GROUP_CONCAT(users.name) FROM `share_ships`as share 
INNER JOIN users ON users.id = share.to_user_id
WHERE share.status = 1 AND share.ship_id=ships.id) as accept_request')])
            ->where('user_id', auth()->user()->id);

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
            ['data' => 'imo', 'name' => 'imo', 'title' => 'IMO'],
            ['data' => 'mmsi', 'name' => 'mmsi', 'title' => 'MMSI'],
            ['data' => 'build', 'name' => 'build', 'title' => 'Build'],
            ['data' => 'accept_request', 'name' => 'accept_request', 'title' => 'Accepted Request'],
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
