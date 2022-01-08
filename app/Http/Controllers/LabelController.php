<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Set;
use App\Services\PDFGeneratorService;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class LabelController extends Controller
{

    public const PREVIEW = 100;

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

    public function configure(Request $request, Label $label)
    {
        return view('labels.configure', compact('label'));
    }

    public function preview(Set $set)
    {
        $service = new PDFGeneratorService();
        return $service->process($set, true, self::PREVIEW)
            ->stream();
    }
}
