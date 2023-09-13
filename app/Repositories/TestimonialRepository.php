<?php


namespace App\Repositories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TestimonialRepository
 * @package App\Repositories
 */
class TestimonialRepository extends Repository
{
    public function __construct(Testimonial $testimonial)
    {
        parent::__construct($testimonial);
    }
}
