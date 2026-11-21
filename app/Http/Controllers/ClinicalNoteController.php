<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;
use App\Models\ClinicalSummary;

class ClinicalNoteController extends Controller
{
    public function summarize(Request $request)
    {
        $request->validate([
            'note' => 'required|string|max:20000',
        ]);

        $note = $request->note;

        $system = <<<EOT
You are an assistant that helps doctors understand long clinical notes.
Use only facts stated in the note. Do not invent values, diagnoses or history.
Return markdown ONLY, using exactly these three sections and headings:

## Summary
2–4 short bullet points: who the patient is, why they are here, the working diagnosis.

## Key findings
Bullet points of abnormal or decision-relevant findings, each with its value and unit where given.
Lead each bullet with the finding in **bold**, e.g. "**Creatinine 2.1 mg/dL** — up from baseline 1.2".

## Suggested follow-up
A numbered list of short, specific action items, most urgent first.

No preamble, no closing remarks, no disclaimers.
EOT;

        $client = OpenAI::factory()
            ->withApiKey(config('services.groq.key'))
            ->withBaseUri(config('services.groq.base_uri'))
            ->make();

        $response = $client->chat()->create([
            'model' => config('services.groq.model'),
            'messages' => [
                ['role' => 'system', 'content' => $system],
                ['role' => 'user', 'content' => "Clinical note:\n\n$note"],
            ],
        ]);

        $summary = $response->choices[0]->message->content ?? 'No summary generated.';

        // SAVE TO DATABASE
        $record = ClinicalSummary::create([
            'note' => $note,
            'summary' => $summary,
        ]);

        return response()->json([
            'record' => $record,
            'summary' => $summary,
        ]);
    }
}
