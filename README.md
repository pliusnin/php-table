## PHPTable

This package helps to render array of data as an HTML table. Demo templates uses Bootstrap classes and written using Twig template engine.

### How to install and use

    composer require

Then you have to do in your PHP:

    use PhpTable\DataTable\DataTableFactory;
    use Twig\Environment;
    use Twig\Loader\FilesystemLoader;

    $dataArray = [ [keys => values] ]; // data from database
    $twig = new Environment(new FilesystemLoader(['path/to/templates']));
    $dataTableRenderer = (new DataTableFactory($twig))->create($dataArray, [
        'id' => ['label' => 'ID'],
        'name' => [
          'label' => 'Full Name', // heading label of the column
          'format' => function ($row) { //you can format what and how should be rendered in the field
              return $row['lastName'] . ', ' . $row['firstName'];
          },
          'order' => 2 // you can change the order of column
        ]
    ]);
    ...
    // call these methods where you need to render table
    $dataTableRenderer->render(); // return HTML string
    $dataTableRenderer->renderPagination(); // return HTML string