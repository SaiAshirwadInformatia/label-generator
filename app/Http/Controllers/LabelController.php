<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('labels.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Label           $label
     * @return \Illuminate\Http\Response
     */
    public function configure(Label $label)
    {
        return view('labels.configure', compact('label'));
    }

}
