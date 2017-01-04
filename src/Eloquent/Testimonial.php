<?php

namespace CopyaTestimonial\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $table = 'testimonials';

    /*public function getImageFilenameAttribute(){
        $file = explode("/",$this->featured_image);
        $featured_image = $file[count($file) - 1];

        return $featured_image;
    }*/
}
