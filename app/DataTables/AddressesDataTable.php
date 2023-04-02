<?php

namespace App\DataTables;

use App\Models\Address;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AddressesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', '
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <a class="btn btn-success mx-1" id="edit" href="{{Route("addresses.edit",$id)}}"> edit </a>
            <a class="btn btn-primary mx-1" id="show" href="{{Route("addresses.show",$id)}}"> show </a>
            <form method="post" class="delete_item mx-1"  id="delete" action="{{Route("addresses.destroy",$id)}}">
                @csrf
                @method("DELETE")
                <button onclick="return confirm_delete()" type="submit" class="btn btn-danger" id="delete_{{$id}}">delete</button>
                <script type="text/javascript">
                function confirm_delete() {
                return confirm("Are you sure you want to delete this address?");
                }
                </script>
            </form>
        </div>')
    ;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Address $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('addresses-table')
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
            Column::make('id'),
            Column::make('area_id'),
            Column::make('street_name'),
            Column::make('build_no'),
            Column::make('floor_no'),
            Column::make('flat_no'),
            Column::make('is_main'),
            Column::make('client_id'),
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
        return 'Addresses_' . date('YmdHis');
    }
}
