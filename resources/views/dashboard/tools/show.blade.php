@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="{ loading: false }">
    
    <!-- Left Column: Tool Input -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Tool Info -->
        <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-lg bg-primary-100 dark:bg-primary-900/20 flex items-center justify-center text-xl mr-3">
                    {{ $tool->icon ?? '⚡' }}
                </div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    {{ app()->getLocale() == 'tr' ? $tool->name_tr : $tool->name_en }}
                </h1>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                {{ app()->getLocale() == 'tr' ? $tool->description_tr : $tool->description_en }}
            </p>
            <div class="text-xs text-gray-400 border-t border-gray-100 dark:border-gray-700 pt-4">
                Remaining Today: <span class="font-bold text-primary-600">10 uses</span>
            </div>
        </div>

        <!-- Input Form -->
        <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Configuration</h2>
            
            <form action="{{ route('tools.execute', $tool->id) }}" method="POST" enctype="multipart/form-data" @submit="loading = true">
                @csrf
                
                <div class="space-y-4">
                    @if($tool->input_fields)
                        @foreach($tool->input_fields as $field)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ $field['label'] ?? ucfirst($field['name']) }}
                                    @if(isset($field['required']) && $field['required']) <span class="text-red-500">*</span> @endif
                                </label>
                                
                                @if($field['type'] === 'text')
                                    <input type="text" name="{{ $field['name'] }}" class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white sm:text-sm" placeholder="{{ $field['placeholder'] ?? '' }}" {{ isset($field['required']) ? 'required' : '' }}>
                                @elseif($field['type'] === 'number')
                                    <input type="number" name="{{ $field['name'] }}" class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white sm:text-sm" {{ isset($field['required']) ? 'required' : '' }}>
                                @elseif($field['type'] === 'textarea')
                                    <textarea name="{{ $field['name'] }}" rows="3" class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white sm:text-sm" {{ isset($field['required']) ? 'required' : '' }}></textarea>
                                @elseif($field['type'] === 'file')
                                    <input type="file" name="{{ $field['name'] }}" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100" {{ isset($field['required']) ? 'required' : '' }}>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback default field if no schema -->
                        <div>
                             <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prompt / Input</label>
                             <textarea name="input" rows="4" class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white sm:text-sm" required></textarea>
                        </div>
                    @endif
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" :disabled="loading">
                        <span x-show="!loading">Run Analysis</span>
                        <span x-show="loading" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column: Results -->
    <div class="lg:col-span-2">
        @if(session('result'))
            <div class="bg-white dark:bg-dark-card rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden animate-fade-in">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Analysis Result</h3>
                </div>
                
                <div class="p-6">
                    @php $result = session('result'); $type = $result['type'] ?? 'text'; $data = $result['data'] ?? []; @endphp

                    <!-- 1. Text Result -->
                     @if($type == 'text')
                        <div class="prose dark:prose-invert max-w-none">
                            {!! nl2br(e($data['content'] ?? json_encode($data))) !!}
                        </div>
                    
                    <!-- 2. Image Result -->
                    @elseif($type == 'image')
                        <div class="flex justify-center">
                            <img src="{{ $data['url'] }}" alt="Generated Image" class="rounded-lg shadow-md max-h-96">
                        </div>
                    
                    <!-- 3. Excel Visualization -->
                    @elseif($type == 'excel_viz')
                        <div class="space-y-6">
                            <div class="h-80 w-full relative">
                                <canvas id="excelChart"></canvas>
                            </div>
                            
                            <!-- Simple Data Table Preview -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            @foreach($data['preview_headers'] ?? [] as $header)
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $header }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-dark-card divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($data['preview_rows'] ?? [] as $row)
                                            <tr>
                                                @foreach($row as $cell)
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $cell }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const ctx = document.getElementById('excelChart').getContext('2d');
                                new Chart(ctx, {
                                    type: '{{ $data['chart_type'] ?? 'bar' }}',
                                    data: {
                                        labels: {!! json_encode($data['chart_labels'] ?? []) !!},
                                        datasets: [{
                                            label: '{{ $data['chart_title'] ?? 'Dataset' }}',
                                            data: {!! json_encode($data['chart_values'] ?? []) !!},
                                            backgroundColor: '#0ea5e9',
                                            borderColor: '#0284c7',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false
                                    }
                                });
                            });
                        </script>
                    @endif
                </div>
            </div>
        @else
            <!-- Placeholder State -->
            <div class="bg-white dark:bg-dark-card rounded-xl border-dashed border-2 border-gray-300 dark:border-gray-700 h-96 flex flex-col items-center justify-center text-center p-6 text-gray-400">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                <h3 class="font-medium text-gray-900 dark:text-white mb-2">Ready to Analyze</h3>
                <p class="max-w-xs">Configure the parameters on the left and click "Run Analysis".</p>
            </div>
        @endif
    </div>

</div>
@endsection
