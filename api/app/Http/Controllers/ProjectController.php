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
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     *  --------------------------------------------------
     * Display a listing of the resource.
     *  --------------------------------------------------
     * @return \Illuminate\Http\Response
     * --------------------------------------------------   
     */
    public function index(IndexRequest $request, Project $project)
    {
        // allocate resources
        $perPage = $request->get('per_page');
        $sortOrder = $request->get('sort_order') ?? 'DESC';

        // init query builder
        $query = Project::query();
        // sort and execute
        $query = $query->orderBy('projects.id', $sortOrder);
        $projects = $query->paginate($perPage ?: $query->count());

        return ProjectResource::collection($projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * --------------------------------------------------
     * Store a newly created resource in storage.
     * --------------------------------------------------
     * @param  \Illuminate\Http\StoreRequest  $request
     * @return \Illuminate\Http\Response
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
     * @param  \Illuminate\Http\ShowRequest  $request
     * @param  int\Project $project
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function show(ShowRequest $request, Project $project)
    {
        return new ProjectResource($project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * --------------------------------------------------
     * Update the specified resource in storage.
     * --------------------------------------------------
     * @param  \Illuminate\Http\UpdateRequest  $request
     * @param  int\Project $project
     * @return \Illuminate\Http\Response
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
     * @param  \Illuminate\Http\UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
