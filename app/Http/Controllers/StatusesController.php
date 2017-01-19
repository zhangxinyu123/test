<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Status;
use Auth;


class StatusesController extends Controller
{
    public function __contruct()
    {
        $this->middleware('auth', [
            'only' => ['tore', 'destroy']
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);
        Auth::user()->statuses()->create([
            'content' => $request->content
        ]);
        return redirect()->back();
    }
    public function destroy($id){
        $status= Status::findOrFail($id);
        $this->authorize('destroy',$status);
        $status->delete();
        session()->flash('success','微博已被删除！');
        return redirect()->back();
    }
}
