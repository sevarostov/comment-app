<?php

namespace App\Models;

use Database\Factories\NewsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Новость
 *
 * @property int $id Идентификатор
 * @property string $title Наименование
 * @property string $description Описание
 *
 */
class News extends Model
{
	/** @use HasFactory<NewsFactory> */
	use HasFactory;

	protected $fillable = [
		'title',
		'description',
	];
}
