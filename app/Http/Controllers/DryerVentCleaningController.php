<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DryerVentCleaning;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;


class DryerVentCleaningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $dryerVent = DryerVentCleaning::get();
            return response()->json(['dryerVent' => $dryerVent], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $validator = \Validator::make($request->all(), [
                'dryer_vent_exit_point' => 'required|in:0-10 Feet Off the Ground,10+ Feet Off the Ground,Rooftop',
                'price' => 'required|numeric',

            ]);

            if ($validator->fails()) {
                $responseArr['message'] = $validator->errors();
                return response()->json($responseArr, Response::HTTP_BAD_REQUEST);
            }

            $dryerVent = new DryerVentCleaning;
            $dryerVent->dryer_vent_exit_point = $request->dryer_vent_exit_point;
            $dryerVent->price = $request->price;
            $dryerVent->created_by = Auth::id();
            $dryerVent->save();
            return response()->json(['message' => trans('message.record_add')], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
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
        try{
            $validator = \Validator::make($request->all(), [
                'dryer_vent_exit_point' => 'required|in:0-10 Feet Off the Ground,10+ Feet Off the Ground,Rooftop',
                'price' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                $responseArr['message'] = $validator->errors();
                return response()->json($responseArr, Response::HTTP_BAD_REQUEST);
            }
            $dryerVent = DryerVentCleaning::find($id);
            $dryerVent->dryer_vent_exit_point = $request->dryer_vent_exit_point;
            $dryerVent->price = $request->price;
            $dryerVent->updated_by = Auth::id();
            $dryerVent->save();
            return response()->json(['message' => trans('message.record_update')], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $dryerVent = DryerVentCleaning::find($id);
            if ($dryerVent) {
                $dryerVent->delete();
                return response()->json(['message' => trans('message.record_delete')], 200);
            }else{
                return response()->json(['message' => 'Record not found.'], 200);
            }

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

    }
}
