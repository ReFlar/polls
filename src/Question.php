<?php
/*
 * This file is part of reflar/polls.
 *
 * Copyright (c) ReFlar.
 *
 * http://reflar.io
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Reflar\Polls;

use DateTime;
use Flarum\Core\Discussion;
use Flarum\Database\AbstractModel;

class Question extends AbstractModel
{
    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var string
     */
    protected $table = 'polls';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'discussion_id',
        'user_id',
    ];

    /**
     * @var array
     */
    protected $visible = [
        'question',
        'discussion_id',
    ];

    public function isEnded() {
        if (new DateTime() >= new DateTime($this->end_date)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function answers()
    {
        return $this->hasMany(Answer::class, 'poll_id')->orderBy('created_at', 'ASC');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany(Vote::class, 'poll_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function discussions()
    {
        return $this->belongsToMany(Discussion::class);
    }

    /**
     * @param $questionText
     * @param $discussionId
     * @param $actorId
     * @param $endDate
     *
     * @return static
     */
    public static function build($questionText, $discussionId, $actorId, $endDate)
    {
        $question = new static();

        $question->question = $questionText;
        $question->discussion_id = $discussionId;
        $question->user_id = $actorId;
        $question->end_date = $endDate;

        return $question;
    }
}
