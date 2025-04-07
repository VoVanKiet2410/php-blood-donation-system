<?php

namespace App\Controllers;

use App\Models\Faq;
use Exception;

class FaqController
{
    public function index()
    {
        try {
            // Use Eloquent to fetch all FAQs
            $faqs = Faq::orderBy('id', 'asc')->get();
            
            // Pass data to the view
            $data = [
                'faqs' => $faqs
            ];
            extract($data);
            
            require_once '../app/views/faqs/index.php';
        } catch (Exception $e) {
            error_log('Error in FaqController@index: ' . $e->getMessage());
            echo '<div class="alert alert-danger">Error loading FAQ data: ' . $e->getMessage() . '</div>';
        }
    }

    // Add a client-specific view method (though using the same logic for now)
    public function clientIndex()
    {
        try {
            // Use Eloquent to fetch all FAQs
            $faqs = Faq::orderBy('id', 'asc')->get();
            
            // Pass data to the view
            $data = [
                'faqs' => $faqs
            ];
            extract($data);
            
            require_once '../app/views/faqs/client_index.php';
        } catch (Exception $e) {
            error_log('Error in FaqController@clientIndex: ' . $e->getMessage());
            echo '<div class="alert alert-danger">Error loading FAQ data: ' . $e->getMessage() . '</div>';
        }
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