<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntriesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }


    //get entries owned by current logged user
    public function getEntries()
    {
        $entries = [];
        foreach (User::find(Auth::user()->id)->entries as $entry) {
            $entries[] = [
                'id' => $entry->id,
                'date' => $entry->date,
                'time' => $entry->time,
                'text' => $entry->text,
                'numberOfCalories' => $entry->numberOfCalories
            ];
        }
        return $entries;
    }

    //list all entries
    public function index(Request $request)
    {
        $entries = Entry::all();
//        return response(Entry::all()->toJson());
        return view('entries')->with('entries', $entries);
    }

    //list entries that belongs to current logged user
    public function userEntries(Request $request)
    {
//            $user_entries = User::find(Auth::user()->id)->entries;
            $user_entries = $this->getEntries();
            return view('user_entries')->with('user_entries', $user_entries);

    }

    //filter entries for the specified date and time
    public function filterEntries(Request $request)
    {
            $user_id = Auth::user()->id;
            $fromDate = $request->get("fromDate");
            $toDate = $request->get("toDate");
            $fromHour = (int)$request->get("fromHour");
            $toHour = (int)$request->get("toHour");

            $result = DB::select("SELECT * FROM entries WHERE user_id = '$user_id' AND (date BETWEEN '$fromDate' and '$toDate') AND (HOUR(time) BETWEEN '$fromHour' AND '$toHour')");
            return response($result);

    }


    //get specific entry
    public function show(Request $request,$id)
    {
        $entry = Entry::find($id);
        if($entry){
            $entryData = [];
            $entryData[] = [
                'user_id' => $entry->user_id,
                'text' => $entry->text,
                'numberOfCalories' => $entry->numberOfCalories,
            ];
            return response($entryData);
        }
        else {
            return response("Entry does not exist!");
        }
    }


    //store new entry to database
    public function store(Request $request)
    {
        $entry  = new Entry();
        $entry->user_id = request('user_id');
        $entry->date = date('Y-m-d');
        $entry->time = date('Y-m-d H:i:s');
        $entry->text = $request->get('text');
        $entry->numberOfCalories = request('numberOfCalories');
        $entry->save();
        return response(json_encode(Entry::all()));
    }


    //sum current logged user's calories for today
    public function getUsersCaloriesForToday()
    {
        $user_id = Auth::user()->id;

        $result = DB::select("SELECT SUM(numberOfCalories) as calories from entries WHERE user_id = '$user_id' AND date = CURDATE()");
        return response($result);
    }


    //store to database an entry who belongs to current logged user
    public function newEntry(Request $request)
    {
            $entry = new Entry();
            $entry->user_id = Auth::user()->id;
            $entry->date = date('Y-m-d');
            $entry->time = date('Y-m-d H:i:s');
            $entry->text = $request->get('text');
            $entry->numberOfCalories = request('numberOfCalories');
            $entry->save();
            return $this->getEntries();

    }

    //delete entry
    public function destroy($id)
    {
        $entry = Entry::find($id);
        if($entry)
        {
            $entry->delete();
            $user_entries = Entry::all();
            return response($user_entries);
        }
        else
        {
            return redirect('/entries')->with('error','Entry does not exist!');
        }

    }

    //delete entry that belongs to current logged user
    public function deleteEntry($id)
    {
            $entry = Entry::find($id);
            if($entry && $entry->ownedBy(Auth::user()->id)) {

                $entry->delete();
                $user_entries = $this->getEntries();
                return response($user_entries);
            }
            else{
                return response("Entry does not exist or you do not have permission to delete this record!");
            }
    }

    //update entry
    public function update(Request $request,$id)
    {
        $entry = Entry::find($id);
        if($entry)
        {
            $entry->user_id = request('user_id');
            $entry->date = request('date');
            $entry->date = date('Y-m-d');
            $entry->text = request('text');
            $entry->numberOfCalories = request('numberOfCalories');
            $entry->save();
            return response(json_encode(Entry::all()));
        }
        else
        {
            return response("Entry does not exist!");
        }
    }


    //update entry that belong to logged user
    public function updateEntry(Request $request,$id)
    {
        $entry = Entry::find($id);
        if($entry)
        {
            $entry->user_id = Auth::user()->id;
            $entry->date = date('Y-m-d');
            $entry->time = date('Y-m-d H:i:s');
            $entry->text = request('text');
            $entry->numberOfCalories = request('numberOfCalories');
            $entry->save();
            $user_entries = $this->getEntries();
            return response($user_entries);
        }
        else
        {
            return response("Entry does not exist!");
        }
    }
}
