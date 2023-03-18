<?php

namespace App\Http\Controllers;

use App\Models\Max;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LottoMaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lotto_max = Max::where('soft_Delete','1')->get();
        return view('Lotto.max',compact('lotto_max'));
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
        $validator = Validator::make($request->all(), [
            "draw_date" => 'required|date_format:Y-m-d|unique:maxes', //done
            "winning_number_1" => 'required|numeric|min:1|max:50|lt:winning_number_2,winning_number_3,winning_number_4,winning_number_5,winning_number_6,winning_number_7', //done
            "winning_number_2" => 'required|numeric|min:1|max:50|gt:winning_number_1|lt:winning_number_3,winning_number_4,winning_number_5,winning_number_6,winning_number_7', //done
            "winning_number_3" => 'required|numeric|min:1|max:50|gt:winning_number_1,winning_number_2|lt:winning_number_4,winning_number_5,winning_number_6,winning_number_7', //done
            "winning_number_4" => 'required|numeric|min:1|max:50|gt:winning_number_1,winning_number_2,winning_number_3|lt:winning_number_5,winning_number_6,winning_number_7', //done
            "winning_number_5" => 'required|numeric|min:1|max:50|gt:winning_number_1,winning_number_2,winning_number_3,winning_number_4|lt:winning_number_6,winning_number_7', //done
            "winning_number_6" => 'required|numeric|min:1|max:50|gt:winning_number_1,winning_number_2,winning_number_3,winning_number_4,winning_number_5|lt:winning_number_7', //done
            "winning_number_7" => 'required|numeric|min:1|max:50|gt:winning_number_1,winning_number_2,winning_number_3,winning_number_4,winning_number_5,winning_number_6', //done
            "winning_number_bonus" => 'required|numeric|min:1|max:50|different:winning_number_1,winning_number_2,winning_number_3,winning_number_4,winning_number_5,winning_number_6,winning_number_7', //done
            "extra" => 'required|numeric|digits:7',
        ]);
        $max = $validator->validated();
        if ($validator->fails()) {
            return response()->json([
                    'errors'=>$validator->errors()],
                422);
        }else{
            $id_random = Hash::make(rand(1,100000));
            $max = Max::create([
                'id_string' => md5($id_random),
                'draw_date' => $max['draw_date'],
                'winning_number_1' => $max['winning_number_1'],
                'winning_number_2' => $max['winning_number_2'],
                'winning_number_3' => $max['winning_number_3'],
                'winning_number_4' => $max['winning_number_4'],
                'winning_number_5' => $max['winning_number_5'],
                'winning_number_6' => $max['winning_number_6'],
                'winning_number_7' => $max['winning_number_7'],
                'winning_number_bonus' => $max['winning_number_bonus'],
                'extra' => $max['extra'],
            ]);
            return response()->json(['success'=>'Record successfully added.']);
        }
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
    public function update(Request $request, $id_string)
    {
        $update_id = Max::where('id_string',$id_string)->first();
        $validator = Validator::make($request->all(), [
            "draw_date" => 'required|date_format:Y-m-d|unique:maxes,draw_date,'.$update_id->id, //validate if the date exists on other rows.
            "winning_number_1" => 'required|numeric|min:1|max:50|lt:winning_number_2,winning_number_3,winning_number_4,winning_number_5,winning_number_6,winning_number_7', //done
            "winning_number_2" => 'required|numeric|min:1|max:50|gt:winning_number_1|lt:winning_number_3,winning_number_4,winning_number_5,winning_number_6,winning_number_7', //done
            "winning_number_3" => 'required|numeric|min:1|max:50|gt:winning_number_1,winning_number_2|lt:winning_number_4,winning_number_5,winning_number_6,winning_number_7', //done
            "winning_number_4" => 'required|numeric|min:1|max:50|gt:winning_number_1,winning_number_2,winning_number_3|lt:winning_number_5,winning_number_6,winning_number_7', //done
            "winning_number_5" => 'required|numeric|min:1|max:50|gt:winning_number_1,winning_number_2,winning_number_3,winning_number_4|lt:winning_number_6,winning_number_7', //done
            "winning_number_6" => 'required|numeric|min:1|max:50|gt:winning_number_1,winning_number_2,winning_number_3,winning_number_4,winning_number_5|lt:winning_number_7', //done
            "winning_number_7" => 'required|numeric|min:1|max:50|gt:winning_number_1,winning_number_2,winning_number_3,winning_number_4,winning_number_5,winning_number_6', //done
            "winning_number_bonus" => 'required|numeric|min:1|max:50|different:winning_number_1,winning_number_2,winning_number_3,winning_number_4,winning_number_5,winning_number_6,winning_number_7', //done
            "extra" => 'required|numeric|digits:7',
        ]);

        $max = $validator->validated();
        if($validator->fails()){
            return response()->json([
                'errors'=>$validator->errors()],422
            );
        }else{
            $update_id->draw_date = $max['draw_date'];
            $update_id->winning_number_1 = $max['winning_number_1'];
            $update_id->winning_number_2 = $max['winning_number_2'];
            $update_id->winning_number_3 = $max['winning_number_3'];
            $update_id->winning_number_4 = $max['winning_number_4'];
            $update_id->winning_number_5 = $max['winning_number_5'];
            $update_id->winning_number_6 = $max['winning_number_6'];
            $update_id->winning_number_7 = $max['winning_number_7'];
            $update_id->winning_number_bonus = $max['winning_number_bonus'];
            $update_id->extra = $max['extra'];

            $update_id->save();
            return response()->json(['success'=>'Record successfully updated.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_string)
    {
        $id = Max::where('id_string',$id_string)->first();
        $id->soft_Delete = '0';
        $id->save();

        return response()->json(['success'=>'Data is permanently deleted.']);
    }
}
