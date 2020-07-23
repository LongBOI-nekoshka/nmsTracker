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
            $fileNameToStore = '{--'.$filename.'--}';
            print_r($fileNameToStore);
        }
    }
}
