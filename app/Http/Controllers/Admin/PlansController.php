<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('admin.plans.index', compact('plans'));
    }
    public function create()
    {
        return view('admin.plans.form');
    }
    public function store(Request $request)
    {
        Plan::create($request->all());
        return redirect()->route('admin.plans.index');
    }
    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        return view('admin.plans.form', compact('plan'));
    }
    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);
        $plan->update($request->all());
        return redirect()->route('admin.plans.index');
    }
    public function destroy($id)
    {
        Plan::destroy($id);
        return redirect()->route('admin.plans.index');
    }
}
