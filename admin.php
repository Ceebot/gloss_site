<?
require_once 'php/header.php';

$dataFinance = $mysql->query("SELECT * FROM finance ORDER BY date DESC");

$finance = [];

while ($item = $dataFinance->fetch_assoc()) {
    $finance[] = [
        'id' => $item['id'],
        'name' => $item['name'],
        'quantity' => $item['quantity'],
        'price' => $item['price'],
        'date' => $item['date'],
        'type' => $item['type'],
    ];
}

$dataApplication = $mysql->query("SELECT * FROM application");

$application = [];

while ($item = $dataApplication->fetch_assoc()) {
    $application[] = [
        'id' => $item['id'],
        'name' => $item['name'],
        'tel' => $item['tel'],
        'mail' => $item['mail'],
        'text' => $item['text'],
        'date' => $item['date'],
    ];
}

$dataReview = $mysql->query("SELECT * FROM review");

$review = [];

while ($item = $dataReview->fetch_assoc()) {
    $review[] = [
        'id' => $item['id'],
        'review' => $item['review'],
        'name' => $item['name'],
        'mail' => $item['mail'],
        'date' => $item['date'],
    ];
}

$dataProducts = $mysql->query("SELECT * FROM product");

$product = [];

while ($item = $dataProducts->fetch_assoc()) {
    $product[] = [
        'id' => $item['id'],
        'title' => $item['title'],
        'volume' => $item['volume'],
        'price' => $item['price'],
    ];
}

$dataServices = $mysql->query("SELECT * FROM service");

$service = [];

while ($item = $dataServices->fetch_assoc()) {
    $service[] = [
        'id' => $item['id'],
        'title' => $item['title'],
        'description' => $item['description'],
        'price' => $item['price'],
        'img' => $item['img'],
    ];
}

echo vueTag('vue-nav-data', [
    'finance' => $finance,
    'application' => $application,
    'review' => $review,
    'product' => $product,
    'service' => $service,
]);

require_once 'php/footer.php';
