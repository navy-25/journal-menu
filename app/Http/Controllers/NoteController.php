<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Catatan';
        $data = Note::orderBy('id', 'DESC')->get();
        return view('note', compact('data', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'title'         => 'required',
                'description'   => 'required',
            ],
        );
        $data = Note::create([
            'title'         => $request->title,
            'description'   => $request->description,
        ]);
        return redirect()->back()->with('success', 'berhasil menambahkan ' . $data->title);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $this->validate(
            $request,
            [
                'title'         => 'required',
                'description'   => 'required',
            ],
        );
        $data = Note::find($request->id);
        $data->update([
            'title'         => $request->title,
            'description'   => $request->description,
        ]);
        return redirect()->back()->with('success', 'berhasil memperbarui ' . $data->title);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note, Request $request)
    {
        $data = Note::find($request->id);
        $data->delete();
        return redirect()->back()->with('success', 'data berhasil dihapus');
    }
}
