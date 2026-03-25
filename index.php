<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Session.php';
require_once __DIR__ . '/src/Validator.php';
require_once __DIR__ . '/src/NumberGenerator.php';
require_once __DIR__ . '/src/Statistics.php';

Session::start();

$errores = [];
$formValues = [];
$resultado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = new Validator();
    if ($validator->validate($_POST)) {
        $generator = new NumberGenerator(
            $validator->getN(),
            $validator->getRangoMin(),
            $validator->getRangoMax()
        );
        $numeros = $generator->generate();
        $stats = new Statistics($numeros);
        Session::set('resultado', [
            'numeros' => $numeros,
            'stats' => [
                'suma' => $stats->getSuma(),
                'promedio' => $stats->getPromedio(),
                'minimo' => $stats->getMinimo(),
                'maximo' => $stats->getMaximo(),
            ],
            'n' => $validator->getN(),
            'rangoMin' => $validator->getRangoMin(),
            'rangoMax' => $validator->getRangoMax(),
        ]);
    } else {
        Session::set('errores', $validator->getErrors());
        Session::set('formValues', $_POST);
    }
    header('Location: index.php');
    exit;
}

if (Session::has('errores')) {
    $errores = Session::get('errores', []);
    Session::remove('errores');
}
if (Session::has('formValues')) {
    $formValues = Session::get('formValues', []);
    Session::remove('formValues');
}
if (Session::has('resultado')) {
    $resultado = Session::get('resultado');
    Session::remove('resultado');
}

require_once __DIR__ . '/views/layout.php';
