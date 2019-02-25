<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 17 Dec 2018 11:51:36 +0000.
 */

namespace Memed\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Valor
 * 
 * @property int $id
 * @property string $preco
 * @property string $preco_maximo
 * @property string $preco_minimo
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $pivot_medicamentos
 *
 * @package Memed\Models
 */
class Valor extends Eloquent
{
    protected $table = 'valores';

	protected $fillable = [
		'preco',
		'preco_maximo',
		'preco_minimo'
	];

	public function pivot_medicamentos()
	{
		return $this->hasMany(\Memed\Models\PivotMedicamento::class, 'id_valor');
	}
}
