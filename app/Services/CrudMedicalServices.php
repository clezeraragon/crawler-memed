<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13/12/18
 * Time: 18:14
 */

namespace Memed\Services;


use Memed\Models\Fabricante;
use Memed\Models\Medicamento;
use Memed\Models\PivotMedicamento;
use Memed\Models\TiposMedicamento;
use Memed\Models\TiposTargeta;
use Memed\Models\Valor;

class CrudMedicalServices
{

    protected $medicamento;
    protected $pivotMedicamento;
    protected $fabricante;
    protected $tiposMedicamento;
    protected $tiposTargeta;
    protected $valor;
    protected $medicalServices;

    public function __construct(
        Medicamento $medicamento,
        PivotMedicamento $pivotMedicamento,
        Fabricante $fabricante,
        TiposMedicamento $tiposMedicamento,
        TiposTargeta $tiposTargeta,
        Valor $valor,
        MedicalServices $medicalServices)
    {
        $this->medicamento = $medicamento;
        $this->pivotMedicamento = $pivotMedicamento;
        $this->fabricante = $fabricante;
        $this->tiposMedicamento = $tiposMedicamento;
        $this->tiposTargeta = $tiposTargeta;
        $this->valor = $valor;
        $this->medicalServices = $medicalServices;

    }

    public function store($param)
    {

        try{

            \DB::beginTransaction();

            $data = $this->medicalServices->processCrawlerMemed($param);

            foreach ($data['attributes'] as $attributes){

                    if(isset($attributes)) {

                        $medicamento = $this->medicamento->firstOrCreate([
                            'titulo' => $attributes['titulo'],
                            'controle_especial' => $attributes['controle_especial'],
                            'descricao' => $attributes['descricao'],
                            'status' => $attributes['status'],
                            'receituario' => $attributes['receituario'],
                            'subtitulo' => $attributes['subtitulo']
                        ]);

                        $fabricante = $this->fabricante->firstOrCreate([
                            'titulo' => $attributes['fabricante'],
                            'fabricante_slug' => $attributes['fabricante_slug']
                        ]);
                        $tipo_medicamento = $this->tiposMedicamento->firstOrCreate([
                            'titulo' => $attributes['tipo'],
                            'forma_fisica' => $attributes['forma_fisica']
                        ]);
                        $valor = $this->valor->create([
                            'preco' => $attributes['preco'],
                            'preco_maximo' => $attributes['preco_maximo'],
                            'preco_minimo' => $attributes['preco_minimo']
                        ]);

                        $tipo_targeta = $this->tiposTargeta->firstOrCreate([
                            'thunbnail' => (isset($attributes['thunbnail']) ? $attributes['thunbnail'] : ''),
                            'tarja' => (isset($attributes['tarja']) ? $attributes['tarja'] : '')
                        ]);

                        $this->pivotMedicamento->firstOrCreate([
                            'id_medicamento' => $medicamento->id,
                            'id_tipo_targeta' => $tipo_targeta->id,
                            'id_tipo_medicamento' => $tipo_medicamento->id,
                            'id_valor' => $valor->id,
                            'id_fabricante' => $fabricante->id
                        ]);

                    }

            }
            \DB::commit();
            return response()->json(['status' => [
                'success' => 'Registros criados com sucesso!',
                'total de registros buscados' => $data['total']]
            ]);

        }catch (\Exception $ex){
            \DB::rollback();
            return response()->json(['status' => ['error' => 'Erro interno: ' . $ex->getMessage() . ' (' . $ex->getFile() . '/' . $ex->getLine() . ')']], 500);
        }

    }


}