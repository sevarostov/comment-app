<?php

namespace App\Models;

use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Model\EntityMorphRelation;

Relation::enforceMorphMap([
	'news' => 'App\Models\News',
	'video_posts' => 'App\Models\VideoPost',
	'comments' => 'App\Models\Comment',
]);

/**
 * Комментарий
 *
 * @mixin \EloquentTypeHinting
 *
 * @property int $id Идентификатор записи
 * @property int $commentable_type Тип сущности
 * @property int $commentable_id Идентификатор сущности
 *
 * Связанные модели
 * @property-read Model|News|VideoPost|Comment $commentable Комментируемая сущность
 * @property-read Comment[] $comments Комментарии
 */
class Comment extends Model
{
    /** @use HasFactory<CommentFactory> */
    use HasFactory;

	/**
	 * Тип комментируемой сущности (enum "news", "video_posts","comments")
	 */
	const FIELD_COMMENTABLE_TYPE = "commentable_type";

	/**
	 * ID комментируемой сущности
	 */
	const FIELD_COMMENTABLE_ID = "commentable_id";

	/**
	 * Название таблицы
	 */
	const TABLE_NANE = "comments";

	/**
	 * Приведение к типам
	 *
	 * @var array
	 */
	protected $casts = [
		self::FIELD_COMMENTABLE_ID => "int",
	];

	protected $fillable = [
		'user_id',
		'commentable_id',
		'commentable_type',
		'text',
	];

	/**
	 * Get the parent commentable model (news, video_post or comment).
	 */
	public function commentable(): MorphTo
	{
		return $this->morphTo(__FUNCTION__, 'commentable_type', 'commentable_id');
	}

	/**
	 * Get all of the comment's comments.
	 */
	public function comments(): MorphMany
	{
		return $this->morphMany(Comment::class, 'commentable');
	}
}
