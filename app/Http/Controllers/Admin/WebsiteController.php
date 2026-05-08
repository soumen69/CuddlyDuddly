<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Website\HomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WebsiteController extends Controller
{
    public function index()
    {
        $sections = HomeSection::ordered()->get();

        return view('admin.website.home.index', [
            'sections' => $sections,
            'preview' => true,
        ]);
    }

    public function show(HomeSection $homeSection)
    {
        $view = 'website.home.sections.' . $homeSection->key;

        abort_unless(view()->exists($view), 404);

        return view('admin.website.home.preview', [
            'section' => $homeSection,
            'view' => $view,
        ]);
    }

    public function edit(HomeSection $homeSection)
    {
        $view = 'admin.website.home.edit.' . $homeSection->key;

        abort_unless(view()->exists($view), 404);

        return view($view, [
            'section' => $homeSection,
            'data' => $homeSection->data,
        ]);
    }

    // public function update(Request $request, HomeSection $homeSection)
    // {
    //     $homeSection->update([
    //         'data' => $request->input('data'),
    //     ]);

    //     return redirect()
    //         ->route('admin.website.home')
    //         ->with('success', 'Section updated successfully.');
    // }



    public function update(Request $request, HomeSection $homeSection)
    {
        $existingData = $homeSection->data ?? [];
        $incomingData = $request->input('data', []);
        $data = array_replace_recursive($existingData, $incomingData);
        $uploadPath = 'WebsiteImages/home';

        foreach ($request->files->all() as $field => $file) {
            if (is_array($file)) continue;
            if ($file && $file->isValid()) {
                if (!empty($data[$field]) && str_starts_with($data[$field], 'storage/')) {
                    Storage::disk('public')->delete(
                        str_replace('storage/', '', $data[$field])
                    );
                }
                $path = $file->store($uploadPath, 'public');
                $data[$field] = 'storage/' . $path;
            }
        }

        foreach ($request->files->all() as $field => $files) {
            if (!is_array($files)) continue;
            if (!empty($data[$field]) && is_array($data[$field])) {
                foreach ($data[$field] as $old) {
                    if (str_starts_with($old, 'storage/')) {
                        Storage::disk('public')->delete(
                            str_replace('storage/', '', $old)
                        );
                    }
                }
            }

            $paths = [];

            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store($uploadPath, 'public');
                    $paths[] = 'storage/' . $path;
                }
            }

            $data[$field] = $paths;
        }

        $homeSection->update([
            'data' => $data,
        ]);

        return redirect()
            ->route('admin.website.home')
            ->with('success', 'Section updated successfully.');
    }



    public function toggle(HomeSection $homeSection)
    {
        $homeSection->update([
            'is_active' => ! $homeSection->is_active,
        ]);

        return response()->json([
            'status' => true,
            'is_active' => $homeSection->is_active,
        ]);
    }

    public function reorder(Request $request)
    {
        DB::transaction(function () use ($request) {
            foreach ($request->positions as $position => $id) {
                HomeSection::where('id', $id)->update([
                    'position' => $position + 1,
                ]);
            }
        });

        return response()->json(['status' => true]);
    }
}
