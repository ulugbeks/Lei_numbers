<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('admin.pages.index', compact('pages'));
    }
    
    /**
     * Show the form for creating a new page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }
    
    /**
     * Store a newly created page in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:191',
            'title' => 'required|string|max:191',
            'slug' => [
                'required',
                'string',
                'max:191',
                'unique:pages,slug',
                'not_in:admin,login,register,password,backend', // Protected routes
            ],
            'meta_title' => 'nullable|string|max:191',
            'meta_description' => 'nullable|string|max:255',
        ]);
        
        // Create new page
        $page = new Page();
        $page->name = $request->input('name');
        $page->title = $request->input('title');
        $page->slug = $request->input('slug');
        $page->status = $request->boolean('status');
        
        // Set SEO fields
        $page->meta_title = $request->input('meta_title') ?: $page->title;
        $page->meta_description = $request->input('meta_description');
        
        // Set advanced SEO fields if they exist in the database schema
        if (isset($page->og_title)) {
            $page->og_title = $request->input('og_title');
        }
        
        if (isset($page->og_description)) {
            $page->og_description = $request->input('og_description');
        }
        
        if (isset($page->og_type)) {
            $page->og_type = $request->input('og_type');
        }
        
        if (isset($page->canonical_url)) {
            $page->canonical_url = $request->input('canonical_url');
        }
        
        if (isset($page->no_index)) {
            $page->no_index = $request->boolean('no_index');
        }
        
        if (isset($page->no_follow)) {
            $page->no_follow = $request->boolean('no_follow');
        }
        
        // Handle content
        $content = [
            'main_content' => $request->input('main_content')
        ];
        
        // Process FAQ items if included
        if ($request->boolean('include_faq')) {
            $content['faqs'] = [];
            $questions = $request->input('faq_question', []);
            $answers = $request->input('faq_answer', []);
            
            for ($i = 0; $i < count($questions); $i++) {
                if (!empty($questions[$i])) {
                    $content['faqs'][] = [
                        'question' => $questions[$i],
                        'answer' => $answers[$i] ?? ''
                    ];
                }
            }
        }
        
        // Handle home page specific sections
        if ($request->input('slug') === 'home') {
            // Banner section
            $content['banner'] = [
                'title' => $request->input('banner_title'),
                'description' => $request->input('banner_description'),
                'button_text' => $request->input('banner_button_text'),
                'button_url' => $request->input('banner_button_url')
            ];
            
            // Features section
            $content['features'] = [];
            $featureTitles = $request->input('feature_title', []);
            $featureIcons = $request->input('feature_icon', []);
            $featureDescriptions = $request->input('feature_description', []);
            
            for ($i = 0; $i < count($featureTitles); $i++) {
                if (!empty($featureTitles[$i])) {
                    $content['features'][] = [
                        'title' => $featureTitles[$i],
                        'icon' => $featureIcons[$i] ?? '',
                        'description' => $featureDescriptions[$i] ?? ''
                    ];
                }
            }
            
            // About section
            $content['about'] = [
                'subtitle' => $request->input('about_subtitle'),
                'title' => $request->input('about_title'),
                'description' => $request->input('about_description')
            ];
            
            // Request section
            $content['request'] = [
                'title' => $request->input('request_title'),
                'phone_label' => $request->input('request_phone_label'),
                'phone_number' => $request->input('request_phone_number'),
                'button_text' => $request->input('request_button_text'),
                'button_url' => $request->input('request_button_url')
            ];
        }
        
        // Registration-LEI page specific content
        if ($request->input('slug') === 'registration-lei') {
            $content['service_header'] = [
                'title' => $request->input('service_title'),
                'description' => $request->input('service_description')
            ];
            
            // Plans information
            $content['plans'] = [
                'title' => $request->input('plans_title'),
                'description' => $request->input('plans_description'),
                'plans' => [
                    [
                        'duration' => '1 year',
                        'price' => $request->input('plan_1_price') ?? '75',
                        'total' => $request->input('plan_1_total') ?? '75'
                    ],
                    [
                        'duration' => '3 years',
                        'price' => $request->input('plan_3_price') ?? '55',
                        'total' => $request->input('plan_3_total') ?? '165',
                        'popular' => true
                    ],
                    [
                        'duration' => '5 years',
                        'price' => $request->input('plan_5_price') ?? '50',
                        'total' => $request->input('plan_5_total') ?? '250'
                    ]
                ]
            ];
            
            // Form sections
            $content['form'] = [
                'title' => $request->input('form_title') ?? 'Complete the form',
                'description' => $request->input('form_description') ?? 'Start typing, and let us fill all the relevant details for you.'
            ];
            
            // Tabs section
            $content['tabs'] = [
                'register_title' => $request->input('tab_register_title') ?? 'REGISTER',
                'renew_title' => $request->input('tab_renew_title') ?? 'RENEW',
                'transfer_title' => $request->input('tab_transfer_title') ?? 'TRANSFER',
                'renew_description' => $request->input('tab_renew_description') ?? 'Enter your LEI code or company name to quickly renew your registration.',
                'transfer_description' => $request->input('tab_transfer_description') ?? 'Transfer your existing LEI to our service for better rates and support.'
            ];
        }
        
        // Save content as JSON
        $page->content = json_encode($content);
        
        // Handle OG Image upload
        if ($request->hasFile('og_image')) {
            // Check if the field exists in the database
            if (isset($page->og_image)) {
                // Store new image
                $path = $request->file('og_image')->store('pages/og-images', 'public');
                $page->og_image = $path;
            }
        }
        
        // Handle image uploads for specific sections
        if ($request->hasFile('about_image')) {
            $path = $request->file('about_image')->store('pages/about', 'public');
            $content['about']['image'] = $path;
            $page->content = json_encode($content);
        }
        
        $page->save();
        
        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $content = json_decode($page->content, true) ?: [];
        
        return view('admin.pages.edit', compact('page', 'content'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:191',
            'slug' => [
                'required',
                'string',
                'max:191',
                Rule::unique('pages')->ignore($page->id),
                'not_in:admin,login,register,password,backend', // Protected routes
            ],
            'meta_title' => 'nullable|string|max:191',
            'meta_description' => 'nullable|string|max:255',
        ]);
        
        $oldContent = json_decode($page->content, true) ?: [];
        
        // Update the page basic info
        $page->title = $request->input('title');
        
        // Only update slug if it's not the home page (keep 'home' for the homepage)
        if ($page->slug !== 'home') {
            $page->slug = $request->input('slug');
        }
        
        // Update status if present
        if ($request->has('status')) {
            $page->status = $request->boolean('status');
        }
        
        // Generic content handling for all page types
        $content = [
            'main_content' => $request->input('main_content')
        ];
        
        // Process special sections based on page type
        if ($page->slug === 'home') {
            // Home page banner section - Text only
            $content['banner'] = [
                'title'        => $request->input('banner_title'),
                'description'  => $request->input('banner_description'),
                'button_text'  => $request->input('banner_button_text'),
                'button_url'   => $request->input('banner_button_url')
            ];
            
            // Preserve existing banner background image if it exists
            if (isset($oldContent['banner']['bg_image'])) {
                $content['banner']['bg_image'] = $oldContent['banner']['bg_image'];
            }
            
            // Features section - Text only (preserve existing icons)
            $content['features'] = [];
            $featureTitles = $request->input('feature_title', []);
            $featureIcons = $request->input('feature_icon', []);
            $featureDescriptions = $request->input('feature_description', []);
            
            for ($i = 0; $i < count($featureTitles); $i++) {
                if (!empty($featureTitles[$i])) {
                    $content['features'][] = [
                        'title' => $featureTitles[$i],
                        'icon' => $featureIcons[$i] ?? '',
                        'description' => $featureDescriptions[$i] ?? ''
                    ];
                }
            }
            
            // About section - Text only
            $content['about'] = [
                'subtitle'    => $request->input('about_subtitle'),
                'title'       => $request->input('about_title'),
                'description' => $request->input('about_description')
            ];
            
            // Preserve existing about image if it exists
            if (isset($oldContent['about']['image'])) {
                $content['about']['image'] = $oldContent['about']['image'];
            }
            
            // Request section - Text only
            $content['request'] = [
                'title'        => $request->input('request_title'),
                'phone_label'  => $request->input('request_phone_label'),
                'phone_number' => $request->input('request_phone_number'),
                'button_text'  => $request->input('request_button_text'),
                'button_url'   => $request->input('request_button_url')
            ];
            
            // Preserve existing request bg image if it exists
            if (isset($oldContent['request']['bg_image'])) {
                $content['request']['bg_image'] = $oldContent['request']['bg_image'];
            }
        }
        
        // Registration-LEI page specific content
        if ($page->slug === 'registration-lei') {
            // Preserve existing code for registration-lei page
            if (isset($oldContent['service_header'])) {
                $content['service_header'] = $oldContent['service_header'];
            }
            
            if (isset($oldContent['plans'])) {
                $content['plans'] = $oldContent['plans'];
            }
            
            if (isset($oldContent['form'])) {
                $content['form'] = $oldContent['form'];
            }
            
            if (isset($oldContent['tabs'])) {
                $content['tabs'] = $oldContent['tabs'];
            }
        }
        
        // Handle FAQ section if it exists
        if ($request->has('faq_question') || $request->has('aboutlei_faq_question')) {
            $content['faqs'] = [];
            
            // Handle regular FAQ questions
            if ($request->has('faq_question')) {
                $questions = $request->input('faq_question', []);
                $answers = $request->input('faq_answer', []);
                
                for ($i = 0; $i < count($questions); $i++) {
                    if (!empty($questions[$i])) {
                        $content['faqs'][] = [
                            'question' => $questions[$i],
                            'answer' => $answers[$i] ?? ''
                        ];
                    }
                }
            }
            
            // Handle about-lei FAQ questions if they exist
            if ($request->has('aboutlei_faq_question')) {
                $questions = $request->input('aboutlei_faq_question', []);
                $answers = $request->input('aboutlei_faq_answer', []);
                
                for ($i = 0; $i < count($questions); $i++) {
                    if (!empty($questions[$i])) {
                        $content['faqs'][] = [
                            'question' => $questions[$i],
                            'answer' => $answers[$i] ?? ''
                        ];
                    }
                }
            }
        } elseif (isset($oldContent['faqs'])) {
            // Preserve existing FAQ content if not updated
            $content['faqs'] = $oldContent['faqs'];
        }
        
        // Save updated content
        $page->content = json_encode($content);
        
        // Update SEO fields
        $page->meta_title = $request->input('meta_title') ?: $page->title;
        $page->meta_description = $request->input('meta_description');
        
        // Update Open Graph fields if they exist
        if (isset($page->og_title)) {
            $page->og_title = $request->input('og_title');
        }
        
        if (isset($page->og_description)) {
            $page->og_description = $request->input('og_description');
        }
        
        if (isset($page->og_type)) {
            $page->og_type = $request->input('og_type');
        }
        
        if (isset($page->canonical_url)) {
            $page->canonical_url = $request->input('canonical_url');
        }
        
        if (isset($page->no_index)) {
            $page->no_index = $request->boolean('no_index');
        }
        
        if (isset($page->no_follow)) {
            $page->no_follow = $request->boolean('no_follow');
        }
        
        // Handle OG Image upload
        if ($request->hasFile('og_image')) {
            // Check if the field exists in the database
            if (isset($page->og_image)) {
                // Delete old image if exists
                if ($page->og_image && Storage::disk('public')->exists($page->og_image)) {
                    Storage::disk('public')->delete($page->og_image);
                }
                
                // Store new image
                $path = $request->file('og_image')->store('pages/og-images', 'public');
                $page->og_image = $path;
            }
        }

        $page->save();
        
        return back()->with('success', 'Page updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        
        // Prevent deletion of system pages
        if (in_array($page->slug, ['home', 'about', 'contact', 'registration-lei'])) {
            return redirect()->route('admin.pages.index')
                ->with('error', 'System pages cannot be deleted.');
        }
        
        // Delete associated images if they exist
        if (isset($page->og_image) && $page->og_image && Storage::disk('public')->exists($page->og_image)) {
            Storage::disk('public')->delete($page->og_image);
        }
        
        // Delete the page
        $page->delete();
        
        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully');
    }
    
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $path = $request->file('upload')->store('pages/editor', 'public');
            $url = Storage::url($path);
            
            return response()->json([
                'uploaded' => 1,
                'fileName' => basename($path),
                'url'      => $url
            ]);
        }
        
        return response()->json(['uploaded' => 0]);
    }
}