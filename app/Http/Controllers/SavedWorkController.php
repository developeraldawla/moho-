<?php
namespace App\Http\Controllers;

use App\Models\SavedWork;
use Illuminate\Http\Request;

class SavedWorkController extends Controller
{
    public function index()
    {
        $works = SavedWork::where('user_id', auth()->id())->paginate(10);
        return view('dashboard.saved.index', compact('works'));
    }
    public function store(Request $request)
    {
        SavedWork::create($request->all());
        return back();
    }
    public function destroy($id)
    {
        SavedWork::where('user_id', auth()->id())->where('id', $id)->delete();
        return back();
    }
    public function toggleFavorite($id)
    {
        $work = SavedWork::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $work->is_favorite = !$work->is_favorite;
        $work->save();
        return back();
    }
}
