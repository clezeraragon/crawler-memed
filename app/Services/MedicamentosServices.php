<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17/12/18
 * Time: 16:08
 */

namespace Memed\Services;


use Memed\Models\Medicamento;

class MedicamentosServices
{

    protected $medicamento;

    public function __construct( Medicamento $medicamento)
    {
      $this->medicamento = $medicamento;
    }

    public function lists($search = null)
    {
        if($search){
            return $this->medicamento
                ->where('titulo','like','%'.$search.'%')
                ->Orwhere('descricao','like','%'.$search.'%')
                ->Orwhere('subtitulo','like','%'.$search.'%')
                ->paginate(10);
        }
        return $this->medicamento->select('id','titulo')->paginate(10);
    }

}