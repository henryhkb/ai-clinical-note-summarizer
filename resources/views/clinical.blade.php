<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AI Clinical Note Summarizer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-6 flex justify-center">

<div class="max-w-3xl w-full bg-white rounded-2xl shadow p-8">

    <h1 class="text-3xl font-bold text-center mb-6">AI Clinical Note Summarizer</h1>

    <label class="block text-gray-700 mb-2">Enter Clinical Note</label>
    <textarea id="note" class="w-full border rounded-lg p-3 h-40 focus:ring-2"
              placeholder="Paste clinical note here..."></textarea>

    <button onclick="summarizeNote()"
            class="w-full mt-4 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
        Summarize
    </button>

    <div id="loading" class="hidden text-center mt-4">
        <div class="animate-spin h-10 w-10 border-t-4 border-blue-500 rounded-full mx-auto"></div>
        <p class="text-gray-600 mt-2">Summarizing...</p>
    </div>

    <div id="result" class="hidden mt-6 p-6 bg-gray-50 border rounded-xl"></div>

    <!-- Export PDF -->
    <button id="pdfBtn" onclick="exportPDF()" 
            class="hidden w-full mt-4 bg-green-600 text-white py-3 rounded-lg hover:bg-green-700">
        Export PDF
    </button>

</div>

<script>
    function summarizeNote() {
        let note = document.getElementById("note").value.trim();
        if (!note) return alert("Please enter a note.");

        document.getElementById("loading").classList.remove("hidden");
        document.getElementById("result").classList.add("hidden");

        fetch("/api/summarize", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({note})
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById("loading").classList.add("hidden");
            document.getElementById("result").classList.remove("hidden");
            document.getElementById("pdfBtn").classList.remove("hidden");

            document.getElementById("result").innerHTML = `
                <h2 class="text-xl font-bold mb-3">Clinical Summary</h2>
                <div class="prose">${data.summary.replace(/\n/g, "<br>")}</div>
            `;
        })
        .catch(err => alert("Error: " + err));
    }

    function exportPDF() {
        window.print(); // simple export for now
    }
</script>

</body>
</html>
