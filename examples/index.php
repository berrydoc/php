<?php
require __DIR__ . '/vendor/autoload.php';

use BerryDoc\Php\DocumentGenerator;

$email = "<email>";
$password = "<password>";

try {
  $generator = new DocumentGenerator($email, $password);

  $data = json_decode(file_get_contents("files/Letter.json"), true);
  $fileContent = $generator->generate("<templateId>", $data, "pdf", "file");
  file_put_contents("Letter.pdf", $fileContent);

} catch (Exception $e) {
  $error = json_decode($e->getMessage(), true);
  print_r($error);
}
