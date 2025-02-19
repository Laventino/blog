<?php

namespace App\Http\Controllers;
use App\Note;
use App\Video;
use App\Workspace;
use App\ListTasks;
use App\Tasks;
use App\WorkspaceParticipant;
use App\MarkCategory;
use App\Mark;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu_name = "note";

        $note = Note::all();

        return \View::make('note.index', compact('note', 'menu_name'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $note = $request->note;
        $newNote = Note::create([
            'value' => $note
        ]);
        return $newNote->id;
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy(Request $request)
    {
        \Log::info('item',[$request->id]);
        Note::find($request->id)->delete();
    }
}
