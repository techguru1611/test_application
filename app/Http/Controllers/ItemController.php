<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Validator;
use Redirect;

class ItemController extends Controller
{

    public function index(Request $request)
    {
        $leftItems = Item::where('position','left')->get();
        $rightItems = Item::where('position','right')->get();
        return view('items',compact('leftItems','rightItems'));
    }


    // Save Item to DB
    public function save(Request $request)
    {
        // Rule Validation - Start
        $rule = [
            "name" => "required|unique:items,item_name",
        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return response()->json(array('status'=>'error','message' =>$validator->messages()->all()[0]));
        }
        // Rule Validation - Ends

        // Save Item
        $item = new Item;
        $item->item_name = $request->get('name');
        $item->save();
        return $item;
    }

    // Update Item position right 
    public function moveRight(Request $request)
    {
        if ($request->get('id')) {
            // Update Item
            $item = Item::where('id', $request->get('id'))->Update(['position' =>'right']);
            return response()->json(array('status'=>'success','message' =>'success'));
        }else{
            return response()->json(array('status'=>'error','message' =>'Please select Item'));
        }        
    }

    // Update Item position Left
    public function moveLeft(Request $request)
    {
        if ($request->get('id')) {
            // Update Item
            $item = Item::where('id', $request->get('id'))->Update(['position' =>'left']);
            return response()->json(array('status'=>'success','message' =>'success'));
        }else{
            return response()->json(array('status'=>'error','message' =>'Please select Item'));
        }        
    }
}
