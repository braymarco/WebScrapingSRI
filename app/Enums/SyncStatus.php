<?php

namespace App\Enums;

class SyncStatus
{

    public static int $CREATED=1;
    public static int $ERROR=0;
    public static int $COMPLETE=2;

    public static array $MESSAGES=[
        'ERROR',
        'CREADO',
        'COMPLETADO',
    ];
}
