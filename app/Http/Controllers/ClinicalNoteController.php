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
            'note' => 'required|string',
        ]);

        $note = $request->note;

        $system = <<<EOT
You are an assistant that helps doctors understand long clinical notes.
Return clean markdown text ONLY with:

- Summary (2–4 bullet points)
- Key Findings (bullets)
- Suggested Follow-up (short action items)
EOT;

        $client = OpenAI::factory()
            ->withApiKey(env('GROQ_API_KEY'))
            ->withBaseUri('https://api.groq.com/openai/v1')
            ->make();

        $response = $client->chat()->create([
            'model' => 'llama-3.3-70b-versatile',
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
