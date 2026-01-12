<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InquiryController extends Controller
{
    public function store(): RedirectResponse
    {
        $validated = request()->validate([
            'car_id' => 'nullable|exists:cars,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'message' => 'nullable|string|max:1000'
        ]);

        Inquiry::create($validated);

        return redirect()->back()->with('success', 'Demande de renseignements envoyée avec succès !');
    }
}
