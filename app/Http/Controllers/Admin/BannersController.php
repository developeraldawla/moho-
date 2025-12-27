<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannersController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banners.index', compact('banners'));
    }
    public function create()
    {
        return view('admin.banners.form');
    }
    public function store(Request $request)
    {
        Banner::create($request->all());
        return redirect()->route('admin.banners.index');
    }
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.form', compact('banner'));
    }
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->update($request->all());
        return redirect()->route('admin.banners.index');
    }
    public function destroy($id)
    {
        Banner::destroy($id);
        return redirect()->route('admin.banners.index');
    }
}
