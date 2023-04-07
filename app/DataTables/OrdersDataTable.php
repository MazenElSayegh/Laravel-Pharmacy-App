<?php

namespace App\DataTables;

use App\Models\Order;
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

class OrdersDataTable extends DataTable
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
            <a class="btn btn-success mx-1" id="edit" href="{{Route("orders.edit",$id)}}"> edit </a>
            <a class="btn btn-primary mx-1" id="show" href="{{Route("orders.show",$id)}}"> show </a>
            @if($status=="Confirmed")
            <form action="{{Route("payments.checkout",["id"=>$id])}}}" method="post">
            @csrf
            <button class="btn btn-warning mx-1">Checkout</button>
            </form>
            @endif
            <form method="post" class="delete_item mx-1"  id="delete" action="{{Route("orders.destroy",$id)}}">
                @csrf
                @method("DELETE")
                <button onclick="return confirm_delete()" type="submit" class="btn btn-danger" id="delete_{{$id}}">delete</button>
                <script type="text/javascript">
                function confirm_delete() {
                    return confirm("Are you sure you want to delete this order?");
                }
                </script>
            </form>
        </div>')->addColumn('is_insured', function (Order $order) {
            if($order->is_insured==0){
            return "No";
        }else{
        return "Yes";
        }})->setRowId('id')->addColumn('client', function (Order $order) {
            return $order->client_id;
        })->addColumn('address', function (Order $order) {
            return $order->address_id;
        })->addColumn('doctor', function (Order $order) {
            if($order->doctor!=null){
            return $order->doctor->type->name;
            }else{
                return "";
            }
        })->addColumn('pharmacy', function (Order $order) {
            if($order->pharmacy!=null){
            return $order->pharmacy->type->name;
            }else{
                return "";
            }
        })
    ;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        if (auth()->user()->hasRole("doctor")) {
            return $model->where("doctor_id", "=", auth()->user()->typeable_id);
        }elseif(auth()->user()->hasRole("pharmacy")){
            return $model->where("pharmacy_id", "=", auth()->user()->typeable_id);
        }else{
        return $model->newQuery()->select('orders.*');
    }
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('orders-table')
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
            Column::make('client'),
            Column::make('address'),
            Column::make('doctor'),
            Column::make('pharmacy')->visible(auth()->user()->hasRole("admin")),
            Column::make('is_insured'),
            Column::make('status'),
            Column::make('created_at'),
            Column::make('creator_type'),
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
        return 'Orders_' . date('YmdHis');
    }
}
