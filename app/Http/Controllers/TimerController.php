<?php

namespace App\Http\Controllers;

use App\Timer;
use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimerController extends Controller
{
    /**
     * Save a new project.
     *
     * @param   Request $request
     * @param   int $id
     * @return  array
     */
    public function store(Request $request, int $id)
    {
        $data = $request->validate(['name' => 'required|between:3,100']);

        $timer = Project::mine()->findOrFail($id)
                                ->timers()
                                ->save(new Timer([
                                    'name' => $data['name'],
                                    'user_id' => Auth::user()->id,
                                    'started_at' => new Carbon,
                                ]));

        return $timer->with('project')->find($timer->id);
    }

    /**
     * Get the running timers for user.
     *
     * @return array
     */
    public function running()
    {
        return Timer::with('project')->mine()->running()->first() ?? [];
    }

    /**
     * Stop running the active timer.
     *
     * @return array
     */
    public function stopRunning()
    {
        if ($timer = Timer::mine()->running()->first()) {
            $timer->update(['stopped_at' => new Carbon]);
        }

        return $timer;
    }
}
