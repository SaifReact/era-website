<?php


namespace App\Services;


use App\Repositories\TestimonialRepository;

class TestimonialService implements Contracts\TestimonialContract
{
    /** @var TestimonialRepository */
    private $testimonialRepository;

    public function __construct(TestimonialRepository $testimonialRepository)
    {
        $this->testimonialRepository = $testimonialRepository;
    }

    public function getSortedTestimonials() {
        return $this->testimonialRepository->all()->sortBy('order');
    }
}
