<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of documents
     */
    public function index()
    {
        // Get the page for SEO
        $page = Page::where('slug', 'documents')->first();

        // If page doesn't exist, create it with default values
        if (!$page) {
            $page = Page::create([
                'name' => 'Documents',
                'title' => 'Documents',
                'slug' => 'documents',
                'status' => true,
                'meta_title' => 'Documents - Trusted LEI',
                'meta_description' => 'Download important documents, forms, and resources for LEI registration and management.',
                'content' => json_encode([
                    'main_content' => '<p>Access our collection of important documents and resources for LEI registration.</p>'
                ])
            ]);
        }
        
        // Get active documents ordered
        $documents = Document::active()->ordered()->paginate(20);
        
        return view('pages.documents', compact('documents', 'page'));
    }

    /**
     * Download a document
     */
    public function download(Document $document)
    {
        // Check if document is active
        if (!$document->status) {
            abort(404);
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found');
        }

        // Increment download count
        $document->incrementDownloadCount();

        // Return file download
        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }

    /**
     * Preview a document (for PDFs and images)
     */
    public function preview(Document $document)
    {
        // Check if document is active
        if (!$document->status) {
            abort(404);
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found');
        }

        $extension = strtolower(pathinfo($document->file_name, PATHINFO_EXTENSION));
        
        // Only allow preview for certain file types
        $previewableTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif'];
        
        if (!in_array($extension, $previewableTypes)) {
            // If not previewable, download instead
            return $this->download($document);
        }

        // Return file for preview
        return response()->file(Storage::disk('public')->path($document->file_path));
    }
}