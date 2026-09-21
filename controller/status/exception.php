<?php
    view( 'status/exception.view.php', 'basePath', [
        'exception' => $exception->getMessage(),
        'code' => $exception->getCode()
    ] );