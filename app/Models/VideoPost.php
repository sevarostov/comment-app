<?php

namespace App\Models;

use Database\Factories\VideoPostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Видео пост
 *
 * @property int $id Идентификатор
 * @property string $title Наименование
 * @property string $description Описание
 * @property string $url Сохраняемая часть ссылки на youtube.com
 *
 */
class VideoPost extends Model
{
    /** @use HasFactory<VideoPostFactory> */
    use HasFactory;

	protected $fillable = [
		'title',
		'description',
		'url',
	];
}
