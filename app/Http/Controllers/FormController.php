<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function index(Request $request)
    {
        $forms = $request->user()
            ->forms()
            ->withCount('responses', 'questions')
            ->latest()
            ->get();

        return view('forms.index', compact('forms'));
    }

    public function create()
    {
        $categories = Form::CATEGORIES;
        return view('forms.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|in:' . implode(',', array_keys(Form::CATEGORIES)),
            'theme_color' => 'nullable|string|max:7',
        ]);

        $form = $request->user()->forms()->create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'theme_color' => $request->theme_color ?? '#673AB7',
            'slug' => Str::random(12),
        ]);

        return redirect()->route('forms.edit', $form)->with('success', 'Formulir berhasil dibuat!');
    }

    public function edit(Form $form)
    {
        $this->authorize('update', $form);

        $form->load(['questions.options']);

        return view('forms.edit', compact('form'));
    }

    public function update(Request $request, Form $form)
    {
        $this->authorize('update', $form);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|in:' . implode(',', array_keys(Form::CATEGORIES)),
            'theme_color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
            'requires_login' => 'boolean',
        ]);

        $form->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category ?? $form->category,
            'theme_color' => $request->theme_color ?? $form->theme_color,
            'is_active' => $request->boolean('is_active', $form->is_active),
            'requires_login' => $request->boolean('requires_login', $form->requires_login),
        ]);

        return redirect()->route('forms.edit', $form)->with('success', 'Formulir berhasil diperbarui!');
    }

    public function destroy(Form $form)
    {
        $this->authorize('delete', $form);

        $form->delete();

        return redirect()->route('forms.index')->with('success', 'Formulir berhasil dihapus!');
    }

    public function duplicate(Form $form)
    {
        $this->authorize('update', $form);

        $newForm = $form->replicate();
        $newForm->title = $form->title . ' (Salinan)';
        $newForm->slug = Str::random(12);
        $newForm->save();

        foreach ($form->questions as $question) {
            $newQuestion = $question->replicate();
            $newQuestion->form_id = $newForm->id;
            $newQuestion->save();

            foreach ($question->options as $option) {
                $newOption = $option->replicate();
                $newOption->question_id = $newQuestion->id;
                $newOption->save();
            }
        }

        return redirect()->route('forms.edit', $newForm)->with('success', 'Formulir berhasil diduplikasi!');
    }

    public function toggleStatus(Form $form)
    {
        $this->authorize('update', $form);

        $form->update(['is_active' => !$form->is_active]);

        return back()->with('success', 'Status formulir berhasil diubah!');
    }

    public function preview(Form $form)
    {
        $this->authorize('update', $form);

        $form->load(['questions.options']);

        return view('forms.preview', compact('form'));
    }
}
