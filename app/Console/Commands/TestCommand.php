<?php

namespace App\Console\Commands;

use App\Models\Comment;
use App\Models\News;
use App\Models\VideoPost;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';
    protected $aliases = 't:c';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $videoPostModel = VideoPost::find(1);
//        $newsModel = News::find(1)->cursorPaginate(50);
//		/** @var News $newsModel */
		$comments = Comment::where(COMMENT::FIELD_COMMENTABLE_TYPE, '=',News::TABLE_NANE)
		->cursorPaginate(15);
		;

		dd($comments);
    }
}
