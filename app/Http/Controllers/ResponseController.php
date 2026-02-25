<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function index(Form $form)
    {
        $this->authorize('update', $form);

        $responses = $form->responses()
            ->with('answers.question')
            ->latest('submitted_at')
            ->paginate(20);

        $form->load('questions');

        return view('responses.index', compact('form', 'responses'));
    }

    public function show(Form $form, Response $response)
    {
        $this->authorize('update', $form);

        $response->load('answers.question');
        $form->load('questions.options');

        return view('responses.show', compact('form', 'response'));
    }

    public function summary(Form $form)
    {
        $this->authorize('update', $form);

        $form->load(['questions.options', 'questions.answers']);
        $totalResponses = $form->responses()->count();

        $questionSummaries = [];
        foreach ($form->questions as $question) {
            $summary = [
                'question' => $question,
                'total' => $question->answers->count(),
            ];

            if (in_array($question->type, ['multiple_choice', 'dropdown'])) {
                $summary['data'] = $question->answers
                    ->groupBy('value')
                    ->map->count()
                    ->sortDesc();
            } elseif ($question->type === 'checkbox') {
                $allValues = [];
                foreach ($question->answers as $answer) {
                    $values = json_decode($answer->value, true) ?? [];
                    foreach ($values as $v) {
                        $allValues[] = $v;
                    }
                }
                $summary['data'] = collect($allValues)->countBy()->sortDesc();
            } else {
                $summary['data'] = $question->answers->pluck('value')->filter();
            }

            $questionSummaries[] = $summary;
        }

        return view('responses.summary', compact('form', 'totalResponses', 'questionSummaries'));
    }

    public function export(Form $form)
    {
        $this->authorize('update', $form);

        $form->load('questions');
        $responses = $form->responses()->with('answers')->get();

        $headers = ['#', 'Submitted At', 'Email'];
        foreach ($form->questions as $q) {
            $headers[] = $q->title;
        }

        $rows = [];
        foreach ($responses as $index => $response) {
            $row = [
                $index + 1,
                $response->submitted_at->format('Y-m-d H:i:s'),
                $response->respondent_email ?? '-',
            ];
            foreach ($form->questions as $q) {
                $answer = $response->answers->where('question_id', $q->id)->first();
                if ($answer) {
                    if ($q->type === 'checkbox') {
                        $row[] = implode(', ', json_decode($answer->value, true) ?? []);
                    } elseif ($q->type === 'file_upload') {
                        $row[] = $answer->file_path ? url('storage/' . $answer->file_path) : '-';
                    } else {
                        $row[] = $answer->value ?? '-';
                    }
                } else {
                    $row[] = '-';
                }
            }
            $rows[] = $row;
        }

        $filename = str_replace(' ', '_', $form->title) . '_responses.csv';

        return response()->streamDownload(function () use ($headers, $rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
