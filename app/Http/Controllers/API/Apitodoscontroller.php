<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\todos;
use Illuminate\Http\Request;

class Apitodoscontroller extends Controller
{
    public function add_ToDo(Request $request)
    {

        $validate = $request->validate([
            'uname'=>['required'],
            'ename'=>['required'],
            'dtask'=>['required'],
            'date'=>['required'],
            ]);

            $data = todos::create([
                'User_Name' => $validate['uname'],
                'Event_Name' =>$validate['ename'],
                'Daily_Task' =>$validate['dtask'],
                'Date' =>$validate['date'],

            ]);
            if(is_null($data)){
                return response()->json(['message' => 'Record Added Faild',], 400);
            }
            else
            {
                return response()->json(['message' => 'Record Added'], 200);
            }
        }

        public function get_todo(){

            $data = todos::get();
            if(is_null($data)) return response()->json(['msg' =>'failed'], 400);
            return response()->json($data, 200);

        }

        public function search_todo_data($serach_data)
        {
            $user_data = todos::where('Event_Name',$serach_data)->get();

            if(is_null($user_data)) return response()->json(['msg' => 'Data not filter'], 400);

            return response()->json($user_data,200);
        }

        // public function get_ToDo_by_search($search_value){

        //     $p_data = ToDo::where('Name','LIKE',"%$search_value%")->get();

        //     return response()->json($p_data);
        // }

        public function delete_todo_data($todo_id)
        {
            $todo_data = todos::where('id',$todo_id)->delete();

            if(is_null($todo_data)) return response()->json(['msg' => 'delete is failed'], 400);

            return response()->json(['msg' => 'delete succesfully'], 200);
        }

        public function update_todo_data(Request $request, $todo_id)
        {
            $data = todos::find($todo_id);

           $new_data = $data->update([

                'User_Name' => $request->uname,
                'Event_Name' => $request->ename,
                'Daily_Task' => $request->dtask,
                'Date' => $request->date,
            ]);

            if(is_null($new_data)) return response()->json(['msg' => 'update is failed'], 400);

            return response()->json(['msg' => 'successfully updated'], 200);
        }

}
