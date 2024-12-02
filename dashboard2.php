<?php
// Load JSON results from Python script
$jsonData = file_get_contents("analysis_results.json");
$data = json_decode($jsonData, true);

// Display results
echo "<h1>Personal Finance Analysis</h1>";
echo "<p>Total Salary: $" . $data['total_salary'] . "</p>";
echo "<p>Total Expenses: $" . $data['total_expense'] . "</p>";
echo "<p>Balance Left: $" . $data['balance_left'] . "</p>";

echo "<h2>Spending by Category:</h2>";
echo "<ul>";
foreach ($data['spending_by_category'] as $category => $amount) {
    echo "<li>$category: $$amount</li>";
}
echo "</ul>";

echo "<h2>Suggestions:</h2>";
echo "<ul>";
foreach ($data['suggestions'] as $suggestion) {
    echo "<li>$suggestion</li>";
}
echo "</ul>";
?>
