<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest; // Gunakan Form Request untuk validasi
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted; // Kita akan buat Mailable ini

class ContactController extends Controller
{
    /**
     * Menampilkan formulir kontak.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.contact');
    }
}
