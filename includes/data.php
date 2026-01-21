<?php
// --- SERVER SIDE DATA ---
// In a real application, this would come from a MySQL database.
// For now, we define the inventory here in PHP.

$products = [
    [
        "id" => 1,
        "name" => "Poly Aluminium Chloride (PAC)",
        "formula" => "Aln(OH)mCl3n-m",
        "category" => "Coagulation",
        "form" => "Powder (Yellow)",
        "purity" => "30%",
        "desc" => "High-efficiency coagulant for drinking water and wastewater treatment. Works over a wide pH range.",
        "price_index" => 2,
        "effectiveness" => 95
    ],
    [
        "id" => 2,
        "name" => "Aluminum Sulfate (Alum)",
        "formula" => "Al₂(SO₄)₃",
        "category" => "Coagulation",
        "form" => "Lump / Granular",
        "purity" => "17%",
        "desc" => "Traditional cost-effective coagulant. Best for treating water with low color and turbidity.",
        "price_index" => 1,
        "effectiveness" => 85
    ],
    [
        "id" => 3,
        "name" => "TCCA 90",
        "formula" => "C₃Cl₃N₃O₃",
        "category" => "Disinfection",
        "form" => "Tablets / Granules",
        "purity" => "90%",
        "desc" => "Trichloroisocyanuric Acid. Slow-release organic chlorine. Highly stable and effective biocide.",
        "price_index" => 3,
        "effectiveness" => 99
    ],
    [
        "id" => 4,
        "name" => "Sodium Hypochlorite", 
        "formula" => "NaOCl",
        "category" => "Disinfection",
        "form" => "Liquid",
        "purity" => "12-15%",
        "desc" => "Liquid chlorine bleach. Fast-acting disinfectant for immediate pathogen control.",
        "price_index" => 1,
        "effectiveness" => 92
    ],
    [
        "id" => 5,
        "name" => "Caustic Soda Flakes",
        "formula" => "NaOH",
        "category" => "pH Control",
        "form" => "Flakes (White)",
        "purity" => "98%",
        "desc" => "Sodium Hydroxide. Strong base used to neutralize acidic water and protect pipes from corrosion.",
        "price_index" => 2,
        "effectiveness" => 100
    ],
    [
        "id" => 6,
        "name" => "Ferric Chloride",
        "formula" => "FeCl₃",
        "category" => "Coagulation",
        "form" => "Liquid (Dark Brown)",
        "purity" => "40%",
        "desc" => "Effective for sludge conditioning and heavy metal removal. Works well in lower temperatures.",
        "price_index" => 2,
        "effectiveness" => 90
    ],
    [
        "id" => 7,
        "name" => "Activated Carbon",
        "formula" => "C",
        "category" => "Flocculation", 
        "form" => "Granular",
        "purity" => "Iodine > 900",
        "desc" => "Removes organic contaminants, taste, and odor. Essential for tertiary treatment.",
        "price_index" => 3,
        "effectiveness" => 88
    ],
    [
        "id" => 8,
        "name" => "Hydrochloric Acid",
        "formula" => "HCl",
        "category" => "pH Control",
        "form" => "Liquid",
        "purity" => "33%",
        "desc" => "Strong acid used for lowering pH and descaling equipment.",
        "price_index" => 1,
        "effectiveness" => 100
    ]
];
?>
