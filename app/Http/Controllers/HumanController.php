<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHumanRequest;
use App\Http\Requests\UpdateHumanRequest;
use App\Models\Human;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HumanController extends Controller {

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $data = Human::query()->paginate(10);
        $posts = Post::all();

        foreach ($data as $human) {
            $human->post_name = $human->post->name;
        }

        return Inertia::render('humans/index', [
                'data' => $data,
                'posts' => $posts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHumanRequest $request) {
        Human::create($request->all());

        $this->processImage($request);
        
        return redirect()->back()
            ->with('message', 'Human created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Human $human) {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHumanRequest $request, Human $human) {
        $human->update($request->all());

        $this->processImage($request);
        
        return redirect()->back()
            ->with('message', 'Human updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Human $human) {
        $human->delete();

        return redirect()->back()
            ->with('message', 'Human deleted');
    }

    public function upload(Request $request) {
        if ($request->hasFile('imageFilepond')) {
            return $request->file('imageFilepond')->store('uploads/humans', 'public');
        }

        return '';
    }

    public function uploadRevert(Request $request) {
        if ($image = $request->get('image')) {
            $path = storage_path('app/public/' . $image);
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    protected function processImage(Request $request) {
        if ($image = $request->get('image')) {
            $path = storage_path('app/public/' . $image);

            if (file_exists($path)) {
                copy($path, public_path($image));
                unlink($path);
            }
        }
    }

}
