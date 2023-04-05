<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use App\DataTables\RevenuesDataTable;

class RevenueController extends Controller
{
    public function index(RevenuesDataTable $dataTable){

        return $dataTable->render('revenues.index');
        }
    
}
