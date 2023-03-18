<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\six_fournine;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SixFourNineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sixfournine = six_fournine::where('soft_Delete','1')->get();

        return view('Lotto.sixfournine', compact('sixfournine'));
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
            "draw_date" => 'required|date_format:Y-m-d|unique:six_fournines', //done
            "winning_number_1" => 'required|numeric|min:1|max:49|lt:winning_number_2,winning_number_3,winning_number_4,winning_number_5,winning_number_6', //done
            "winning_number_2" => 'required|numeric|min:1|max:49|gt:winning_number_1|lt:winning_number_3,winning_number_4,winning_number_5,winning_number_6', //done
            "winning_number_3" => 'required|numeric|min:1|max:49|gt:winning_number_1,winning_number_2|lt:winning_number_4,winning_number_5,winning_number_6', //done
            "winning_number_4" => 'required|numeric|min:1|max:49|gt:winning_number_1,winning_number_2,winning_number_3|lt:winning_number_5,winning_number_6', //done
            "winning_number_5" => 'required|numeric|min:1|max:49|gt:winning_number_1,winning_number_2,winning_number_3,winning_number_4|lt:winning_number_6', //done
            "winning_number_6" => 'required|numeric|min:1|max:49|gt:winning_number_1,winning_number_2,winning_number_3,winning_number_4,winning_number_5', //done
            "winning_number_bonus" => 'required|numeric|min:1|max:49|different:winning_number_1,winning_number_2,winning_number_3,winning_number_4,winning_number_5,winning_number_6', //done
            "ball_color" => 'required|numeric|min:0|max:1', //done
            "gold_ball_win_num" => 'required|min:11|max:11', //done
            "gb_province_winner" => 'required|max:2|in:NL,PE,NS,NB,QC,ON,MB,SK,AB,BC,YT,NT,NU', //done
            "extra" => 'required|numeric|digits:7', //done
        ]);
        $fn = $validator->validated();
        if ($validator->fails()) {
            return response()->json([
                    'errors'=>$validator->errors()],
                422);
        }else{
            $id_random = Hash::make(rand(1,100000));
            $six_fournine = six_fournine::create([
                'id_string' => md5($id_random),
                'draw_date' => $fn['draw_date'],
                'winning_number_1' => $fn['winning_number_1'],
                'winning_number_2' => $fn['winning_number_2'],
                'winning_number_3' => $fn['winning_number_3'],
                'winning_number_4' => $fn['winning_number_4'],
                'winning_number_5' => $fn['winning_number_5'],
                'winning_number_6' => $fn['winning_number_6'],
                'winning_number_bonus' => $fn['winning_number_bonus'],
                'ball_color' => $fn['ball_color'],
                'gold_ball_win_num' => $fn['gold_ball_win_num'],
                'gb_province_winner' => $fn['gb_province_winner'],
                'extra' => $fn['extra'],
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
        $update_id = six_fournine::where('id_string',$id_string)->first();
        $validator = Validator::make($request->all(), [
            "draw_date" => 'required|date_format:Y-m-d|unique:six_fournines,draw_date,'.$update_id->id, //validate if the date exists on other rows.
            "winning_number_1" => 'required|numeric|min:1|max:49|lt:winning_number_2,winning_number_3,winning_number_4,winning_number_5,winning_number_6',
            "winning_number_2" => 'required|numeric|min:1|max:49|gt:winning_number_1|lt:winning_number_3,winning_number_4,winning_number_5,winning_number_6',
            "winning_number_3" => 'required|numeric|min:1|max:49|gt:winning_number_1,winning_number_2|lt:winning_number_4,winning_number_5,winning_number_6',
            "winning_number_4" => 'required|numeric|min:1|max:49|gt:winning_number_1,winning_number_2,winning_number_3|lt:winning_number_5,winning_number_6',
            "winning_number_5" => 'required|numeric|min:1|max:49|gt:winning_number_1,winning_number_2,winning_number_3,winning_number_4|lt:winning_number_6',
            "winning_number_6" => 'required|numeric|min:1|max:49|gt:winning_number_1,winning_number_2,winning_number_3,winning_number_4,winning_number_5',
            "winning_number_bonus" => 'required|numeric|min:1|max:49|different:winning_number_1,winning_number_2,winning_number_3,winning_number_4,winning_number_5,winning_number_6', //done
            "ball_color" => 'required|numeric|min:0|max:1',
            "gold_ball_win_num" => 'required|min:11|max:11',
            "gb_province_winner" => 'required|max:2|in:NL,PE,NS,NB,QC,ON,MB,SK,AB,BC,YT,NT,NU',
            "extra" => 'required|numeric|digits:7',
        ]);

        $fn = $validator->validated();
        if($validator->fails()){
            return response()->json([
                'errors'=>$validator->errors()],422
            );
        }else{
            $update_id->draw_date = $fn['draw_date'];
            $update_id->winning_number_1 = $fn['winning_number_1'];
            $update_id->winning_number_2 = $fn['winning_number_2'];
            $update_id->winning_number_3 = $fn['winning_number_3'];
            $update_id->winning_number_4 = $fn['winning_number_4'];
            $update_id->winning_number_5 = $fn['winning_number_5'];
            $update_id->winning_number_6 = $fn['winning_number_6'];
            $update_id->winning_number_bonus = $fn['winning_number_bonus'];
            $update_id->ball_color = $fn['ball_color'];
            $update_id->gold_ball_win_num = $fn['gold_ball_win_num'];
            $update_id->gb_province_winner = $fn['gb_province_winner'];
            $update_id->extra = $fn['extra'];

            $update_id->save();
            return response()->json([
                'success' => 'Record successfully added.'
            ]);
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
        $id = six_fournine::where('id_string',$id_string)->first();
        $id->soft_Delete = '0';
        $id->save();

        return response()->json(['success'=>'Data is permanently deleted.']);
    }
}
