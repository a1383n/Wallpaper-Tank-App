<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('front.category',['data'=>Category::get()]);
    }

    public function router(Request $request){
        switch ($request->input('action')) {
            case 'PUT';
                return $this->store($request);
                break;
            case 'EDIT':
                return $this->update($request);
                break;
            case 'DELETE':
                return $this->destroy($request);
                break;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|bool[]
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'color'=>'required'
        ]);

        $input = $request->only('name','title','color');

        $category = new Category();
        $category->name = $input['name'];
        $category->title = null;
        $category->color = $input['color'];
        $category->user_id = Auth::id();

        if (sizeof(Category::where('name',$input['name'])->get()) == 0) {
            return ($category->saveOrFail()) ? ['ok' => true] : ['ok' => false, 'des' => 'Error while store value in database'];
        }else{
            return ['ok'=>false,'des'=>'Category is duplicate!'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return Response
     */
    public function show(Category $category)
    {


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return Response
     */
    public function update(Request $request)
    {
        $request->validate([
           'id'=>'required',
            'name'=>'required',
            'color'=>'required'
        ]);

        $input = $request->only('id','title','name','color');

        $category = Category::findOrfail($input['id']);
        $category->name = $input['name'];
        $category->title = null;
        $category->color = $input['color'];

        if (sizeof(Category::where('name',$input['name'])->get()) == 0) {
            return ($category->saveOrFail()) ? ['ok' => true] : ['ok' => false, 'des' => 'Error while store value in database'];
        }else{
            return ['ok'=>false,'des'=>'Category is duplicate!'];
        }    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id'=>'required'
        ]);

        $category = Category::findOrfail($request->input('id'));
        return ($category->items_count > 0) ? ['ok'=>false,'des'=>'This category is not empty!'] : ['ok'=>$category->delete()];
    }

    public function increaseItemCount($id){
        $category = Category::find($id);
        $category->items_count += 1;
        return ($category->save()) ? true : false;
    }

    public function decreaseItemCount($id){
        $category = Category::find($id);
        $category->items_count -= 1;
        return ($category->save()) ? true : false;
    }
}
