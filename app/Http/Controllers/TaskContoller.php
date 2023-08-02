<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;


class TaskContoller extends Controller
{
    public function addTasks(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'task_name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',                                            
                'message' => $validator->errors()->first()
            ], 400);
        }
        $Task=new Task;
        $Task->user_id=$request->user_id;
        $Task->task_name=$request->task_name;
        $Task->description=$request->description;
        $res=$Task->save();
        if($res){
            return response()->json([
                'status' => 'success',
                'message' => 'Task Added successfully',
                'data' => ''
            ], 200);
          }else{
              return response()->json([
                  'status' => 'failure',
                  'message' => 'fail to Add Task',
                  'data' => ''
                  ], 400);
              }
    }

    public function showTasks(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',                                            
                'message' => $validator->errors()->first()
            ], 400);
        }
        $res = Task::where('user_id',$request->user_id)->latest('created_at')->get();
        if($res){
            return response()->json([
                'status' => 'success',
                'message' => 'Task Displayed successfully',
                'data' => $res
            ], 200);
          }else{
              return response()->json([
                  'status' => 'failure',
                  'message' => 'fail to display Task',
                  'data' => ''
                  ], 400);
                }
    }

    public function deleteTasks( Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',                                            
                'message' => $validator->errors()->first()
            ], 400);
        }       
              $result = Task::where('id',$request->id)->firstOrFail();
              $result->delete();
              if($result){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Task Deleted successfully',
                
                ], 200);
              }else{
                  return response()->json([
                      'status' => 'failure',
                      'message' => 'fail to Delete Task',
                      'data' => ''
                      ], 400);
                 }       
    
    }

    public function UpdateTasks(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',                                            
                'message' => $validator->errors()->first()
            ], 400);
        }  
        $task_name = $request->task_name;
        $description = $request->description;

       try{
        $result = Task::find($request->id)->update([
            'task_name'      => $task_name,
            'description'   => $description
        ]);
        return response()->json([
            'status'    =>  'success',
            'message'   =>  'Task Updated Successfully...'
        ], 200);
    }
        catch(\Exception $e)
        {
        return response()->json([
            'status'    =>  'failure',
            'message'   =>  'Problem Updating Task..Error:'.$e->getMessage()
        ], 400);
        }
    }
     
}
