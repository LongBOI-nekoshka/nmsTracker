<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Temp;
use DB;

class TempAjaxUpload extends Controller
{
    //
    public function post(Request $request)
    {
        for($i = 0; $i < count($_FILES); $i++) {
            $fileNameWithExt = $request->file('file'.$i)->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('file'.$i)->getClientOriginalExtension();
            $fileNameToStore = '{'.$filename.'.'.$extention.'}';
            print_r($fileNameToStore);
        }
    }
    
    public function save(Request $request) {
        print_r($_FILES);
        // $rawText = $request->input('moreInfo');
        // preg_match_all('/{(.*?)}/', $request->input('moreInfo'), $matches);
        // $search = strtr($rawText, array('{' => '<p><img style="width:30%" src="/storage/temp/', '}' => '"></p>'));
        // foreach($matches[1] as $index => $culry) {
        //     $search = str_replace($culry,$matches[1][$index].'_'.time(),$search);
        // }
        // for($i = 0; $i < count($_FILES); $i++) {
        //     $fileNameWithExt = $request->file('file'.$i)->getClientOriginalName();
        //     $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        //     $extention = $request->file('file'.$i)->getClientOriginalExtension();
        //     $fileNameToStore = $filename.'_'.time().'.'.$extention;
        //     $path = $request->file('file'.$i)->storeAs('public/temp', $fileNameToStore);
        // }
        // $saveTemp = new Temp;
        // $saveTemp->Temp_Message = $search;
        // $saveTemp->save();
        // return view('temps.temp');
    }
}
