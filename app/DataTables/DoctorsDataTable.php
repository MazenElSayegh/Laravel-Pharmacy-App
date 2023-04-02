<?php

namespace App\DataTables;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DoctorsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action','
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <a class="btn btn-success mx-1" id="edit" href="{{Route("doctors.edit",$id)}}"> edit </a>
                <a class="btn btn-primary mx-1" id="show" href="{{Route("doctors.show",$id)}}"> show </a>
                <form method="post" class="delete_item mx-1"  id="delete" action="{{Route("doctors.destroy",$id)}}"> 
                    @csrf
                    @method("DELETE")
                    <button onclick="return confirm_delete()" type="submit" class="btn btn-danger" id="delete_{{$id}}">delete</button>
                </form>
                <a class="btn btn-warning mx-1" href="{{route("doctors.ban",$id)}}">
                <script type="text/javascript">
                function confirm_delete() {
                return confirm("Are you sure you want to delete this doctor?");
                }
                </script>
                @if($is_banned==0) Ban
                @else Unban
                @endif
            </a>
            </div>')->setRowId('id');}

    /**
     * Get the query source of dataTable.
     */
    public function query(Doctor $model): QueryBuilder
    {
        return $model->newQuery()->with([
            'pharmacy','type'
        ])->select('doctors.*');
    }
    

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('doctors-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
                Column::make('type.name')->title('name')->data('type.name'),
                Column::make('national_id'),
                Column::make('type.email')->title('email')->data('type.email'),
                Column::make('is_banned'),
                Column::make('pharmacy.name')->title('pharmacy')->data('pharmacy.name'),
                Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->addClass('text-center'),
            ];
        
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Doctors_' . date('YmdHis');
    }
}