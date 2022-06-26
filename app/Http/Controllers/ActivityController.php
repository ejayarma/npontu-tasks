<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::withoutTrashed()->get();
        $user = auth()->user();
        $teams = $user->ownedTeams;
        $teamMembers = [];
        foreach ($teams as $team) {
            foreach ($team->allUsers() as $user) {
                $teamMembers[$user->name] = $user->id;
            }
        }
        return view(
            'activities.index',
            [
                'activities' => $activities,
                'teamMembers' => $teamMembers
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        $teams = $user->ownedTeams;
        $teamMembers = [];
        foreach ($teams as $team) {
            foreach ($team->allUsers() as $user) {
                $teamMembers[$user->name] = $user->id;
            }
        }
        return view('activities.create', ['teamMembers' => $teamMembers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreActivityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreActivityRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);
        $new_activity = new Activity();
        $new_activity->title = $validated['title'];
        $new_activity->description = $validated['description'];

        $assignee_id = (int)$validated['assigned_to'];
        if ($assignee_id == 0) {
            $new_activity->assigned_to = $request->user()->id;
        } elseif ($assignee_id > 0) {
            $assignee = User::findOrFail($assignee_id);
            $new_activity->assigned_to = $assignee->id;
        }
        if (isset($validated['status']))
            $new_activity->status = $validated['status'];
        if (isset($validated['priority']))
            $new_activity->priority = $validated['priority'];

        $new_activity->save();
        session()->flash('success', 'Saved new Activity');
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateActivityRequest  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
    }
}
