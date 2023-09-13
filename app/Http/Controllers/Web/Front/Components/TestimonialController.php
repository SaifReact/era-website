<?php

namespace App\Http\Controllers\Web\Front\Components;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IndexPageContract;
use App\Services\Contracts\TestimonialContract;
use App\Services\IndexPageService;
use App\Services\TestimonialService;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /** @var TestimonialContract|TestimonialService */
    private $testimonialService;

    public function __construct(TestimonialContract $testimonialService)
    {
        $this->testimonialService = $testimonialService;
    }

    public function __invoke()
    {
        return view('web.front.components.testimonials', [
            'testimonials' => $this->testimonialService->getSortedTestimonials(),
        ]);
    }
}
