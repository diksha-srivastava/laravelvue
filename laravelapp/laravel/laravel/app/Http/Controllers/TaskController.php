<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Interfaces\TaskRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    private TaskRepositoryInterface $TaskRepositoryInterface;
    
    public function __construct(TaskRepositoryInterface $taskRepositoryInterface)
    {
        $this->taskRepositoryInterface = $taskRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->taskRepositoryInterface->index();

        return ApiResponseClass::sendResponse(TaskResource::collection($data),'',200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $details =[
            'title' => $request->title,
            'details' => $request->details
        ];
        DB::beginTransaction();
        try{
             $Task = $this->taskRepositoryInterface->store($details);

             DB::commit();
             return ApiResponseClass::sendResponse('Task Create Successful','',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Task = $this->taskRepositoryInterface->getById($id);

        return ApiResponseClass::sendResponse(new TaskResource($Task),'',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $Task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $updateDetails =[
            'title' => $request->title,
            'details' => $request->details
        ];
        DB::beginTransaction();
        try{
             $Task = $this->taskRepositoryInterface->update($updateDetails,$id);

             DB::commit();
             return ApiResponseClass::sendResponse('Task Update Successful','',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $this->taskRepositoryInterface->delete($id);

        return ApiResponseClass::sendResponse('Task Delete Successful','',204);
    }
}
