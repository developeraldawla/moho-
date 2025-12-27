<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use App\Services\N8nService;

class ToolController extends Controller
{
    protected $n8nService;

    public function __construct(N8nService $n8nService)
    {
        $this->n8nService = $n8nService;
    }

    public function index()
    {
        $tools = Tool::where('is_active', true)->get()->groupBy('category');
        return view('dashboard.tools.index', compact('tools'));
    }

    public function show(Tool $tool)
    {
        return view('dashboard.tools.show', compact('tool'));
    }

    public function execute(Request $request, Tool $tool)
    {
        // Validation logic based on $tool->input_fields schema would go here

        $inputs = $request->except('_token');

        // Handle File Uploads
        foreach ($request->allFiles() as $key => $file) {
            // Store file securely (local/S3)
            $path = $file->store('uploads/tools/' . $tool->id . '/' . auth()->id());
            // Pass URL to n8n (mocking a public URL here if local)
            $inputs[$key] = asset('storage/' . $path);
        }

        $result = $this->n8nService->executeTool($tool, auth()->user(), $inputs);

        if ($result['status'] === 'error') {
            return back()->with('error', $result['message']);
        }

        return back()->with('result', $result);
    }
}
