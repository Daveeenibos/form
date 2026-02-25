<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Response;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormResponseController extends Controller
{
    public function show(string $slug)
    {
        $form = Form::where('slug', $slug)
            ->active()
            ->with(['questions.options'])
            ->firstOrFail();

        return view('forms.show-public', compact('form'));
    }

    public function store(Request $request, string $slug)
    {
        $form = Form::where('slug', $slug)->active()->with('questions.options')->firstOrFail();

        // Build validation rules dynamically
        $rules = [];
        foreach ($form->questions as $question) {
            $key = 'answers.' . $question->id;

            if ($question->is_required) {
                $rules[$key] = 'required';
            } else {
                $rules[$key] = 'nullable';
            }

            switch ($question->type) {
                case 'short_text':
                    $rules[$key] .= '|string|max:255';
                    break;
                case 'paragraph':
                    $rules[$key] .= '|string|max:10000';
                    break;
                case 'multiple_choice':
                case 'dropdown':
                    $rules[$key] .= '|string';
                    break;
                case 'checkbox':
                    $rules[$key] = ($question->is_required ? 'required' : 'nullable') . '|array';
                    break;
                case 'date':
                    $rules[$key] .= '|date';
                    break;
                case 'time':
                    $rules[$key] .= '|string';
                    break;
                case 'file_upload':
                    $rules[$key] = ($question->is_required ? 'required' : 'nullable') . '|file|max:10240';
                    break;
            }
        }

        $request->validate($rules);

        $response = $form->responses()->create([
            'respondent_email' => $request->respondent_email,
            'submitted_at' => now(),
        ]);

        foreach ($form->questions as $question) {
            $value = $request->input('answers.' . $question->id);
            $filePath = null;

            if ($question->type === 'file_upload' && $request->hasFile('answers.' . $question->id)) {
                $filePath = $request->file('answers.' . $question->id)->store('uploads', 'public');
                $value = null;
            } elseif ($question->type === 'checkbox' && is_array($value)) {
                $value = json_encode($value);
            }

            if ($value !== null || $filePath !== null) {
                $response->answers()->create([
                    'question_id' => $question->id,
                    'value' => $value,
                    'file_path' => $filePath,
                ]);
            }
        }

        return redirect()->route('form.thank-you')->with('form_title', $form->title);
    }

    public function thankYou()
    {
        return view('forms.thank-you');
    }
}
