<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Set;
use App\Services\PDFGeneratorService;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

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
        $instance = app()->make(PDFGeneratorService::class)
            ->preview()
            ->limit(self::PREVIEW)
            ->process($set);

        if ($instance instanceof Browsershot) {
            return $instance->pdf();
        }
        return $instance->stream();
    }

    public function generate(Set $set)
    {
        return app()->make(PDFGeneratorService::class)
            ->html()
            ->process($set);
    }
}
