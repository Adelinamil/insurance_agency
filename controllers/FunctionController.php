<?php
namespace app\controllers;

use yii\rest\Controller;
use yii\widgets\ActiveForm;
use yii\web\Response;

class FunctionController extends Controller
{
    public function send($code, $data)
    {
        $response = $this->response;
        $response->format = Response::FORMAT_JSON;
        $response->data = $data;
        $response->statusCode = $code;
        return $response;
    }
    public function send_error($code, $message) {
        $error = ['error' => ['status' => $code, 'message' => $message]];
        return $this->send($code, $error);
    }

    public function validation($model)
    {
        $error = ['error' => ['status' => 422, 'message' => 'Validation error',
            'errors' => ActiveForm::validate($model)]];
        return $this->send(422, $error);
    }
}
?>