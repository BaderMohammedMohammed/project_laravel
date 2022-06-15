<?php

namespace App\Http\Controllers;

use App\Models\Categories;
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
        //
    }
    public function getCategory()
    {
        $categoies = Categories::with('film')->get();
        return response()->json($categoies);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nameCategory' => 'required|unique:categories',
        ], [],[
            'nameCategory'=> 'اسم التصنيف',
        ]);

        if ($validated->fails()) {
            $msg = "تاكد من البيانات المدخلة";
            $data = $validated->errors();
            return response()->json(compact('msg', 'data'), 422);
        }
        $category = new Categories();
        $category->nameCategory = $request->nameCategory;
        $category->save();
        return response()->json(['msg' => 'تمت الاضافة بنجاح']);
    }

    public function delete($id)
    {
        $del=Categories::Find($id);
        $res=$del->delete();
        if ($res){
            return response()->json(['msg' => 'تم الحذف']);
        }else{
            return response()->json(['msg' => 'لم يتم الحذف']);
        }
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
        //
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
        $validated = Validator::make($request->all(), [
            'nameCategory' => 'sometimes|required|unique:categories',
        ], [],[
            'nameCategory'=> 'اسم التصنيف',
        ]);

        if ($validated->fails()) {
            $msg = "تاكد من البيانات المدخلة";
            $data = $validated->errors();
            return response()->json(compact('msg', 'data'), 422);
        }
        $category =Categories::Find($id);
        $category->nameCategory = $request->nameCategory;
        $category->save();
        return response()->json(['msg' => 'تمت عملية التعديل بنجاح']);
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
