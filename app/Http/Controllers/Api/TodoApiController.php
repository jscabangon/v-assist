<?php

namespace App\Http\Controllers\Api;

/** models */
use App\Models\Todo;

/** requests */
use App\Http\Requests\TodoUpdateRequest;
use App\Http\Requests\TodoStoreRequest;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TodoApiController extends Controller
{
    public function list()
    {
        try {
            $todos = Todo::paginate(15);

            return $this->jsonRes()
                        ->data($todos)
                        ->success();
        } catch (QueryException $qe) {

            return $this->jsonRes()
                        ->message($qe->getMessage())
                        ->error();
        }
    }

    public function view(Todo $todo)
    {
        if ($todo) {

            return $this->jsonRes()
                        ->data($todo)
                        ->success();
        } else {

            return $this->jsonRes()
                        ->message('No Record Found.')
                        ->error();
        }
    }

    public function store(TodoStoreRequest $request)
    {
        try {
            Todo::create([
                'user_id' => Auth::user()->id,
                'todo' => $request->todo,
                'description' => $request->description,
                'status' => $request->status
            ]);

            return $this->jsonRes()
                        ->message('Todo Created Successfully.')
                        ->success();
        } catch (QueryException $qe) {

            return $this->jsonRes()
                        ->message($qe->getMessage())
                        ->error();
        }
    }

    public function update(TodoUpdateRequest $request, $todoId)
    {
        try {
            $todo = Todo::find($todoId);

            if (!$todo)
                return $this->jsonRes()->message('No Record Found.')->error();

            Todo::where('id', $todoId)
                ->update([
                    'todo' => $request->todo,
                    'description' => $request->description,
                    'status' => $request->status
                ]);

            return $this->jsonRes()
                        ->message('Todo Updated Successfully.')
                        ->success();
        } catch (QueryException $qe) {

            return $this->jsonRes()
                        ->message($qe->getMessage())
                        ->error();
        }
    }

    public function delete($todoId)
    {
        try {
            $todo = Todo::find($todoId);

            if (!$todo)
                return $this->jsonRes()->message('No Record Found.')->error();

            // Soft delete todo
            $todo->delete();

            return $this->jsonRes()
                        ->message('Todo Deleted Successfully.')
                        ->success();
        } catch (QueryException $qe) {

            return $this->jsonRes()
                        ->message($qe->getMessage())
                        ->error();
        }
    }
}
