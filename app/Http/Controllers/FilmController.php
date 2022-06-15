<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Filmes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilmController extends Controller
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
    public function getFilm(Request $request)
    {
        $filmes = Filmes::orderBy('id' , 'ASC')
            ->when($request->NameFilm, function ($q) use ($request) {
                $q->where('NameFilm', 'like', '%'.$request->NameFilm.'%');
            })
            ->when($request->DateFilm, function ($q) use ($request) {
                $q->where('DateFilm', 'like', '%'.$request->DateFilm.'%');
            })
            ->with('category')
            ->paginate(1000);

        return response()->json($filmes);
    }

    public function delete($id)
    {
        $delete=Filmes::Find($id);
        $res=$delete->delete();
        if ($res){
            return response()->json(['msg' => 'تمت عملية الحذف']);
        }else{
            return response()->json(['msg' => 'فشلت عملية الحذف']);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'category_id' => 'required|numeric',
            'NameFilm' => 'required|unique:filmes',
            'ImgFilm' => 'mimes:jpeg,jpg,png,gif|sometimes|max:10000',
            'DetailsFilm' => 'required',
            'RatFilm' => 'required|numeric',
            'DateFilm' => 'required|date',
            'lengthFilm' => 'required|max:50',
        ], [],[
            'category_id'=> 'تصنيف الفلم',
            'NameFilm'=> 'اسم الفلم',
            'ImgFilm'=> 'صورة الفلم',
            'DetailsFilm'=> 'تفاصيل الفلم',
            'RatFilm'=> 'تقييم الفلم',
            'DateFilm'=> 'تاريخ عرض الفلم',
            'lengthFilm'=> 'مدة عرض الفلم',
        ]);

        if ($validated->fails()) {
            $msg = "تاكد من البيانات المدخلة";
            $data = $validated->errors();
            return response()->json(compact('msg', 'data'), 422);
        }


        $film = new Filmes();
        $film->category_id = $request->category_id;
        $film->NameFilm = $request->NameFilm;
        $film->DetailsFilm = $request->DetailsFilm;
        $film->RatFilm = $request->RatFilm;
        $film->DateFilm = $request->DateFilm;
        $film->lengthFilm = $request->lengthFilm;
        if($request->hasFile('ImgFilm')){
            $file=$request->file('ImgFilm');
            $imgName=time().'.'.$file->getClientOriginalExtension();
            $path='images'.'/'.$imgName;
            $file->move(public_path('images') , $imgName);
            $film->ImgFilm=$path;
        }
        $film->save();
        return response()->json(['msg' => 'تمت الاضافة بنجاح']);
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
            'category_id' => 'sometimes|numeric',
            'NameFilm' => 'required' ,
            'ImgFilm' => 'mimes:jpeg,jpg,png,gif|sometimes|max:10000',
            'DetailsFilm' => 'sometimes',
            'RatFilm' => 'sometimes',
            'DateFilm' => 'sometimes|date',
            'lengthFilm' => 'sometimes|max:50',

        ], [],[
            'category_id'=> 'تصنيف الفلم',
            'NameFilm'=> 'اسم الفلم',
            'ImgFilm'=> 'صورة الفلم',
            'DetailsFilm'=> 'تفاصيل الفلم',
            'RatFilm'=> 'تقييم الفلم',
            'DateFilm'=> 'تاريخ عرض الفلم',
            'lengthFilm'=> 'مدة عرض الفلم',
        ]);

        if ($validated->fails()) {
            $msg = "تاكد من البيانات المدخلة";
            $data = $validated->errors();
            return response()->json(compact('msg', 'data'), 422);
        }

        $path = $request->file('ImgFilm')->store('public/image');
        $film = Filmes::Find($id);
        $film->category_id = $request->category_id;
        $film->NameFilm = $request->NameFilm;
        $film->ImgFilm=$path;
        $film->DetailsFilm = $request->DetailsFilm;
        $film->RatFilm = $request->RatFilm;
        $film->DateFilm = $request->DateFilm;
        $film->lengthFilm = $request->lengthFilm;
        $film->save();
        return response()->json(['msg' => 'تم التعديل بنجاح']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Filmes::destroy($id);

    }
}
