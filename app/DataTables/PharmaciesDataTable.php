<?php

namespace App\DataTables;

use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PharmaciesDataTable extends DataTable
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
                    <a class="btn btn-success mx-1" id="edit" href="{{Route("pharmacies.edit",$id)}}"> edit </a>
                    <a class="btn btn-primary mx-1" id="show" href="{{Route("pharmacies.show",$id)}}"> show </a>
                    @if(auth()->user()->hasRole("admin"))
                    <form method="post" class="delete_item mx-1"  id="delete" action="{{Route("pharmacies.destroy",$id)}}">
                        @csrf
                        @method("DELETE")
                        <button onclick="return confirm_delete()" type="submit" class="btn btn-danger" id="delete_{{$id}}">delete</button>
                        <script type="text/javascript">
                        function confirm_delete() {
                        return confirm("Are you sure you want to delete this pharmacy?");
                        }
                        </script>
                    </form>
                    @endif
                </div>')->setRowId('id')->addColumn('name', function (Pharmacy $pharmacy) {
                    return $pharmacy->type->name;
                })->addColumn('area', function (Pharmacy $pharmacy) {
                    return $pharmacy->area->name;
                })->addColumn('email', function (Pharmacy $pharmacy) {
                    return $pharmacy->type->email;
                })
            ;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Pharmacy $model): QueryBuilder
    {
        if (auth()->user()->hasRole("pharmacy")) {
            return $model->where("id", "=", auth()->user()->typeable_id);
        }else{
        return $model->newQuery()->select('pharmacies.*');
    }
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pharmacies-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
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
            Column::make('name'),
            Column::make('national_id'),
            Column::make('email'),
            Column::make('priority'),
            Column::make('area'),
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
        return 'Pharmacies_' . date('YmdHis');
    }
}
