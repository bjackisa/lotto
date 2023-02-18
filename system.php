Write a lottery system 

<?php
// Connect to the database
$db = mysqli_connect('localhost', 'username', 'password', 'database');

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
 
// Create a lottery ticket table in the database
$sql = "CREATE TABLE lottery_tickets (
    ticket_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    ticket_number VARCHAR(20) NOT NULL,
    ticket_owner VARCHAR(50) NOT NULL,
    ticket_date DATE NOT NULL
)";

if (mysqli_query($db, $sql)) {
    echo "Table lottery_tickets created successfully";
} else {
    echo "Error creating table: " . mysqli_error($db);
}

// Generate a random ticket number
function generateTicketNumber() {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $ticketNumber = '';
    for ($i = 0; $i < 20; $i++) {
        $ticketNumber .= $characters[rand(0, $charactersLength - 1)];
    }
    return $ticketNumber;
}

// Create a new ticket
function createTicket($owner) {
    global $db;
    $ticketNumber = generateTicketNumber();
    $date = date('Y-m-d');
    $sql = "INSERT INTO lottery_tickets (ticket_number, ticket_owner, ticket_date)
            VALUES ('$ticketNumber', '$owner', '$date')";
    if (mysqli_query($db, $sql)) {
        return $ticketNumber;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
}

// Get a ticket by its number
function getTicketByNumber($ticketNumber) {
    global $db;
    $sql = "SELECT * FROM lottery_tickets WHERE ticket_number = '$ticketNumber'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

// Get all tickets for a given owner
function getTicketsByOwner($owner) {
    global $db;
    $sql = "SELECT * FROM lottery_tickets WHERE ticket_owner = '$owner'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return false;
    }
}

// Close the connection
mysqli_close($db);
?>
