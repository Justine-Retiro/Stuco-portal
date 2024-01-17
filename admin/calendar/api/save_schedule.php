<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Stuco/connection/connection.php');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $response['message'] = 'Error: No data to save.';
} else {
    // Use filter_input_array to sanitize input data
    $input_data = filter_input_array(INPUT_POST, [
        'id' => FILTER_SANITIZE_NUMBER_INT,
        'title' => ['filter' => FILTER_CALLBACK, 'options' => 'filter_var', 'flags' => FILTER_SANITIZE_FULL_SPECIAL_CHARS],
        'description' => ['filter' => FILTER_CALLBACK, 'options' => 'filter_var', 'flags' => FILTER_SANITIZE_FULL_SPECIAL_CHARS],
        'start_datetime' => ['filter' => FILTER_CALLBACK, 'options' => 'filter_var', 'flags' => FILTER_SANITIZE_FULL_SPECIAL_CHARS],
        'end_datetime' => ['filter' => FILTER_CALLBACK, 'options' => 'filter_var', 'flags' => FILTER_SANITIZE_FULL_SPECIAL_CHARS],
        'allday' => ['filter' => FILTER_CALLBACK, 'options' => 'filter_var', 'flags' => FILTER_SANITIZE_FULL_SPECIAL_CHARS]
    ]);

    $allday = isset($input_data['allday']);

    if (empty($input_data['id'])) {
        $stmt = $conn->prepare("INSERT INTO calendar (title, event_description, start_datetime, end_datetime) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $input_data['title'], $input_data['description'], $input_data['start_datetime'], $input_data['end_datetime']);
    } else {
        $stmt = $conn->prepare("UPDATE calendar SET title = ?, event_description = ?, start_datetime = ?, end_datetime = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $input_data['title'], $input_data['description'], $input_data['start_datetime'], $input_data['end_datetime'], $input_data['id']);
    }

    if ($stmt->execute()) {
        
        // After successfully inserting or updating the calendar event
        $event_notification_title = "New Event Scheduled";
        $event_notification_message = "Event: " . $input_data['title'] . " - " . $input_data['description'];

        // Get all user_ids to broadcast the new event
        $user_ids_result = $conn->query("SELECT id FROM council_user");

        $event_notification_stmt = $conn->prepare("INSERT INTO notifications (user_id, title, message) VALUES (?, ?, ?)");

        // Loop through all user_ids and insert a notification for each
        while ($row = $user_ids_result->fetch_assoc()) {
            $event_user_id = $row['id'];
            $event_notification_stmt->bind_param("iss", $event_user_id, $event_notification_title, $event_notification_message);
            $event_notification_stmt->execute();
        }

        $response = ['success' => true, 'message' => 'Schedule Successfully Saved.'];
    } else {
        $response['message'] = 'An Error occurred. Error: ' . htmlspecialchars($stmt->error);
    }
    
    $stmt->close();
}

$conn->close();
echo json_encode($response);