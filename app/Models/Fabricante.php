<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 17 Dec 2018 11:51:36 +0000.
 */

namespace Memed\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Fabricante
 * 
 * @property int $id
 * @property string $titulo
 * @property string $fabricante_slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $pivot_medicamentos
 *
 * @package Memed\Models
 */
class Fabricante extends Eloquent
{
	protected $fillable = [
		'titulo',
		'fabricante_slug'
	];

	public function pivot_medicamentos()
	{
		return $this->hasMany(\Memed\Models\PivotMedicamento::class, 'id_fabricante');
	}
}
