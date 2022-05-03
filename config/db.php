<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=ec2-63-32-248-14.eu-west-1.compute.amazonaws.com;port=5432;dbname=d6faffo224vg96',
    'username' => 'hewbpfnwxzzquz',
    'password' => 'c1a661d5a399cc7e7e7ae4847b9100d899c423c8f336a9426cd22f59368f2769',
    'charset' => 'utf8',
    'schemaMap' => [
        'pgsql'=> [
            'class'=>'yii\db\pgsql\Schema',
            'defaultSchema' => 'public' //specify your schema here
        ]
    ]
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
