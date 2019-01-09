<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17/12/18
 * Time: 16:08
 */

namespace Memed\Services;


use Illuminate\Support\Facades\Artisan;
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

            $medicamento = $this->medicamento
                ->join('pivot_medicamentos','pivot_medicamentos.id_medicamento','=','medicamentos.id')
                ->join('tipos_targetas','tipos_targetas.id','=','pivot_medicamentos.id_tipo_targeta')
                ->where('titulo','like','%'.$search.'%')
                ->Orwhere('descricao','like','%'.$search.'%')
                ->Orwhere('subtitulo','like','%'.$search.'%')
                ->select('medicamentos.id','titulo','descricao','subtitulo','tarja')
                ->paginate(10);

            if($medicamento->isEmpty()){

                Artisan::call('command:crawler',[
                    'char' => $search
                ]);

                $medicamento = $this->medicamento
                    ->join('pivot_medicamentos','pivot_medicamentos.id_medicamento','=','medicamentos.id')
                    ->join('tipos_targetas','tipos_targetas.id','=','pivot_medicamentos.id_tipo_targeta')
                    ->where('titulo','like','%'.$search.'%')
                    ->Orwhere('descricao','like','%'.$search.'%')
                    ->Orwhere('subtitulo','like','%'.$search.'%')
                    ->select('medicamentos.id','titulo','descricao','subtitulo','tarja')
                    ->paginate(10);

                return $medicamento;
            }
            return $medicamento;
        }
        return $this->medicamento
                    ->join('pivot_medicamentos','pivot_medicamentos.id_medicamento','=','medicamentos.id')
                    ->join('tipos_targetas','tipos_targetas.id','=','pivot_medicamentos.id_tipo_targeta')
                    ->select('medicamentos.id','titulo','descricao','subtitulo','tarja')
                    ->paginate(10);
    }

}