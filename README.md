

<h1>AI Clinical Note Summarizer</h1>

A lightweight Laravel-based tool that helps doctors and clinicians quickly extract the most important information from long clinical notes using GROQ AI.

This application provides:

Fast summarization of raw clinical notes

Structured medical insights (Summary, Key Findings, Suggested Follow-up)

Simple REST API endpoint

Clean UI for entering notes and viewing results

Optional database storage for summaries

🚀 Features

Summarizes long, unstructured clinical notes into readable bullet points

Powered by GROQ LLaMA 3.3 model

Clean and responsive frontend using TailwindCSS

API-first architecture

Easily extendable (PDF export, authentication, dashboards, etc.)

📦 Installation
1. Clone the repository
git clone https://github.com/henryhkb/ai-clinical-note-summarizer.git
cd ai-clinical-note-summarizer

2. Install dependencies
composer install
npm install   # only if you want to compile Tailwind locally

3. Set environment variables

Copy the example file:

cp .env.example .env


Update your .env with:

APP_KEY=base64:xxxxxx...
GROQ_API_KEY=your_groq_api_key_here


Generate key:

php artisan key:generate

4. Run migrations (optional if storing summaries)
php artisan migrate

5. Start the server
php artisan serve

🧪 API Documentation
POST /api/summarize

Summarizes a clinical note into structured bullet points.

Request Body
{
  "note": "Patient presents with shortness of breath..."
}

Response Example
{
  "summary": "- Summary bullet points...\n- Key findings...\n- Suggested follow-up..."
}

📁 Project Structure
app/
│── Http/
│   └── Controllers/
│       └── ClinicalNoteController.php
│
├── Models/
│   └── ClinicalSummary.php   # if you enabled DB saving
│
routes/
│── api.php
│
resources/
└── views/
    └── summarize.blade.php

🛠 Technologies Used

Laravel 12

PHP 8.4

GROQ LLaMA 3.3 API

TailwindCSS

MySQL / SQLite (optional)

⭐ Why This Project?

Hospitals and clinics deal with long, unstructured notes.
This tool gives:

Faster review for doctors

Better clarity for clinical decision-making

A foundation for larger AI-powered medical tools

🤝 Contributing

Pull requests are welcome.
For major changes, open an issue to discuss what you’d like to change.

📜 License

This project is open-source under the MIT License.
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
