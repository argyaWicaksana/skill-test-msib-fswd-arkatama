<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ResidentController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'data' => 'required|string',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->messages();
            $errors = $messages->all();
            return response()->json([
                'errors' => $errors
            ]);
        }

        $data = $request->input('data');
        $data = strtoupper($data);
        $splitData = preg_split('/(\d+)/', $data, -1, PREG_SPLIT_DELIM_CAPTURE);;
        $deleteWord = [
            'TAHUN',
            'TH',
            'THN',
        ];

        $name = rtrim($splitData[0]);
        $age = $splitData[1];
        $city = str_replace($deleteWord, '', $splitData[2]);
        $city = trim($city);
        // dd($name, $age, $city);

        $createdAt = $updatedAt = now();

        DB::table('residents')->insert([
            'name' => $name,
            'age' => $age,
            'city' => $city,
            "created_at" => $createdAt,
            "updated_at" => $updatedAt,
        ]);

        return response()->json([
            'name' => $name,
            'age' => $age,
            'city' => $city,
            "created_at" => $createdAt,
            "updated_at" => $updatedAt,
        ]);
    }
}
