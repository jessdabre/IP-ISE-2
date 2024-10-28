<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$xmlFile = 'data.xml';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['age'])) {
        $name = htmlspecialchars($_POST['name']);
        $age = htmlspecialchars($_POST['age']);

        if (file_exists($xmlFile)) {
            $xml = simplexml_load_file($xmlFile);
        } else {
            $xml = new SimpleXMLElement('<rows/>');
        }

        $row = $xml->addChild('row');
        $row->addChild('name', $name);
        $row->addChild('age', $age);

        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());

        if ($dom->save($xmlFile)) {
            echo 'success';
        } else {
            echo 'error saving XML';
        }
    } else {
        echo 'error: missing data';
    }
} else {
    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
        $response = '';
        foreach ($xml->row as $row) {
            $response .= '<tr><td>' . $row->name . '</td><td>' . $row->age . '</td></tr>';
        }
        echo $response;
    } else {
        echo ''; 
    }
}
?>
