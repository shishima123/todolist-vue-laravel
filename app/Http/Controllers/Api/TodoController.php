<?php

namespace App\Http\Controllers\Api;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TodoController extends ApiController
{
    const STATE = [
        'active' => 0,
        'completed' => 1,
        'all' => 2
    ];
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $state = $request->get('state', 'all');
        $todo = Todo::orderByDesc('created_at')->where('user_id', Auth::user()->id);

        if ($state != 'all') {
            $todo = $todo->where('state', self::STATE[$state]);
        }
        return $todo->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();
            $input['user_id'] = Auth::user()->id;
            Todo::create($input);
            return $this->successResponse('Store Successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong', 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Todo $todo
     * @return mixed
     */
    public function update(Request $request, Todo $todo)
    {
        try {
            $input = $request->all();
            $todo->fill($input)->save();
            return $this->successResponse('Update Successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Todo $todo
     * @return mixed
     */
    public function destroy(Todo $todo)
    {
        try {
            $todo->delete();
            return $this->successResponse('Delete Successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong', 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function tickAll(Request $request)
    {
        $inputs = $request->all();

        try {
            DB::transaction(function () use ($inputs) {
                foreach ($inputs as $input) {
                    Todo::findOrFail($input['id'])->fill($input)->save();
                }
            });
            return $this->successResponse('Update Successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong', 400);
        }
    }
}
