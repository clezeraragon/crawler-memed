<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 17 Dec 2018 11:51:36 +0000.
 */

namespace Memed\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PivotMedicamento
 * 
 * @property int $id
 * @property int $id_medicamento
 * @property int $id_tipo_targeta
 * @property int $id_tipo_medicamento
 * @property int $id_valor
 * @property int $id_fabricante
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Memed\Models\Fabricante $fabricante
 * @property \Memed\Models\Medicamento $medicamento
 * @property \Memed\Models\TiposMedicamento $tipos_medicamento
 * @property \Memed\Models\TiposTargeta $tipos_targeta
 * @property \Memed\Models\Valor $valore
 *
 * @package Memed\Models
 */
class PivotMedicamento extends Eloquent
{
	protected $casts = [
		'id_medicamento' => 'int',
		'id_tipo_targeta' => 'int',
		'id_tipo_medicamento' => 'int',
		'id_valor' => 'int',
		'id_fabricante' => 'int'
	];

	protected $fillable = [
		'id_medicamento',
		'id_tipo_targeta',
		'id_tipo_medicamento',
		'id_valor',
		'id_fabricante'
	];

	public function fabricante()
	{
		return $this->belongsTo(\Memed\Models\Fabricante::class, 'id_fabricante');
	}

	public function medicamento()
	{
		return $this->belongsTo(\Memed\Models\Medicamento::class, 'id_medicamento');
	}

	public function tipos_medicamento()
	{
		return $this->belongsTo(\Memed\Models\TiposMedicamento::class, 'id_tipo_medicamento');
	}

	public function tipos_targeta()
	{
		return $this->belongsTo(\Memed\Models\TiposTargeta::class, 'id_tipo_targeta');
	}

	public function valor()
	{
		return $this->belongsTo(\Memed\Models\Valor::class, 'id_valor');
	}
}
