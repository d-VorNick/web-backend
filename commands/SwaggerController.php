<?php

namespace app\commands;

use yii\console\Controller;
use Yii;
use yii\console\ExitCode;
use yii\helpers\Console;
use function OpenApi\scan;

class SwaggerController extends Controller
{

    public function actionGo()
    {
        $openApi = scan(Yii::getAlias('@app/controllers'));
        $file = Yii::getAlias('@app/web/api-doc/swagger.yaml');
        $handle = fopen($file, 'wb');
        fwrite($handle, $openApi->toYaml());
        fclose($handle);
        echo $this->ansiFormat('Created \n", Console::FG_BLUE');
        return ExitCode::OK;
    }

}
