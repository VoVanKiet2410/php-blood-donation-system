<?php

namespace App\Controllers;

use App\Models\Faq;

class FaqController
{
    public function index()
    {
        $faqs = Faq::all();
        require_once '../app/views/faqs/index.php';
    }

    public function create()
    {
        require_once '../app/views/faqs/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];

            $faq = new Faq();
            $faq->title = $title;
            $faq->description = $description;
            $faq->save();

            header('Location: /faqs');
        }
    }

    public function edit($id)
    {
        $faq = Faq::find($id);
        require_once '../app/views/faqs/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];

            $faq = Faq::find($id);
            $faq->title = $title;
            $faq->description = $description;
            $faq->save();

            header('Location: /faqs');
        }
    }

    public function delete($id)
    {
        $faq = Faq::find($id);
        $faq->delete();
        header('Location: /faqs');
    }
}