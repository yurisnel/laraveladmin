<?php
return [
    'state' => [
        1 => 'Activo',
        0 => 'Inactivo',
    ],
    'gender' => [
        0 => 'Desconocido',
        1 => 'Hombre',
        2 => 'Mujer',
        9 => 'No aplica',
    ],
    'civilstate' => [
        1 => 'Soltero/a',
        2 => 'En una relación',
        3 => 'Casado/a',
        4 => 'Viudo/a',
        5 => 'Divorciado/a',
        6 => 'Separado/a',
    ],
    'typeWarranty' => [
        1 => 'Política',
        2 => 'Garantia',
    ],
    'unitMeasure' => [
        1 => 'Unidad',
        2 => 'Litros',
        3 => 'Metros',
        4 => 'Kg',
        5 => 'Global',
    ],
	'currencies' => [
        1 => 'UF',
        2 => 'CLP',
        3 => 'USD'        
    ],
    'filewWarrantyPolicies'=> [
        'path' => 'warranties_policies',
        'htmlAccept' => '.pdf',
        'rulesMimes' => 'pdf',
        'sizeMaxKb' => 10 * 1024, // 10mb en kb
    ],
   
];
