<?php

namespace Memed\Http\Controllers;

use Memed\Services\CrudMedicalServices;
use Memed\Services\MedicalServices;
use Memed\Services\MedicamentosServices;

class MemedController extends Controller
{

    protected $crudMedicalServices;
    protected $medicamentosServices;

    public function __construct(CrudMedicalServices $crudMedicalServices,MedicamentosServices $medicamentosServices)
    {
        $this->crudMedicalServices = $crudMedicalServices;
        $this->medicamentosServices = $medicamentosServices;
    }

    public function store($param)
    {
        return $this->crudMedicalServices->store($param);
    }
    public function lists( $search = null)
    {
        return $this->medicamentosServices->lists($search);
    }
}
