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

use Flarum\Extend;
use Illuminate\Contracts\Events\Dispatcher;
use Reflar\Polls\Api\Controllers;

return [
    (new Extend\Assets('admin'))
        ->asset(__DIR__.'/js/admin/dist/extension.js')
        ->bootstrapper('reflar/polls/main'),
    (new Extend\Assets('forum'))
        ->asset(__DIR__.'/js/forum/dist/extension.js')
        ->asset(__DIR__.'/resources/less/forum.less')
        ->bootstrapper('reflar/polls/main'),
    new Extend\Locales(__DIR__.'/resources/locale'),
    (new Extend\Routes('api'))
        ->get('/votes', 'votes.index', Controllers\ListVotesController::class)
        ->post('/votes', 'votes.create', Controllers\CreateVoteController::class)
        ->post('/answers', 'answers.create', Controllers\CreateAnswerController::class)
        ->get('/questions', 'questions.index', Controllers\ListPollController::class)
        ->patch('/questions/{id}', 'poll.update', Controllers\UpdatePollController::class)
        ->patch('/votes/{id}', 'votes.update', Controllers\UpdateVoteController::class)
        ->patch('/endDate/{id}', 'endDate.update', Controllers\UpdateEndDateController::class)
        ->patch('/answers/{id}', 'answers.update', Controllers\UpdateAnswerController::class)
        ->delete('/questions/{id}', 'poll.delete', Controllers\DeletePollController::class)
        ->delete('/answers/{id}', 'answer.delete', Controllers\DeleteAnswerController::class),
    function (Dispatcher $events) {
        $events->subscribe(Listeners\AddDiscussionPollRelationship::class);
        $events->subscribe(Listeners\AddForumFieldRelationship::class);
        $events->subscribe(Listeners\SavePollToDatabase::class);
    },
];
