<?php
header('Content-Type: application/json');

// Decode the incoming JSON data
$data = json_decode(file_get_contents("php://input"), true);
$chief_complaint = strtolower(trim($data['complaint'] ?? ''));


// Handle empty input
if (!$chief_complaint) {
    echo json_encode([
        "suggestions" => $foundSuggestions,
        "information" => $information,
        "symptoms" => $ai_suggest[$closestMatch]["symptoms"] ?? "No symptoms listed.",
        "prevention" => $ai_suggest[$closestMatch]["prevention"] ?? "No prevention steps available.",
        "treatment" => $treatments,
        "medicine" => $medicine  // ✅ Added this line
    ]);
    exit;
}




// ai suggestions are in ai_suggestions.php file
include 'ai_suggestions.php';



// Initialize response variables
$foundSuggestions = [];
$information = "No specific information found. Please consult a healthcare provider.";
$treatment = "No specific treatment found.";

// **Exact & Partial Match**
foreach ($ai_suggest as $key => $value) {
    if (strpos($key, $chief_complaint) !== false || strpos($chief_complaint, $key) !== false) {
        $foundSuggestions[] = ucfirst($key);
        $information = $value["info"];
        $treatment = $value["treatment"];
    }
}

// **Fuzzy Matching (Levenshtein Algorithm)**
if (empty($foundSuggestions)) {
    $closestMatch = null;
    $shortestDistance = PHP_INT_MAX;

    foreach ($ai_suggest as $key => $value) {
        $levDistance = levenshtein($chief_complaint, $key);
        if ($levDistance < $shortestDistance) {
            $closestMatch = $key;
            $shortestDistance = $levDistance;
        }
    }

    if ($closestMatch) {
        $foundSuggestions[] = ucfirst($closestMatch);
        $information = $ai_suggest[$closestMatch]["info"];
        $treatment = $ai_suggest[$closestMatch]["treatment"];
    }
}
// **Final JSON Response**
$symptoms = "No symptoms listed.";
$prevention = "No prevention steps available.";

if (!empty($foundSuggestions)) {
    $firstSuggestion = strtolower($foundSuggestions[0]);
    if (isset($ai_suggest[$firstSuggestion])) {
        $symptoms = $ai_suggest[$firstSuggestion]["symptoms"] ?? "No symptoms listed.";
        $prevention = $ai_suggest[$firstSuggestion]["prevention"] ?? "No prevention steps available.";
        $medicine = $ai_suggest[$firstSuggestion]["medicine"] ?? "No recommended medicine found.";
    }
}

echo json_encode([
    "suggestions" => $foundSuggestions,
    "information" => $information,
    "symptoms" => $symptoms,
    "prevention" => $prevention,
    "treatment" => $treatment,
    "medicine" => $medicine  // ✅ Added this line
]);


?>
