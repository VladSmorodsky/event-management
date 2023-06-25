<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Http\Traits\CanLoadRelationship;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AttendeeController extends Controller
{
    use CanLoadRelationship;

    private array $relations = ['user'];

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Attendee::class, 'attendee');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        if (! Gate::check('see-attendees', $event)) {
            abort(403);
        }
        $attendees = $this->loadRelations($event->attendees()->latest());

        return AttendeeResource::collection($attendees->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $attendee = $this->loadRelations($event->attendees()->create([
            'user_id' => 1
        ]));

        return new AttendeeResource($attendee);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Attendee $attendee)
    {
        if (! Gate::check('see-attendees', $event)) {
            abort(403);
        }

        return new AttendeeResource($this->loadRelations($attendee));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendee $attendee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Attendee $attendee)
    {
//        $this->authorize('delete-attendee', [$event, $attendee]);

        $attendee->delete();

        return response(status: 204);
    }
}
