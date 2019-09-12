<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\DeleteRequest;
use App\Http\Requests\Project\IndexRequest;
use App\Http\Requests\Project\ShowRequest;
use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Http\Resources\Common\DeleteResource;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    /**
     *  --------------------------------------------------
     * Display a listing of the resource.
     *  --------------------------------------------------
     * @param IndexRequest $request
     * @return ProjectResource|AnonymousResourceCollection
     * --------------------------------------------------
     */
    public function index(IndexRequest $request)
    {
        // allocate resources
        $perPage = $request->get('per_page');
        $sortOrder = $request->get('sort_order') ?? 'DESC';

        // init query builder
        $query = Project::query();
        // search keyword
        if ($request->has('keyword') && strlen($request->get('keyword')) >= 2) {
            // search fields
            $searchFields = ['name', 'url'];
            $query->search($searchFields, $request->get('keyword'));
        }
        // sort and execute
        $query = $query->orderBy('projects.id', $sortOrder);
        $projects = $query->paginate($perPage ?: $query->count());

        return ProjectResource::collection($projects);
    }

    /**
     * --------------------------------------------------
     * Store a newly created resource in storage.
     * --------------------------------------------------
     * @param StoreRequest $request
     * @return ProjectResource
     * --------------------------------------------------
     */
    public function store(StoreRequest $request)
    {
        $memberId = session()->get('member_id') ?? 1;

        $project = new Project();
        $project->member_id = $memberId;
        $project->name = $request->get('name');
        $project->url = $request->get('url');
        if ($request->has('description')) {
            $project->description = $request->get('description');
        }
        $project->save();
        return new ProjectResource($project);
    }

    /**
     * --------------------------------------------------
     * Display the specified resource.
     * --------------------------------------------------
     * @param ShowRequest $request
     * @param Project $project
     * @return ProjectResource
     * --------------------------------------------------
     */
    public function show(ShowRequest $request, Project $project)
    {
        return new ProjectResource($project);
    }

    /**
     * --------------------------------------------------
     * Update the specified resource in storage.
     * --------------------------------------------------
     * @param UpdateRequest $request
     * @param Project $project
     * @return ProjectResource
     * --------------------------------------------------
     */
    public function update(UpdateRequest $request, Project $project)
    {
        $project->name = $request->get('name') ?? $project->name;
        $project->url = $request->get('url') ?? $project->url;
        $project->save();
        return new ProjectResource($project);
    }

    /**
     * --------------------------------------------------
     * Remove the specified resource from storage.
     * --------------------------------------------------
     * @param DeleteRequest $request
     * @param Project $project
     * @return DeleteResource
     * @throws AuthorizationException
     * --------------------------------------------------
     */
    public function destroy(DeleteRequest $request, Project $project)
    {
        if ($project->delete()) {
            return new DeleteResource([]);
        }
        throw new AuthorizationException('Forbidden you cannot delete project');
    }
}
