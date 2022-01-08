<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EntryResource;
use App\Models\Category;
use App\Models\Entry;
use App\Models\Tag;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(EntryResource::collection(Entry::where('user_id', $request->user()->id)->get()));
    }

    public function options() {

        $options = [
            'types' => Type::all(),
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ];

        return response()->json($options);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
           'date' => 'required|date',
           'type' => 'required',
           'category' => 'required',
           'time' => 'required|numeric',
           'tags' => 'required',
        ]);

        $entry = Entry::create([
            'date' => Carbon::create($request->date),
            'time' => $request->time,
        ]);

        $entry->user_id = $request->user()->id;

        $type = Type::firstOrCreate([
            'title' => $request->type
        ]);
        $entry->type_id = $type->id;

        $category = Category::firstOrCreate([
            'title' => $request->category
        ]);
        $entry->category_id = $category->id;

        $tags = [];

        foreach(json_decode($request->tags) as $tag) {
            $tagModel = Tag::firstOrCreate([
               'title' => $tag
            ]);

            $tags[] = $tagModel->id;
        }

        $entry->tags()->attach($tags);

        $entry->save();

        return response()->json(['message' => 'Entry created!', 'data' => $entry], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        return response()->json(Entry::where([['id', $id], ['user_id', $request->user()->id]])->firstOrFail());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'type' => 'required',
            'category' => 'required',
            'time' => 'required|numeric',
            'tags' => 'required',
        ]);

        $entry = Entry::where([['id', $id], ['user_id', $request->user()->id]])->firstOrFail();

        $entry->date = Carbon::create($request->date);

        $entry->time = $request->time;

        $type = Type::firstOrCreate([
            'title' => $request->type
        ]);
        $entry->type_id = $type->id;

        $category = Category::firstOrCreate([
            'title' => $request->category
        ]);
        $entry->category_id = $category->id;

        $tags = [];

        foreach(json_decode($request->tags) as $tag) {
            $tagModel = Tag::firstOrCreate([
                'title' => $tag
            ]);

            $tags[] = $tagModel->id;
        }

        $entry->tags()->sync($tags);

        $entry->save();

        return response()->json(['message' => 'Entry updated!', 'data' => new EntryResource($entry)], 200);
    }

}
