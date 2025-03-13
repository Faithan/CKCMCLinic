<?php
header('Content-Type: application/json');

// Read and decode input JSON
$data = json_decode(file_get_contents("php://input"), true);
$chief_complaint = strtolower(trim($data['complaint'] ?? ''));

if (!$chief_complaint) {
    echo json_encode(["suggestion" => "Please provide a complaint."]);
    exit;
}

// Expanded AI suggestions with more symptoms and treatments
$suggestions = [
    "headache" => "Try drinking water, resting, or taking a mild pain reliever like ibuprofen or acetaminophen.",
    "migraine" => "Stay in a dark, quiet room, use a cold compress, and take prescribed migraine medication.",
    "fever" => "Stay hydrated, rest, take a fever reducer (paracetamol/ibuprofen), and monitor temperature.",
    "cough" => "Drink warm fluids, use a humidifier, try honey with tea, and avoid cold air.",
    "cold" => "Drink plenty of fluids, rest, use saline nasal spray, and take vitamin C or zinc supplements.",
    "flu" => "Get plenty of rest, stay hydrated, use over-the-counter flu medication, and take warm baths.",
    "stomach ache" => "Try ginger tea, avoid spicy food, eat light meals, and rest your stomach.",
    "diarrhea" => "Drink oral rehydration solutions (ORS), eat bananas, rice, toast, and avoid dairy products.",
    "constipation" => "Increase fiber intake, drink plenty of water, exercise, and try natural laxatives.",
    "sore throat" => "Gargle with warm salt water, drink soothing teas, use throat lozenges, and stay hydrated.",
    "ear pain" => "Use warm compresses, take mild pain relievers, and avoid inserting objects in the ear.",
    "back pain" => "Try stretching, apply heat or cold packs, and use ergonomic support when sitting.",
    "muscle pain" => "Use a hot compress, massage the area, stay hydrated, and do light stretching.",
    "joint pain" => "Rest the affected joint, use cold packs, take anti-inflammatory medication, and do gentle exercises.",
    "toothache" => "Rinse mouth with warm salt water, apply a cold compress, and see a dentist if pain persists.",
    "dizziness" => "Sit or lie down immediately, drink water, and avoid sudden movements.",
    "chest pain" => "If severe, seek emergency care. Otherwise, rest, stay calm, and avoid heavy meals.",
    "shortness of breath" => "Sit upright, use a fan for fresh air, and try deep breathing exercises.",
    "anxiety" => "Practice deep breathing, meditate, engage in physical activity, and talk to a professional if needed.",
    "insomnia" => "Avoid caffeine before bed, maintain a sleep routine, and create a relaxing environment.",
    "skin rash" => "Apply aloe vera or anti-itch cream, avoid allergens, and keep the skin moisturized.",
    "burn" => "Run cool water over the burn for 10 minutes, apply aloe vera, and avoid popping blisters.",
    "allergic reaction" => "Take antihistamines, use a cold compress, and avoid allergens. Seek emergency care if severe.",
    "food poisoning" => "Drink plenty of fluids, eat bland foods, and rest. Seek medical help if symptoms persist.",
    "vomiting" => "Drink small sips of water, rest, and avoid heavy foods until symptoms improve.",
    "fatigue" => "Ensure proper sleep, manage stress, stay hydrated, and maintain a balanced diet."
];

// Find the closest matching complaint
$suggestion = "No specific treatment found. Please consult a healthcare provider.";
foreach ($suggestions as $key => $value) {
    if (strpos($chief_complaint, $key) !== false) {
        $suggestion = $value;
        break;
    }
}

// Return the suggestion
echo json_encode(["suggestion" => $suggestion]);
?>
