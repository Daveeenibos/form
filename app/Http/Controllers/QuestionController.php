<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request, Form $form)
    {
        $this->authorize('update', $form);

        $request->validate([
            'type' => 'required|string|in:' . implode(',', array_keys(Question::TYPES)),
            'title' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'is_required' => 'boolean',
            'options' => 'nullable|array',
            'options.*' => 'string|max:255',
        ]);

        $maxOrder = $form->questions()->max('order') ?? 0;

        $question = $form->questions()->create([
            'type' => $request->type,
            'title' => $request->title ?? 'Untitled Question',
            'description' => $request->description,
            'is_required' => $request->boolean('is_required'),
            'order' => $maxOrder + 1,
        ]);

        if ($request->has('options') && $question->hasOptions()) {
            foreach ($request->options as $index => $value) {
                $question->options()->create([
                    'value' => $value,
                    'order' => $index,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'question' => $question->load('options'),
        ]);
    }

    public function update(Request $request, Form $form, Question $question)
    {
        $this->authorize('update', $form);

        $request->validate([
            'type' => 'sometimes|string|in:' . implode(',', array_keys(Question::TYPES)),
            'title' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'is_required' => 'boolean',
            'options' => 'nullable|array',
            'options.*' => 'string|max:255',
        ]);

        $question->update($request->only(['type', 'title', 'description', 'is_required']));

        if ($request->has('options')) {
            $question->options()->delete();
            if ($question->hasOptions()) {
                foreach ($request->options as $index => $value) {
                    $question->options()->create([
                        'value' => $value,
                        'order' => $index,
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'question' => $question->fresh()->load('options'),
        ]);
    }

    public function destroy(Form $form, Question $question)
    {
        $this->authorize('update', $form);

        $question->delete();

        return response()->json(['success' => true]);
    }

    public function reorder(Request $request, Form $form)
    {
        $this->authorize('update', $form);

        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:questions,id',
        ]);

        foreach ($request->order as $index => $questionId) {
            Question::where('id', $questionId)->where('form_id', $form->id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
