<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Display a listing of documents
     */
    public function index()
    {
        $documents = Document::ordered()->get();
        return view('admin.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new document
     */
    public function create()
    {
        return view('admin.documents.create');
    }

    /**
     * Store a newly created document
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar,jpg,jpeg,png,gif|max:20480', // 20MB max
            'status' => 'boolean',
            'order' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $file = $request->file('document_file');
        
        // Store the file
        $path = $file->store('documents', 'public');
        
        // Get file information
        $originalName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $fileType = $file->getClientMimeType();
        
        // Create document record
        $document = Document::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'file_path' => $path,
            'file_name' => $originalName,
            'file_size' => $fileSize,
            'file_type' => $fileType,
            'status' => $request->boolean('status', true),
            'order' => $request->order ?? 0,
            'meta_title' => $request->meta_title ?: $request->title,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document uploaded successfully');
    }

    /**
     * Show the form for editing the document
     */
    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    /**
     * Update the specified document
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar,jpg,jpeg,png,gif|max:20480',
            'status' => 'boolean',
            'order' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->boolean('status', true),
            'order' => $request->order ?? 0,
            'meta_title' => $request->meta_title ?: $request->title,
            'meta_description' => $request->meta_description,
        ];

        // If a new file is uploaded
        if ($request->hasFile('document_file')) {
            // Delete old file
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('document_file');
            $path = $file->store('documents', 'public');
            
            $data['file_path'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['file_type'] = $file->getClientMimeType();
        }

        $document->update($data);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document updated successfully');
    }

    /**
     * Remove the specified document
     */
    public function destroy(Document $document)
    {
        // Delete the file
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document deleted successfully');
    }

    /**
     * Toggle document status
     */
    public function toggleStatus(Document $document)
    {
        $document->status = !$document->status;
        $document->save();

        return response()->json([
            'success' => true,
            'status' => $document->status,
            'message' => 'Document status updated successfully'
        ]);
    }

    /**
     * Update document order
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'documents' => 'required|array',
            'documents.*.id' => 'required|exists:documents,id',
            'documents.*.order' => 'required|integer',
        ]);

        foreach ($request->documents as $documentData) {
            Document::where('id', $documentData['id'])
                ->update(['order' => $documentData['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Document order updated successfully'
        ]);
    }
}