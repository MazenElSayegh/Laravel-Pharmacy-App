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

class RevenuesDataTable extends DataTable
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
               <img src="{{asset("/storage/" . $image_path)}}" style="width:50px;height:50px;border-radius:50%">'
        )->setRowId('id')->addColumn('Pharmacy Name', function (Pharmacy $pharmacy) {
            return $pharmacy->type->name;
        })->addColumn('Total Orders', function (Pharmacy $pharmacy) {
            return $pharmacy->orders->count();
        })->addColumn('Total Revenue', function (Pharmacy $pharmacy) {
            $totalPrice=0;
            foreach($pharmacy->orders as $order){
                if($order->status=='Confirmed'){
                    $totalPrice+=$order->total_price;
                }
            }
            return $totalPrice." $";
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
            Column::computed('action')->title("Pharmacy Avatar")->exportable(false)
            ->printable(false)
            ->addClass('text-center'),
            Column::make('Pharmacy Name')->visible(auth()->user()->hasRole("admin")),
            Column::make('Total Orders'),
            Column::make('Total Revenue'),
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
