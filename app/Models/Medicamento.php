<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 17 Dec 2018 11:51:36 +0000.
 */

namespace Memed\Models;

use Memed\Traits\FullTextSearch;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Medicamento
 * 
 * @property int $id
 * @property string $titulo
 * @property string $controle_especial
 * @property string $descricao
 * @property string $status
 * @property string $receituario
 * @property string $subtitulo
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $pivot_medicamentos
 *
 * @package Memed\Models
 */
class Medicamento extends Eloquent
{

    use FullTextSearch;

	protected $fillable = [
		'titulo',
		'controle_especial',
		'descricao',
		'status',
		'receituario',
		'subtitulo'
	];

    protected $searchable = [
        'titulo'
    ];

	public function pivot_medicamentos()
	{
		return $this->hasMany(\Memed\Models\PivotMedicamento::class, 'id_medicamento');

	}
}
