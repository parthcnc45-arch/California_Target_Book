<?php

use Illuminate\Database\Seeder;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $poll1 = factory(App\Polls\Poll::class)->create();
        $poll2 = factory(App\Polls\Poll::class)->states('past')->create();
        $poll3 = factory(App\Polls\Poll::class)->states('future')->create();

        $range_questions1 = $poll1->questions()->saveMany(factory(\App\Polls\PollQuestion::class, 3)->make()->all());
        $mc_questions1 = $poll1->questions()->saveMany(factory(\App\Polls\PollQuestion::class, 2)
            ->make(['type' => \App\Polls\PollQuestion::MULTIPLE_CHOICE])->all());
        collect($mc_questions1)->each(function ($q) {
            $q->answerOptions()->saveMany(factory(\App\Polls\PollAnswerOption::class, 4)->make()->all());
        });

        $range_questions2 = $poll2->questions()->saveMany(factory(\App\Polls\PollQuestion::class, 3)->make()->all());
        $mc_questions2 = $poll2->questions()->saveMany(factory(\App\Polls\PollQuestion::class, 2)
            ->make(['type' => \App\Polls\PollQuestion::MULTIPLE_CHOICE])->all());
        collect($mc_questions2)->each(function ($q) {
            $q->answerOptions()->saveMany(factory(\App\Polls\PollAnswerOption::class, 4)->make()->all());
        });

        $range_questions3 = $poll3->questions()->saveMany(factory(\App\Polls\PollQuestion::class, 3)->make()->all());
        $mc_questions3 = $poll3->questions()->saveMany(factory(\App\Polls\PollQuestion::class, 2)
            ->make(['type' => \App\Polls\PollQuestion::MULTIPLE_CHOICE])->all());
        collect($mc_questions3)->each(function ($q) {
            $q->answerOptions()->saveMany(factory(\App\Polls\PollAnswerOption::class, 4)->make()->all());
        });
    }
}
