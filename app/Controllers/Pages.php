<?php

namespace App\Controllers;

use App\Models\CampModel;
use App\Models\LearningCourseModel;
use App\Models\TestimonialModel;

class Pages extends BaseController
{
    public function learn()
    {
        return view('pages/learn', [
            'active'  => 'learn',
            'title'   => 'Learning Lab | Little Doctors',
            'courses' => (new LearningCourseModel())->active(),
        ]);
    }

    public function camps()
    {
        helper('format');

        return view('pages/camps', [
            'active' => 'camps',
            'title'  => 'Camps | Little Doctors',
            'camps'  => (new CampModel())->active(),
        ]);
    }

    public function events()
    {
        helper('format');

        return view('pages/events', [
            'active' => 'events',
            'title'  => 'Events | Little Doctors',
            'events' => (new CampModel())->byDate(),
        ]);
    }

    public function about()
    {
        return view('pages/about', [
            'active' => 'about',
            'title'  => 'About | Little Doctors',
        ]);
    }

    public function stories()
    {
        return view('pages/stories', [
            'active'       => 'stories',
            'title'        => 'Stories | Little Doctors',
            'testimonials' => (new TestimonialModel())->active(),
        ]);
    }
}