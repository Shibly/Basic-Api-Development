<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TasksResource;
use App\Models\Task;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return TasksResource::collection(
            Task::where('user_id', Auth::user()->id)->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaskRequest $request
     * @return TasksResource|Response
     */
    public function store(StoreTaskRequest $request): TasksResource|Response
    {
        $request->validated($request->all());

        $task = Task::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority
        ]);

        return new TasksResource($task);
    }

    /**
     * Display the specified resource. On resourceful routing, Laravel already knows that the id is passing through, so you can pass the entire task object.
     *
     * @param Task $task
     * @return TasksResource
     */
    public function show(Task $task)
    {
        return $this->isNotAuthorized($task) ?: new TasksResource($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Task $task
     * @return TasksResource
     */
    public function update(Request $request, Task $task): TasksResource
    {
        $task->update($request->all());
        return new TasksResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return bool|JsonResponse|null
     */
    public function destroy(Task $task)
    {
        return $this->isNotAuthorized($task) ?: $task->delete();
    }


    private function isNotAuthorized($task)
    {
        if (Auth::user()->id !== $task->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }
    }

}
