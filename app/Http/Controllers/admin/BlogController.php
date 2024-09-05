<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Blog;
use App\Models\Image;
use App\Models\BlogImg;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {

        $blogs = Blog::orderBy('id')->paginate(10);
        return view('AdminPanel.Blogs.index',[
            'active' => 'blogs',
            'title' => trans('common.blogs'),
            'blogs' => $blogs,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.blogs')
                ]
            ]
        ]);

    }
public function store(Request $request)
{
    // Validate request data
    $data = $request->validate([
        'title_ar' => 'required|string|max:255',
        'title_en' => 'required|string|max:255',
        'description_ar' => 'required|string|max:255',
        'description_en' => 'required|string|max:255',
        'images.*' => 'mimes:jpg,jpeg,png|max:2048', // Validation rule for images
    ]);

    // Create blog entry
    $blog = Blog::create([
        'title_ar' => $request->title_ar,
        'title_en' => $request->title_en,
        'description_ar' => $request->description_ar,
        'description_en' => $request->description_en,
    ]);

    \Log::info('Created blog entry with ID: ' . $blog->id);

    // Handle image uploads
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            \Log::info('Processing image ' . ($index + 1) . ': ' . $image->getClientOriginalName());

            $imagePath = upload_file('blogs', $image); // Ensure this function works correctly

            BlogImg::create([
                'image' => $imagePath,
                'blog_id' => $blog->id,
            ]);

            \Log::info('Uploaded image path: ' . $imagePath);
        }
    }

    return redirect()->back()
        ->with('success', trans('common.successMessageText'));
}



 public function update(Request $request, $id)
    {
        $data = $request->validate([
        'title_ar' => 'required|string|max:255',
        'title_en' => 'required|string|max:255',
        'description_ar' => 'required|string|max:255',
        'description_en' => 'required|string|max:255',
        'images.*' => 'nullable|mimes:jpg,jpeg,png|max:2048', // Validation rule for new images
    ]);

    // Find the blog to update
    $blog = Blog::findOrFail($id);

    // Update blog details
    $blog->update($data);

    // Handle image deletions
    if ($request->has('remove_images')) {
        $imagesToDelete = $request->input('remove_images');
        BlogImg::whereIn('id', $imagesToDelete)->delete();
    }

    // Handle new image uploads
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            BlogImg::create([
                'image' => upload_file('blogs', $image), // Replace with your actual file upload logic
                'blog_id' => $blog->id,
            ]);
        }
    }

    return redirect()->back()
        ->with('success', trans('common.successMessageText'));
    }
    public function delete($id)
    {
        $blog = Blog::find($id);
        if ($blog->image) {
            $this->deleteImage('blogs', $blog->image);
        }
        $blog->delete();
        return Response::json($id);
    }
    private function deleteImage($folder, $fileName)
    {
        $filePath = public_path('uploads/' . $folder . '/' . $fileName);
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
    }
}
