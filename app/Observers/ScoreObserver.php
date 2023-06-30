<?php

namespace App\Observers;

use App\Models\Score;

class ScoreObserver
{
    /**
     * Handle the Score "created" event.
     *
     * @param  \App\Models\Score  $score
     * @return void
     */
    public function created(Score $score)
    {
        //
    }

    /**
     * Handle the Score "updated" event.
     *
     * @param  \App\Models\Score  $score
     * @return void
     */
    public function updated(Score $score)
    {
        $score->update([
            'total' => totalSubjectScore($score->ca1, $score->ca2, $score->em, $score->pm, $score->bm),
        ]);
    }

    /**
     * Handle the Score "deleted" event.
     *
     * @param  \App\Models\Score  $score
     * @return void
     */
    public function deleted(Score $score)
    {
        //
    }

    /**
     * Handle the Score "restored" event.
     *
     * @param  \App\Models\Score  $score
     * @return void
     */
    public function restored(Score $score)
    {
        //
    }

    /**
     * Handle the Score "force deleted" event.
     *
     * @param  \App\Models\Score  $score
     * @return void
     */
    public function forceDeleted(Score $score)
    {
        //
    }
}