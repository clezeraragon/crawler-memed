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
                ->where('titulo','like','%'.$search.'%')
                ->Orwhere('descricao','like','%'.$search.'%')
                ->Orwhere('subtitulo','like','%'.$search.'%')
                ->select('id','titulo','descricao','subtitulo')
                ->paginate(10);

            if($medicamento->isEmpty()){

                Artisan::call('command:crawler',[
                    'char' => $search
                ]);

                $medicamento = $this->medicamento
                    ->where('titulo','like','%'.$search.'%')
                    ->Orwhere('descricao','like','%'.$search.'%')
                    ->Orwhere('subtitulo','like','%'.$search.'%')
                    ->select('id','titulo','descricao','subtitulo')
                    ->paginate(10);

                return $medicamento;
            }
            return $medicamento;
        }
        return $this->medicamento->select('id','titulo','descricao','subtitulo')->paginate(10);
    }

}