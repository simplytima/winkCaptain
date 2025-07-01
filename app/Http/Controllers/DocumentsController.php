<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function showUploadForm()
    {
        $needed_documents = [
            ['id' => 'cin', 'name' => 'Carte d\'Identité Nationale', 'description' => 'Veuillez fournir les informations de votre carte d\'identité en cours de validité'],
            ['id' => 'carte_grise', 'name' => 'Carte Grise', 'description' => 'Veuillez fournir les informations du véhicule que vous utiliserez'],
            ['id' => 'permis', 'name' => 'Permis de confiance', 'description' => 'Veuillez fournir les informations de votre Permis de confiance en cours de validité'],
            ['id' => 'vehicle', 'name' => 'Informations du Véhicule', 'description' => 'Veuillez fournir les informations sur votre véhicule'],
        ];

        return view('upload-documents', compact('needed_documents'));
    }

    public function handleUpload(Request $request)
    {
        $request->validate([
            'documents.cin.identify_number' => 'required|string',
            'documents.cin.expiry_date' => 'required|date',
            'documents.cin.front_image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'documents.cin.back_image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            // Même chose pour carte_grise et permis...
        ]);

        

        return redirect()->route('dashboard')->with('success', 'Documents soumis avec succès!');
    }
}
