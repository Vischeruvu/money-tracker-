<?php
header('Content-Type: application/json');

// Retrieve the DynamoDB client instance from config.php
$dynamoDbClient = require 'config.php';

// Handle GET request to fetch expenses
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $result = $dynamoDbClient->scan([
            'TableName' => 'expenses'
        ]);

        $expenses = $result->get('Items');
        echo json_encode($expenses);
    } catch (AwsException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

// Handle POST request to add an expense
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $expenseData = json_decode(file_get_contents('php://input'), true);

    try {
        $result = $dynamoDbClient->putItem([
            'TableName' => 'expenses',
            'Item' => [
                'id' => ['N' => uniqid()],
                'description' => ['S' => $expenseData['description']],
                'amount' => ['N' => $expenseData['amount']]
            ]
        ]);

        echo json_encode($expenseData);
    } catch (AwsException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
