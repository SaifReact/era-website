<?php


namespace App\Services;


use App\Repositories\AboutUsRepository;

class AboutUsService implements Contracts\AboutUsContract
{
    /** @var AboutUsRepository */
    private $aboutUsRepository;

    public function __construct(AboutUsRepository $aboutUsRepository)
    {
        $this->aboutUsRepository = $aboutUsRepository;
    }

    public function get() {
        return $this->aboutUsRepository->first();
    }
}
