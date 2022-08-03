<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

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
        return view('activities.index')
            ->with(
                [
                    'activities' => $activities,
                    'teamMembers' => $teamMembers
                ]
            );
    }

    /**
     * Display a sorted and filtered
     * listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function sorTedAndFilteredIndex(Request  $request)
    {
        // dd($request->order_by);
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $sortBy = $request->sort_by;
        $orderBy = $request->order_by;
        $sortValue = Schema::hasColumn('activities', $sortBy) ? $sortBy : 'created_at';
        $orderValue = in_array($orderBy, ['desc', 'asc'], true) ? $orderBy : 'desc';

        $activities = Activity::withoutTrashed()
            ->whereBetween('created_at', [
                $startDate ?  $startDate  : date('Y-m-d'),
                $endDate ?  $endDate  : date('Y-m-d')
            ])->orderBy($sortValue, $orderValue)->get();
        $user = auth()->user();
        $teams = $user->ownedTeams;

        $teamMembers = [];
        foreach ($teams as $team) {
            foreach ($team->allUsers() as $user) {
                $teamMembers[$user->name] = $user->id;
            }
        }
        return view('activities.index')
            ->with(
                [
                    'activities' => $activities,
                    'teamMembers' => $teamMembers,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'sortValue' => $sortValue,
                    'orderValue' => $orderValue
                ]
            );
    }

    /**
     * Display a listing of the deleted activities.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $activities = Activity::onlyTrashed()->get();
        $user = auth()->user();
        $teams = $user->ownedTeams;
        $teamMembers = [];
        foreach ($teams as $team) {
            foreach ($team->allUsers() as $user) {
                $teamMembers[$user->name] = $user->id;
            }
        }
        return view('activities.trash',)
            ->with([
                'activities' => $activities,
                'teamMembers' => $teamMembers
            ]);
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
        $new_activity = new Activity();
        $new_activity->title = $validated['title'];
        $new_activity->description = $validated['description'];

        $user_id = (int)$validated['user_id'];
        if ($user_id == 0) {
            $new_activity->user_id = $request->user()->id;
        } elseif ($user_id > 0) {
            $assignee = User::findOrFail($user_id);
            $new_activity->user_id = $assignee->id;
        }
        if (isset($validated['status']) && $validated['status'] == "1")
            $new_activity->status = "done";
        else
            $new_activity->status = "pending";

        if (isset($validated['priority']))
            $new_activity->priority = $validated['priority'];

        $new_activity->save();
        session()->flash('success', 'Saved new Activity');
        return redirect()->route('activity.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        $audits = $activity->audits()->orderBy('created_at', 'desc')->get();
        $auditsModified = [];
        foreach ($audits as $audit) {
            // dd($audit->getModified());
            // $auditKey = array_pop(array_keys($audit[0]));
            if ($audit) {
                array_push($auditsModified, $audit->getModified());
            }
        }
        array_pop($auditsModified);

        // dd($auditsModified);

        // dd($activity->audits()->first()->getModified()['title']['new']);
        return view('activities.show')
            ->with([
                'activity' => $activity,
                'audits' => $auditsModified,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        $user = auth()->user();
        $teams = $user->ownedTeams;
        $teamMembers = [];
        foreach ($teams as $team) {
            foreach ($team->allUsers() as $user) {
                $teamMembers[$user->id] = $user->name;
            }
        }
        return view('activities.edit')
            ->with([
                'activity' => $activity,
                'teamMembers' => $teamMembers
            ]);
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
        $validated = $request->validated();
        // dd($validated);
        $activity->title = $validated['title'];
        $activity->description = $validated['description'];

        $user_id = (int)$validated['user_id'];
        if ($user_id == 0) {
            $activity->user_id = $request->user()->id;
        } elseif ($user_id > 0) {
            $assignee = User::findOrFail($user_id);
            $activity->user_id = $assignee->id;
        }
        if (isset($validated['status']))
            $activity->status = "done";
        else
            $activity->status = "pending";

        if (isset($validated['priority']))
            $activity->priority = $validated['priority'];

        $activity->save();
        session()->flash('success', 'Activity Updated');
        return redirect()->route('activity.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        $deleted = $activity->delete();
        if ($deleted) {
            session()->flash('success', 'Activity successfully moved to trash');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from the trash.
     *
     * @param  int  $activity
     * @return \Illuminate\Http\Response
     */
    public function restore($activityId)
    {
        $activity = Activity::onlyTrashed()->where('id', '=', $activityId)->first();
        if ($activity->exists) {
            $activity->deleted_at = null;
            $activity->save();
            session()->flash('success', 'Successfully Removed Activity ');
            return redirect()->back();
        }
    }

    /**
     * Permanently remove the specified resource from the trash.
     *
     * @param  int  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroyForever($activityId)
    {
        $activity = Activity::onlyTrashed()->where('id', '=', $activityId)->first();
        if ($activity->exists) {
            $activity->forceDelete();
            session()->flash('success', 'Successfully Removed Activity ');
            return redirect()->back();
        }
    }
}
