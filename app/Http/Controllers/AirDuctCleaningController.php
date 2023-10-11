<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AirDuctCleaning;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;


class AirDuctCleaningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $airDuct = AirDuctCleaning::get();
            return response()->json(['airDuct' => $airDuct], 200);
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
                'num_furnace' => 'required|in:1,2,3,4,5,6,7,8,9',
                'square_footage_min' => 'required|numeric',
                'square_footage_max' => 'required|numeric',
                'furnace_loc_sidebyside' => 'required|numeric',
                'furnace_loc_different' => 'required|numeric',
                'final_price' => 'required|numeric',

            ]);

            if ($validator->fails()) {
                $responseArr['message'] = $validator->errors();
                return response()->json($responseArr, Response::HTTP_BAD_REQUEST);
            }

            $airDuct = new AirDuctCleaning;
            $airDuct->num_furnace = $request->num_furnace;
            $airDuct->square_footage_min = $request->square_footage_min;
            $airDuct->square_footage_max = $request->square_footage_max;
            $airDuct->furnace_loc_sidebyside = $request->furnace_loc_sidebyside;
            $airDuct->furnace_loc_different = $request->furnace_loc_different;
            $airDuct->final_price = $request->final_price;
            $airDuct->created_by = Auth::id();
            $airDuct->save();
            return response()->json(['message' => trans('message.record_add')], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
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
                'num_furnace' => 'required|in:1,2,3,4,5,6,7,8,9',
                'square_footage_min' => 'required|numeric',
                'square_footage_max' => 'required|numeric',
                'furnace_loc_sidebyside' => 'required|numeric',
                'furnace_loc_different' => 'required|numeric',
                'final_price' => 'required|numeric',

            ]);

            if ($validator->fails()) {
                $responseArr['message'] = $validator->errors();
                return response()->json($responseArr, Response::HTTP_BAD_REQUEST);
            }
            $airDuct = AirDuctCleaning::find($id);
            $airDuct->num_furnace = $request->num_furnace;
            $airDuct->square_footage_min = $request->square_footage_min;
            $airDuct->square_footage_max = $request->square_footage_max;
            $airDuct->furnace_loc_sidebyside = $request->furnace_loc_sidebyside;
            $airDuct->furnace_loc_different = $request->furnace_loc_different;
            $airDuct->final_price = $request->final_price;
            $airDuct->updated_by = Auth::id();
            $airDuct->save();
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
            $airDuct = AirDuctCleaning::find($id);
            if ($airDuct) {
            return response()->json(['message' => trans('message.record_delete')], 200);
                $airDuct->delete();
                return response()->json(['message' => trans('message.record_delete')], 200);
            }else{
                return response()->json(['message' => 'Record not found.'], 200);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

    }
}
