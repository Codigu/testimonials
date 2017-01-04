<?php

namespace CopyaTestimonial\Http\Controllers\Admin;

use Copya\Http\Controllers\Admin\BaseController;

class TestimonialsController extends BaseController
{
    protected $model;

    public function index()
    {
        return view('copya.admin.pages.index', array('sidenav' => $this->getSideNav()));
    }

    public function create()
    {
        return view('copya.admin.pages.form', array('sidenav' => $this->getSideNav()));
    }

    public function edit($id)
    {
        if (is_null($model = config('copya.models.page'))) {
            throw new RuntimeException('Unable to determine user model from configuration.');
        }

        $page_model = new $model;

        $page = $page_model->find($id);
        if (!$page) {
            return abort(404);
        }
        $sidenav = $this->getSideNav();
        return view('copya.admin.pages.form', compact('sidenav'));
    }
}
