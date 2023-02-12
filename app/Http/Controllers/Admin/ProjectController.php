<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Type;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(){
        $users = User::all();

        $projects = Project::all();

        $types = Type::all();

        return view("admin.index", compact('users', 'projects', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "NUOVO PROGETTO";

        $types = Type::all();

        return view("admin.create", compact('title', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        
        if (key_exists("cover_img", $data)) {
            
            $path = Storage::put("posts", $data["cover_img"]);
        }

        $project = Project::create($data);
        $project->cover_img = $path;
        $project->save();

        return redirect()->route('projects.show', $project->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        // $project = Project::findOrFail($id);

        return view('admin.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project) {
        $types = Type::all();

        return view('admin.edit', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        $project->update($data);

        // carico il file solo se ne ricevo uno
        if (key_exists("cover_img", $data)) {
            $path = Storage::put("posts", $data["cover_img"]);
            Storage::delete($project->cover_img);

            $project->cover_img = $path;
        }

        $project->save();

        return redirect()->route('projects.show', $project->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
    
        if ($project->cover_img) {
            Storage::delete($project->cover_img);
        }
    
        $project->delete();

        return redirect()->route("dashboard");
    }
}
