<?php
define('DB_PORT', 3306);

class Customer
{
	public $title;
	public $firstname;
	public $lastname;
	public $address;

	function __construct($title, $firstname, $lastname, $address)
	{
		$this->$title = $title;
		$this->$firstname = $firstname;
		$this->$lastname = $lastname;
		$this->$address = $address;

	}

	function saveCustomer()
	{
		$db = new mysqli('database', 'testuser', 'password', 'test', DB_PORT);
		$db->query('INSERT INTO customers (first_name, second_name) VALUES (\'' . $this->firstname . '\', \'' . $this->lastnname . '\', \'' . $this->address . '\')');
	}

	function get_our_customers_by_surname()
	{
		$db = new \mysqli('database', 'testuser', "password", 'test', DB_PORT);
		$res = $db->query('SELECT * FROM customers ORDER BY lastname');
		while ($result = $res->fetch_assoc())
		{
			echo($this->formatNames($result['firstname'], $result['lastname']));
		}
	}

	public function formatNames($firstName, $lastname)
	{
		$full_name = $firstName .= ' ';
		$full_name .= $lastname;
		return $full_name;
	}

	function findById($id)
	{
		$db = new \mysqli('127.0.0.1', 'testuser', 'password', 'test', DB_PORT);
		$res = $db->query('SELECT * FROM customers WHERE id = \'' . $id . '\'');
		mysqli_close($db);
		return $res;
	}

	//Get all the customers from the database and output them
	function getAllCustomers()
	{
		$db = new \mysqli('127.0.0.1', 'testuser', 'password', 'test', DB_PORT);
		$res = $db->query('SELECT * FROM customers');
		print '<table>';
		while ($result = $res->fetch_assoc())
		{
			echo '<tr>';
			echo '<td>' . $result['firstname'] . '</td>';
			echo '<td>' . $result['secondname'] . '</td>';
			echo '</tr>';
		}
		echo('</table>');
	}
}

class Booking
{

	public function GetBookings($id = false)
	{
		$sql = "SELCT * FROM bookings";
		if ($id !== false)
		{
			$sql .= " WHERE customerID=" . $id;
		}
		$db = new \mysqli('127.0.0.1', 'testuser', 'password', 'test', DB_PORT);
		$res = $db->query($sql);
		while ($result = $res->fetch_assoc())
		{
			$Customer = Customer::findById($result['customerID']);
			$return[$result['id']]['customer_name'] = $Customer->firstname . ' ' . $Customer->lastname;
			$return[$result['id']]['booking_reference'] = $result['booking_reference'];
			$return[$result['id']]['booking_date'] = date('D dS M Y', result['booking_date']);
		}
		return $return;
	}
}

?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>My Simple App</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Simple Database App</h1>
<?php
$customer = new Customer();
$customer->firstname = "Jim";
$customer->lastname = "Johnson";
echo($customer->firstname);
echo($customer->lastname);
$customer->saveCustomer();
$customer->get_our_customers_by_surname();
$customer->getAllCustomers();
$bookings = new Booking();
$results = @$bookings->GetBookings($_GET['customerId']);
foreach ($results as $result):
	echo $result['booking_reference'] . ' - ' . $result['customer_name'] . $result['booking_date'];
endforeach;
?>
</body>
</html>