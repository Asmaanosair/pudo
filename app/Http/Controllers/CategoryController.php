<?php

namespace App\Http\Controllers;

use App\OrderStatus;
use App\StatusCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status=OrderStatus::all();
        $cat=StatusCategory::all();
       return response()->json(['status'=>$status,'cat'=>$cat]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth('api')->user();

        if ($request->status == 'status') {
            $fleet = new StatusCategory();
            $fleet->name = $request->get('name');
            $fleet->save();
            return response()->json(['status' => 'success']);
        }
        if ($request->cat == 'cat') {
            $fleet = new OrderStatus();
            $fleet->name = $request->get('name2');
            $fleet->class = $request->get('classn');
            $fleet->category_id = $request->get('catId');
            $fleet->save();
            return response()->json(['status' => 'success']);
        }
        return 'error';
    }







    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cat=OrderStatus::find($id);
        return response()->json($cat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fleet = OrderStatus::find($id);
        $fleet->name = $request->get('name2');
        $fleet->class = $request->get('classn');
        $fleet->category_id = $request->get('catId');
        $fleet->save();
        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
