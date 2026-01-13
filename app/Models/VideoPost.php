<?php

namespace App\Models;

use Database\Factories\VideoPostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Видео пост
 *
 * @mixin \EloquentTypeHinting
 *
 * @property int $id Идентификатор
 * @property string $title Наименование
 * @property string $description Описание
 * @property string $url Сохраняемая часть ссылки на youtube.com
 *
 * @property-read Comment[] $comments Комментарии
 */
class VideoPost extends Model
{
    /** @use HasFactory<VideoPostFactory> */
    use HasFactory;

	/**
	 * Название таблицы
	 */
	const TABLE_NANE = "video_posts";

	protected $fillable = [
		'title',
		'description',
		'url',
	];

	/**
	 * Get all of the videoPosts's comments.
	 */
	public function comments(): MorphMany
	{
		return $this->morphMany(Comment::class, 'commentable');
	}
}
