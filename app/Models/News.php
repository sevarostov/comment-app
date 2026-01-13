<?php

namespace App\Models;

use Database\Factories\NewsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Новость
 *
 * @mixin \EloquentTypeHinting
 *
 * @property int $id Идентификатор
 * @property string $title Наименование
 * @property string $description Описание
 *
 * @property-read Comment[] $comments Комментарии
 */
class News extends Model
{
	/** @use HasFactory<NewsFactory> */
	use HasFactory;

	/**
	 * Название таблицы
	 */
	const TABLE_NANE = "news";

	protected $fillable = [
		'text',
	];

	/**
	 * Get  all of the news's comments.
	 */
	public function comments(): MorphMany
	{
		return $this->morphMany(Comment::class, 'commentable');
	}
}
