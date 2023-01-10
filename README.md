## PHPTable

This package helps to render array of data as an HTML table. Demo templates uses Bootstrap classes and written using Twig template engine.

### How to install and use

    composer require pliusnin/php-table

Usage is simple as that. First, include required dependencies:

    use PhpTable\DataTable\DataTableFactory;
    use Twig\Environment;
    use Twig\Loader\FilesystemLoader;

Then you have to prepare array of data which should be rendered in the table. It's simple array of arrays:

    $dataArray = [
        [
            'id' => 1,
            'firstName' => 'Dow',
            'lastName' => 'Jones',
            'email' => 'dow,jones@gmail.com'
        ] 
    ];

After that you need to initiate Twig environment to the path you have templates: 

    $twig = new Environment(new FilesystemLoader(['path/to/templates']));

Twig instance should be passed to DataTableFactory as a parameter. Then `create` method should be called with data and configuration as parameters:

    $dataTableRenderer = (new DataTableFactory($twig))->create($dataArray, [
        'id' => ['label' => 'ID'],
        'name' => [
          'label' => 'Full Name', // heading label of the column
          'format' => function ($row) { //you can format what and how should be rendered in the field
              return $row['lastName'] . ', ' . $row['firstName'];
          },
          'order' => 2 // you can change the order of column
        ],
        'email' => [
            'label' => 'Email',
        ]
    ]);

In the place you want to render the table and pagination, call these methods:

    $dataTableRenderer->render(); // return HTML string
    $dataTableRenderer->renderPagination(); // return HTML string

Enjoy!
Templates can be customized, just create your own and pass the path to the Twig Environment. Follow the structure and logic of the original twig templates.
