<?php

namespace app\modules\specialsection\controllers;

use Yii;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\validators\UrlValidator;
use app\modules\specialsection\models\Dataforms;
use app\modules\specialsection\models\Fieldsforms;
use app\modules\specialsection\models\ExtraFields;
use Aws\S3\S3Client;

use app\modules\specialsection\classes\Section;
use common\models\user;

/**
 * Default controller for the `newmodules` module
 */


class SectionController extends Controller
{

    protected $userRoles = [];

    public function beforeAction($action)
    {
        $userId = Yii::$app->user->id;

        $sections = Section::getSections();

        $access = [
            Section::PAIDEDU => 'paidedu',
            Section::GRANTS => 'grants',
            Section::DOCUMENT => 'document',
            Section::COMMON => 'common',
            Section::EDUSTANDARTS => 'edustandarts',
            Section::INTER => 'inter',
            Section::BUDGET => 'budget',
            Section::OBJECTS => 'objects',
            Section::CATERING => 'catering',
            Section::EDUCATION => 'education',
        ];

        //var_dump($sections);
        //die();
        /*
        array(10) { 
            [0]=> string(7) "paidedu"
             [1]=> string(6) "grants"
              [2]=> string(8) "document"
               [3]=> string(6) "common"
                [4]=> string(12) "edustandarts"
                 [5]=> string(5) "inter"
                  [6]=> string(6) "budget"
                   [7]=> string(7) "objects"
                    [8]=> string(8) "catering"
                     [9]=> string(9) "education" }
        */
        $accessIndex = 'index';
        $accessDelete = [
            'deletepaidedu',
            'deletegrants',
            'deletedocument',
            'deleteinter',
            'deletebudget',
            'deleteobjects'
        ];

        if (in_array($action->id, array_keys($access))) {
            $user = User::findOne($userId);

            $section = $access[$action->id];

            $roleName = 'editor_' . $section;

            if ($user->isInRole($roleName)) {
                //$trimmedNamesInRoles = SectionController::getSelfUserRoles($userId);
                //$this->userRoles = $trimmedNamesInRoles;
                return parent::beforeAction($action);
            } else {
                throw new \yii\web\ForbiddenHttpException('У вас нет доступа к этой странице.');
            }
        } else if ($action->id == $accessIndex) {
            return parent::beforeAction($action);
        } else if (in_array($action->id, $accessDelete)) {
            //    $userId = Yii::$app->user->id;
            //    $user = User::findOne($userId);
            //    switch ($action->id){
            //        case 'deletedocument':
            //            if ($user->isInRole('editor_')){
            //
            //            }
            //    }
            return parent::beforeAction($action);
        } else {
            throw new \yii\web\NotFoundHttpException("Запрашиваемая страница не найдена.");
        }
    }

    public function init()
    {
        parent::init();

        //$this->on(Controller::EVENT_BEFORE_ACTION, function ($event) {
        //    $event->sender->view->params['userRoles'] = $this->userRoles;
        //});
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        //var_dump();
        //die();
        $filteredMenuItems = self::getFilteredMenuItems();
        return $this->render('index', [
            'menuItems' => $filteredMenuItems,
        ]);
        //return $this->render('index',[]);
    }
    public function actionPaidedu()
    {
        $takedata = new Dataforms();
        $data = $takedata::find()
            ->joinWith('fieldsforms')
            ->andWhere(['fieldsforms.nameform' => 'paid_edu'])
            ->all();
        $request = Yii::$app->request;
        $key = $this->module->params['key'];
        $secret = $this->module->params['secret'];
        $endpoint = $this->module->params['endpoint'];
        $bucket = $this->module->params['Bucket'];
        //массив с разрешенными расширениями файлов
        $acTypesFileForUploading = array(
            "image/jpeg",//jpg or jpeg
            "image/png",//png
            "application/pdf",//pdf
            "application/msword",//doc (not docx)
            "application/vnd.ms-excel",//xls (not xlsx)
            "text/csv",//csv
            //"application/vnd.openxmlformats-officedocument.wordprocessingml.document",//docx
            //"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",//xlsx
            //"application/vnd.ms-powerpoint",//ppt
            //"application/vnd.openxmlformats-officedocument.presentationml.presentation",//pptx
        );
        if (isset($_FILES['document']) && $request->post('document')) {
            foreach ($_FILES['document']['name'] as $file => $name) {
                $link = '';
                $p = 0;
                $position = '';
                //Проверка на наличие файла
                if ($name != '') {
                    $testMimeType = FileHelper::getMimeTypeByExtension($name);
                    //Проверка на расширение файла
                    if (in_array($testMimeType, $acTypesFileForUploading)) {
                        //Проверка, что запись старая
                        if ($request->post('document')[$file][0] != '0') {
                            //Поиск записи и её перезапись
                            $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                            if (!empty($saveintable)) {
                                $s3 = new S3Client([
                                    'version' => 'latest',
                                    'region' => 'msk',
                                    'use_path_style_endpoint' => true,
                                    'credentials' => [
                                        'key' => $key,
                                        'secret' => $secret,
                                    ],
                                    'endpoint' => $endpoint,
                                ]);
                                $position = $saveintable['position'];
                                $s3->putObject([
                                    'Bucket' => $bucket,
                                    'Key' => $position,
                                    'Body' => file_get_contents($_FILES['document']['tmp_name'][$file]),
                                    'ContentDisposition' => '"inline"',
                                    'ContentType' => $testMimeType
                                ]);
                                $s3->listBuckets();
                                $command = $s3->getCommand('GetObject', [
                                    'Bucket' => $bucket,
                                    'Key' => $position
                                ]);
                                $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                                $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                                $lastdotposition = strpos($presignedUrl, "?");
                                if ($lastdotposition !== false) {
                                    $link = substr($presignedUrl, 0, $lastdotposition);
                                }
                                $saveintable->titel = $request->post('document')[$file][2];
                                $saveintable->data = $link;
                                $saveintable->updated_at = new \yii\db\Expression('NOW()');
                                if ($saveintable->validate()) {
                                    $saveintable->save();
                                } else {
                                    $p = 1;
                                }
                            }
                        } else {
                            //Новая запись в бд
                            $s3 = new S3Client([
                                'version' => 'latest',
                                'region' => 'msk',
                                'use_path_style_endpoint' => true,
                                'credentials' => [
                                    'key' => $key,
                                    'secret' => $secret,
                                ],
                                'endpoint' => $endpoint,
                            ]);
                            $tabel_filds = Fieldsforms::findOne($request->post('document')[$file][1]);
                            $count_upload_doc = $tabel_filds->count_upload_doc + 1;
                            $position = $tabel_filds->fieldform . $count_upload_doc;
                            $testMimeType = FileHelper::getMimeTypeByExtension($name);
                            $s3->putObject([
                                'Bucket' => $bucket,
                                'Key' => $position,
                                'Body' => file_get_contents($_FILES['document']['tmp_name'][$file]),
                                'ContentDisposition' => '"inline"',
                                'ContentType' => $testMimeType
                            ]);
                            $s3->listBuckets();
                            $command = $s3->getCommand('GetObject', [
                                'Bucket' => $bucket,
                                'Key' => $position
                            ]);
                            $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                            $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                            $lastdotposition = strpos($presignedUrl, "?");
                            if ($lastdotposition !== false) {
                                $link = substr($presignedUrl, 0, $lastdotposition);
                            }
                            $saveintable = new Dataforms();
                            $saveintable->titel = $request->post('document')[$file][2];
                            $saveintable->fieldsforms_id = $request->post('document')[$file][1];
                            $saveintable->data = $link;
                            $saveintable->position = $position;
                            if ($saveintable->validate()) {
                                $tabel_filds->count_upload_doc = $count_upload_doc;
                                $tabel_filds->save();
                                $saveintable->save();
                            } else {
                                $p = 1;
                            }
                        }
                    } else {
                        $p = 1;
                    }
                } else {
                    //Запись в бд при отсутствии файла
                    //Проверка,что запись старая
                    if ($request->post('document')[$file][0] != '0') {
                        $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                        //Поиск записи и её перезапись
                        if (!empty($saveintable) && $saveintable['titel'] != $request->post('document')[$file][2]) {
                            $saveintable->titel = $request->post('document')[$file][2];
                            $saveintable->updated_at = new \yii\db\Expression('NOW()');
                            if ($saveintable->validate()) {
                                $saveintable->save();
                            } else {
                                $p = 1;
                            }
                        }
                    } else {
                        //Запись новых данных
                        $tabel_filds = Fieldsforms::findOne($request->post('document')[$file][1]);
                        $count_upload_doc = $tabel_filds->count_upload_doc + 1;
                        $position = $tabel_filds->fieldform . $count_upload_doc;
                        $saveintable = new Dataforms();
                        $saveintable->titel = $request->post('document')[$file][2];
                        $saveintable->fieldsforms_id = $request->post('document')[$file][1];
                        $saveintable->position = $position;
                        if ($saveintable->validate()) {
                            $tabel_filds->count_upload_doc = $count_upload_doc;
                            $tabel_filds->save();
                            $saveintable->save();
                        } else {
                            $p = 1;
                        }
                    }
                }
                //Проверка была ли допущена,где-то ошибка при добавлении данных
                if ($p == 1) {
                    //Проверка, что  запись старая
                    if ($request->post('document')[$file][0] != '0') {
                        $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                        $wrong[] = [
                            'titel' => $request->post('document')[$file][2],
                            'fieldsforms_id' => $request->post('document')[$file][1],
                            'position' => $request->post('document')[$file][0],
                            'data' => $saveintable->data
                        ];
                    } else {
                        $wrong[] = [
                            'titel' => $request->post('document')[$file][2],
                            'fieldsforms_id' => $request->post('document')[$file][1],
                            'position' => '0',
                            'data' => ''
                        ];
                    }
                    //Создание в сесси переменной wrong_data, куда передается массив wrong с ошибками
                    Yii::$app->session->set('wrong_data', $wrong);
                    Yii::$app->session->setFlash('error', 'Проверьте правильность введенных данных.');
                }
            }
            return $this->redirect('');
        }
        $filteredMenuItems = self::getFilteredMenuItems();
        return $this->render('paid_edu', ['tabledata' => $data, 'menuItems' => $filteredMenuItems]);
    }
    public function actionDocument()
    {
        $takedata = new Dataforms();
        $request = Yii::$app->request;
        $key = $this->module->params['key'];
        $secret = $this->module->params['secret'];
        $endpoint = $this->module->params['endpoint'];
        $bucket = $this->module->params['Bucket'];
        //массив с разрешенными расширениями файлов
        $acTypesFileForUploading = array(
            "image/jpeg",//jpg or jpeg
            "image/png",//png
            "application/pdf",//pdf
            "application/msword",//doc (not docx)
            "application/vnd.ms-excel",//xls (not xlsx)
            "text/csv",//csv
            //"application/vnd.openxmlformats-officedocument.wordprocessingml.document",//docx
            //"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",//xlsx
            //"application/vnd.ms-powerpoint",//ppt
            //"application/vnd.openxmlformats-officedocument.presentationml.presentation",//pptx
        );
        if (isset($_FILES['document']) && $request->post('document')) {
            foreach ($_FILES['document']['name'] as $file => $name) {
                $link = '';
                $p = 0;
                $position = '';
                //Проверка на наличие файла
                if ($name != '') {
                    $testMimeType = FileHelper::getMimeTypeByExtension($name);
                    //Проверка на расширение файла
                    if (in_array($testMimeType, $acTypesFileForUploading)) {
                        //Проверка, что запись старая
                        if ($request->post('document')[$file][0] != '0') {
                            //Поиск записи и её перезапись
                            $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                            if (!empty($saveintable)) {
                                $s3 = new S3Client([
                                    'version' => 'latest',
                                    'region' => 'msk',
                                    'use_path_style_endpoint' => true,
                                    'credentials' => [
                                        'key' => $key,
                                        'secret' => $secret,
                                    ],
                                    'endpoint' => $endpoint,
                                ]);
                                $position = $saveintable['position'];
                                $s3->putObject([
                                    'Bucket' => $bucket,
                                    'Key' => $position,
                                    'Body' => file_get_contents($_FILES['document']['tmp_name'][$file]),
                                    'ContentDisposition' => '"inline"',
                                    'ContentType' => $testMimeType
                                ]);
                                $s3->listBuckets();
                                $command = $s3->getCommand('GetObject', [
                                    'Bucket' => $bucket,
                                    'Key' => $position
                                ]);
                                $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                                $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                                $lastdotposition = strpos($presignedUrl, "?");
                                if ($lastdotposition !== false) {
                                    $link = substr($presignedUrl, 0, $lastdotposition);
                                }
                                $saveintable->titel = $request->post('document')[$file][2];
                                $saveintable->data = $link;
                                $saveintable->updated_at = new \yii\db\Expression('NOW()');
                                if ($saveintable->validate()) {
                                    $saveintable->save();
                                } else {
                                    $p = 1;
                                }
                            }
                        } else {
                            //Новая запись в бд
                            $s3 = new S3Client([
                                'version' => 'latest',
                                'region' => 'msk',
                                'use_path_style_endpoint' => true,
                                'credentials' => [
                                    'key' => $key,
                                    'secret' => $secret,
                                ],
                                'endpoint' => $endpoint,
                            ]);
                            $tabel_filds = Fieldsforms::findOne($request->post('document')[$file][1]);
                            $count_upload_doc = $tabel_filds->count_upload_doc + 1;
                            $position = $tabel_filds->fieldform . $count_upload_doc;
                            $testMimeType = FileHelper::getMimeTypeByExtension($name);
                            $s3->putObject([
                                'Bucket' => $bucket,
                                'Key' => $position,
                                'Body' => file_get_contents($_FILES['document']['tmp_name'][$file]),
                                'ContentDisposition' => '"inline"',
                                'ContentType' => $testMimeType
                            ]);
                            $s3->listBuckets();
                            $command = $s3->getCommand('GetObject', [
                                'Bucket' => $bucket,
                                'Key' => $position
                            ]);
                            $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                            $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                            $lastdotposition = strpos($presignedUrl, "?");
                            if ($lastdotposition !== false) {
                                $link = substr($presignedUrl, 0, $lastdotposition);
                            }
                            $saveintable = new Dataforms();
                            $saveintable->titel = $request->post('document')[$file][2];
                            $saveintable->fieldsforms_id = $request->post('document')[$file][1];
                            $saveintable->data = $link;
                            $saveintable->position = $position;
                            if ($saveintable->validate()) {
                                $tabel_filds->count_upload_doc = $count_upload_doc;
                                $tabel_filds->save();
                                $saveintable->save();
                            } else {
                                $p = 1;
                            }
                        }
                    } else {
                        $p = 1;
                    }
                } else {
                    //Запись в бд при отсутствии файла
                    //Проверка,что запись старая
                    if ($request->post('document')[$file][0] != '0') {
                        $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                        //Поиск записи и её перезапись
                        if (!empty($saveintable) && $saveintable['titel'] != $request->post('document')[$file][2]) {
                            $saveintable->titel = $request->post('document')[$file][2];
                            $saveintable->updated_at = new \yii\db\Expression('NOW()');
                            if ($saveintable->validate()) {
                                $saveintable->save();
                            } else {
                                $p = 1;
                            }
                        }
                    } else {
                        //Запись новых данных
                        $tabel_filds = Fieldsforms::findOne($request->post('document')[$file][1]);
                        $count_upload_doc = $tabel_filds->count_upload_doc + 1;
                        $position = $tabel_filds->fieldform . $count_upload_doc;
                        $saveintable = new Dataforms();
                        $saveintable->titel = $request->post('document')[$file][2];
                        $saveintable->fieldsforms_id = $request->post('document')[$file][1];
                        $saveintable->position = $position;
                        if ($saveintable->validate()) {
                            $tabel_filds->count_upload_doc = $count_upload_doc;
                            $tabel_filds->save();
                            $saveintable->save();
                        } else {
                            $p = 1;
                        }
                    }
                }
                //Проверка была ли допущена,где-то ошибка при добавлении данных
                if ($p == 1) {
                    //Проверка, что  запись старая
                    if ($request->post('document')[$file][0] != '0') {
                        $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                        $wrong[] = [
                            'titel' => $request->post('document')[$file][2],
                            'fieldsforms_id' => $request->post('document')[$file][1],
                            'position' => $request->post('document')[$file][0],
                            'data' => $saveintable->data
                        ];
                    } else {
                        $wrong[] = [
                            'titel' => $request->post('document')[$file][2],
                            'fieldsforms_id' => $request->post('document')[$file][1],
                            'position' => '0',
                            'data' => ''
                        ];
                    }
                    //Создание в сесси переменной wrong_data, куда передается массив wrong с ошибками
                    Yii::$app->session->set('wrong_data', $wrong);
                    Yii::$app->session->setFlash('error', 'Проверьте правильность введенных данных.');
                }
            }
            return $this->redirect('document');
        }
        $savefilestable = $takedata::find()
            ->joinWith('fieldsforms')
            ->andWhere(['fieldsforms.nameform' => 'document'])
            ->all();
        $position_wrong[] = '';
        if (Yii::$app->session->has('wrong_data')) {
            $position_wrong[] = '0';
            $wrong_data = Yii::$app->session->get('wrong_data');
            //Если переменная wrong_data есть, сравнимаем полученные данные из таблицы 
            //и либо заменяем их, либо добавляем новые в массив data
            foreach ($wrong_data as $wr) {
                if ($wr["position"] != '0') {
                    foreach ($savefilestable as $tabledata) {
                        if ($wr["position"] == $tabledata["position"]) {
                            $tabledata["titel"] = $wr["titel"];
                            $position_wrong[] = $wr["position"];
                            break;
                        }
                    }
                } else {
                    $savefilestable[] = $wr;
                }
            }
            Yii::$app->session->remove('wrong_data');
        }
        $filteredMenuItems = self::getFilteredMenuItems();
        return $this->render('document', ['tabledata' => $savefilestable, 'position_wrong' => $position_wrong, 'menuItems' => $filteredMenuItems]);
    }
    public function actionCommon()
    {
        $takedata = new Dataforms();
        $datarows = $takedata::find()
            ->joinWith('fieldsforms')
            ->andWhere(['and', ['fieldsforms.nameform' => 'common'], ['position' => Null]])
            ->joinWith('extraFields')
            ->all();
        $datadoc = $takedata::find()
            ->joinWith('fieldsforms')
            ->andWhere(['and', ['fieldsforms.nameform' => 'common']])->andWhere(['not', ['position' => null]])
            ->all();
        $request = Yii::$app->request;
        if ($request->post()) {
            if ($request->post('common')) {
                if ($request->post('common')[0][0][0] != 0) {
                    $change_true = false;
                    $dataforms = new Dataforms();
                    $dataforms = $dataforms::findOne($request->post('common')[0][0][0]);
                    if ($request->post('common')[0][0][2] != $dataforms->titel or $request->post('common')[0][0][3] != $dataforms->data) {
                        $dataforms->titel = $request->post('common')[0][0][2];
                        $dataforms->data = $request->post('common')[0][0][3];
                        $dataforms->save();
                        $change_true = true;
                    }
                    $income_true = false;
                    $expenditure_true = false;
                    $website_true = false;
                    if (!empty($request->post('common')[0][1][0]) or !empty($request->post('common')[0][2][0]) or !empty($request->post('common')[0][3][0])) {
                        $extraFields = new ExtraFields();
                        $extraFields = $extraFields::find()->where(['dataforms_id' => $request->post('common')[0][0][0]])->all();
                        if (!empty($extraFields)) {
                            foreach ($extraFields as $extraField) {
                                switch ($extraField["type"]) {
                                    case "phone":
                                        if ($extraField["data"] != $request->post('common')[0][1][0]) {
                                            $chagedata = ExtraFields::findOne($extraField["id"]);
                                            $chagedata->data = $request->post('common')[0][1][0];
                                            $chagedata->save();
                                        }
                                        $change_true = true;
                                        $income_true = true;
                                        break;
                                    case "email":
                                        if ($extraField["data"] != $request->post('common')[0][2][0]) {
                                            $chagedata = ExtraFields::findOne($extraField["id"]);
                                            $chagedata->data = $request->post('common')[0][2][0];
                                            $chagedata->save();
                                        }
                                        $change_true = true;
                                        $expenditure_true = true;
                                        break;
                                    case "website":
                                        if ($extraField["data"] != $request->post('common')[0][3][0]) {
                                            $chagedata = ExtraFields::findOne($extraField["id"]);
                                            $chagedata->data = $request->post('common')[0][3][0];
                                            $chagedata->save();
                                        }
                                        $change_true = true;
                                        $website_true = true;
                                        break;
                                }
                            }
                            if (!empty($request->post('common')[0][1][0]) && !$income_true) {
                                $extraFields = new ExtraFields();
                                $extraFields->type = 'phone';
                                $extraFields->data = $request->post('common')[0][1][0];
                                $extraFields->dataforms_id = $request->post('common')[0][0][0];
                                $extraFields->fieldsforms_id = 24;
                                $extraFields->save();
                                $change_true = true;
                            }
                            if (!empty($request->post('common')[0][2][0]) && !$expenditure_true) {
                                $extraFields = new ExtraFields();
                                $extraFields->type = 'email';
                                $extraFields->data = $request->post('common')[0][2][0];
                                $extraFields->dataforms_id = $request->post('common')[0][0][0];
                                $extraFields->fieldsforms_id = 24;
                                $extraFields->save();
                                $change_true = true;
                            }
                            if (!empty($request->post('common')[0][3][0]) && !$website_true) {
                                $extraFields = new ExtraFields();
                                $extraFields->type = 'website';
                                $extraFields->data = $request->post('common')[0][3][0];
                                $extraFields->dataforms_id = $request->post('common')[0][0][0];
                                $extraFields->fieldsforms_id = 24;
                                $extraFields->save();
                                $change_true = true;
                            }
                        } else {
                            if (!empty($request->post('common')[0][1][0])) {
                                $extraFields = new ExtraFields();
                                $extraFields->type = 'phone';
                                $extraFields->data = $request->post('common')[0][1][0];
                                $extraFields->dataforms_id = $request->post('common')[0][0][0];
                                $extraFields->fieldsforms_id = 24;
                                $extraFields->save();
                                $change_true = true;
                            }
                            if (!empty($request->post('common')[0][2][0])) {
                                $extraFields = new ExtraFields();
                                $extraFields->type = 'email';
                                $extraFields->data = $request->post('common')[0][2][0];
                                $extraFields->dataforms_id = $request->post('common')[0][0][0];
                                $extraFields->fieldsforms_id = 24;
                                $extraFields->save();
                                $change_true = true;
                            }
                            if (!empty($request->post('common')[0][3][0])) {
                                $extraFields = new ExtraFields();
                                $extraFields->type = 'website';
                                $extraFields->data = $request->post('common')[0][3][0];
                                $extraFields->dataforms_id = $request->post('common')[0][0][0];
                                $extraFields->fieldsforms_id = 24;
                                $extraFields->save();
                                $change_true = true;
                            }
                        }
                    }
                    if ($change_true) {
                        $dataforms = Dataforms::findOne($request->post('common')[0][0][0]);
                        $dataforms->updated_at = new \yii\db\Expression('NOW()');
                        $dataforms->save();
                    }
                } else {
                    $dataforms = new Dataforms();
                    $dataforms->fieldsforms_id = 24;
                    $dataforms->titel = $request->post('common')[0][0][2];
                    $dataforms->data = $request->post('common')[0][0][3];
                    $dataforms->save();
                    $idDataformsforExtraFields = Yii::$app->db->getLastInsertID();
                    if (!empty($request->post('common')[0][1][0])) {
                        $extraFields = new ExtraFields();
                        $extraFields->type = 'phone';
                        $extraFields->data = $request->post('common')[0][1][0];
                        $extraFields->dataforms_id = $idDataformsforExtraFields;
                        $extraFields->fieldsforms_id = 24;
                        $extraFields->save();
                    }
                    if (!empty($request->post('common')[0][2][0])) {
                        $extraFields = new ExtraFields();
                        $extraFields->type = 'email';
                        $extraFields->data = $request->post('common')[0][2][0];
                        $extraFields->dataforms_id = $idDataformsforExtraFields;
                        $extraFields->fieldsforms_id = 24;
                        $extraFields->save();
                    }
                    if (!empty($request->post('common')[0][3][0])) {
                        $extraFields = new ExtraFields();
                        $extraFields->type = 'website';
                        $extraFields->data = $request->post('common')[0][3][0];
                        $extraFields->dataforms_id = $idDataformsforExtraFields;
                        $extraFields->fieldsforms_id = 24;
                        $extraFields->save();
                    }

                }

            }
            $request = Yii::$app->request;
            $key = $this->module->params['key'];
            $secret = $this->module->params['secret'];
            $endpoint = $this->module->params['endpoint'];
            $bucket = $this->module->params['Bucket'];
            //массив с разрешенными расширениями файлов
            $acTypesFileForUploading = array(
                "image/jpeg",//jpg or jpeg
                "image/png",//png
                "application/pdf",//pdf
                "application/msword",//doc (not docx)
                "application/vnd.ms-excel",//xls (not xlsx)
                "text/csv",//csv
                //"application/vnd.openxmlformats-officedocument.wordprocessingml.document",//docx
                //"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",//xlsx
                //"application/vnd.ms-powerpoint",//ppt
                //"application/vnd.openxmlformats-officedocument.presentationml.presentation",//pptx
            );
            if (isset($_FILES['document']) && $request->post('document')) {
                foreach ($_FILES['document']['name'] as $file => $name) {
                    $link = '';
                    $p = 0;
                    $position = '';
                    //Проверка на наличие файла
                    if ($name != '') {
                        $testMimeType = FileHelper::getMimeTypeByExtension($name);
                        //Проверка на расширение файла
                        if (in_array($testMimeType, $acTypesFileForUploading)) {
                            //Проверка, что запись старая
                            if ($request->post('document')[$file][0] != '0') {
                                //Поиск записи и её перезапись
                                $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                                if (!empty($saveintable)) {
                                    $s3 = new S3Client([
                                        'version' => 'latest',
                                        'region' => 'msk',
                                        'use_path_style_endpoint' => true,
                                        'credentials' => [
                                            'key' => $key,
                                            'secret' => $secret,
                                        ],
                                        'endpoint' => $endpoint,
                                    ]);
                                    $position = $saveintable['position'];
                                    $s3->putObject([
                                        'Bucket' => $bucket,
                                        'Key' => $position,
                                        'Body' => file_get_contents($_FILES['document']['tmp_name'][$file]),
                                        'ContentDisposition' => '"inline"',
                                        'ContentType' => $testMimeType
                                    ]);
                                    $s3->listBuckets();
                                    $command = $s3->getCommand('GetObject', [
                                        'Bucket' => $bucket,
                                        'Key' => $position
                                    ]);
                                    $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                                    $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                                    $lastdotposition = strpos($presignedUrl, "?");
                                    if ($lastdotposition !== false) {
                                        $link = substr($presignedUrl, 0, $lastdotposition);
                                    }
                                    $saveintable->titel = $request->post('document')[$file][2];
                                    $saveintable->data = $link;
                                    $saveintable->updated_at = new \yii\db\Expression('NOW()');
                                    if ($saveintable->validate()) {
                                        $saveintable->save();
                                    } else {
                                        $p = 1;
                                    }
                                }
                            } else {
                                //Новая запись в бд
                                $s3 = new S3Client([
                                    'version' => 'latest',
                                    'region' => 'msk',
                                    'use_path_style_endpoint' => true,
                                    'credentials' => [
                                        'key' => $key,
                                        'secret' => $secret,
                                    ],
                                    'endpoint' => $endpoint,
                                ]);
                                $tabel_filds = Fieldsforms::findOne($request->post('document')[$file][1]);
                                $count_upload_doc = $tabel_filds->count_upload_doc + 1;
                                $position = $tabel_filds->fieldform . $count_upload_doc;
                                $testMimeType = FileHelper::getMimeTypeByExtension($name);
                                $s3->putObject([
                                    'Bucket' => $bucket,
                                    'Key' => $position,
                                    'Body' => file_get_contents($_FILES['document']['tmp_name'][$file]),
                                    'ContentDisposition' => '"inline"',
                                    'ContentType' => $testMimeType
                                ]);
                                $s3->listBuckets();
                                $command = $s3->getCommand('GetObject', [
                                    'Bucket' => $bucket,
                                    'Key' => $position
                                ]);
                                $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                                $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                                $lastdotposition = strpos($presignedUrl, "?");
                                if ($lastdotposition !== false) {
                                    $link = substr($presignedUrl, 0, $lastdotposition);
                                }
                                $saveintable = new Dataforms();
                                $saveintable->titel = $request->post('document')[$file][2];
                                $saveintable->fieldsforms_id = $request->post('document')[$file][1];
                                $saveintable->data = $link;
                                $saveintable->position = $position;
                                if ($saveintable->validate()) {
                                    $tabel_filds->count_upload_doc = $count_upload_doc;
                                    $tabel_filds->save();
                                    $saveintable->save();
                                } else {
                                    $p = 1;
                                }
                            }
                        } else {
                            $p = 1;
                        }
                    } else {
                        //Запись в бд при отсутствии файла
                        //Проверка,что запись старая
                        if ($request->post('document')[$file][0] != '0') {
                            $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                            //Поиск записи и её перезапись
                            if (!empty($saveintable) && $saveintable['titel'] != $request->post('document')[$file][2]) {
                                $saveintable->titel = $request->post('document')[$file][2];
                                $saveintable->updated_at = new \yii\db\Expression('NOW()');
                                if ($saveintable->validate()) {
                                    $saveintable->save();
                                } else {
                                    $p = 1;
                                }
                            }
                        } else {
                            //Запись новых данных
                            $tabel_filds = Fieldsforms::findOne($request->post('document')[$file][1]);
                            $count_upload_doc = $tabel_filds->count_upload_doc + 1;
                            $position = $tabel_filds->fieldform . $count_upload_doc;
                            $saveintable = new Dataforms();
                            $saveintable->titel = $request->post('document')[$file][2];
                            $saveintable->fieldsforms_id = $request->post('document')[$file][1];
                            $saveintable->position = $position;
                            if ($saveintable->validate()) {
                                $tabel_filds->count_upload_doc = $count_upload_doc;
                                $tabel_filds->save();
                                $saveintable->save();
                            } else {
                                $p = 1;
                            }
                        }
                    }
                    //Проверка была ли допущена,где-то ошибка при добавлении данных
                    if ($p == 1) {
                        //Проверка, что  запись старая
                        if ($request->post('document')[$file][0] != '0') {
                            $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                            $wrong[] = [
                                'titel' => $request->post('document')[$file][2],
                                'fieldsforms_id' => $request->post('document')[$file][1],
                                'position' => $request->post('document')[$file][0],
                                'data' => $saveintable->data
                            ];
                        } else {
                            $wrong[] = [
                                'titel' => $request->post('document')[$file][2],
                                'fieldsforms_id' => $request->post('document')[$file][1],
                                'position' => '0',
                                'data' => ''
                            ];
                        }
                        //Создание в сесси переменной wrong_data, куда передается массив wrong с ошибками
                        Yii::$app->session->set('wrong_data', $wrong);
                        Yii::$app->session->setFlash('error', 'Проверьте правильность введенных данных.');
                    }
                }
            }
            return $this->redirect('common');
        }
        $filteredMenuItems = self::getFilteredMenuItems();
        return $this->render('common', ['datarows' => $datarows, 'tabledata' => $datadoc, 'menuItems' => $filteredMenuItems]);
    }
    public function actionEdustandarts()
    {
        #var_dump('test');
        #die();
        // $takedata = new Dataforms();
        // $data = $takedata::find()
        //     ->joinWith('extraFields')
        //     ->joinWith('fieldsforms')
        //     ->all();
        // echo "<pre>";
        // var_dump($data);
        // echo "</pre>";
        // die();
        $takedata = new Dataforms();
        $data = $takedata::find()
            ->joinWith('fieldsforms')
            ->andWhere(['fieldsforms.nameform' => 'edustandarts'])
            ->all();
        $request = Yii::$app->request;
        $key = $this->module->params['key'];
        $secret = $this->module->params['secret'];
        $endpoint = $this->module->params['endpoint'];
        $bucket = $this->module->params['Bucket'];
        //массив с разрешенными расширениями файлов
        $acTypesFileForUploading = array(
            "image/jpeg",//jpg or jpeg
            "image/png",//png
            "application/pdf",//pdf
            "application/msword",//doc (not docx)
            "application/vnd.ms-excel",//xls (not xlsx)
            "text/csv",//csv
            //"application/vnd.openxmlformats-officedocument.wordprocessingml.document",//docx
            //"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",//xlsx
            //"application/vnd.ms-powerpoint",//ppt
            //"application/vnd.openxmlformats-officedocument.presentationml.presentation",//pptx
        );
        if (isset($_FILES['document']) && $request->post('document')) {
            foreach ($_FILES['document']['name'] as $file => $name) {
                $link = '';
                $p = 0;
                $position = '';
                //Проверка на наличие файла
                if ($name != '') {
                    $testMimeType = FileHelper::getMimeTypeByExtension($name);
                    //Проверка на расширение файла
                    if (in_array($testMimeType, $acTypesFileForUploading)) {
                        //Проверка, что запись старая
                        if ($request->post('document')[$file][0] != '0') {
                            //Поиск записи и её перезапись
                            $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                            if (!empty($saveintable)) {
                                $s3 = new S3Client([
                                    'version' => 'latest',
                                    'region' => 'msk',
                                    'use_path_style_endpoint' => true,
                                    'credentials' => [
                                        'key' => $key,
                                        'secret' => $secret,
                                    ],
                                    'endpoint' => $endpoint,
                                ]);
                                $position = $saveintable['position'];
                                $s3->putObject([
                                    'Bucket' => $bucket,
                                    'Key' => $position,
                                    'Body' => file_get_contents($_FILES['document']['tmp_name'][$file]),
                                    'ContentDisposition' => '"inline"',
                                    'ContentType' => $testMimeType
                                ]);
                                $s3->listBuckets();
                                $command = $s3->getCommand('GetObject', [
                                    'Bucket' => $bucket,
                                    'Key' => $position
                                ]);
                                $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                                $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                                $lastdotposition = strpos($presignedUrl, "?");
                                if ($lastdotposition !== false) {
                                    $link = substr($presignedUrl, 0, $lastdotposition);
                                }
                                $saveintable->titel = $request->post('document')[$file][2];
                                $saveintable->data = $link;
                                $saveintable->updated_at = new \yii\db\Expression('NOW()');
                                if ($saveintable->validate()) {
                                    $saveintable->save();
                                } else {
                                    $p = 1;
                                }
                            }
                        } else {
                            //Новая запись в бд
                            $s3 = new S3Client([
                                'version' => 'latest',
                                'region' => 'msk',
                                'use_path_style_endpoint' => true,
                                'credentials' => [
                                    'key' => $key,
                                    'secret' => $secret,
                                ],
                                'endpoint' => $endpoint,
                            ]);
                            $tabel_filds = Fieldsforms::findOne($request->post('document')[$file][1]);
                            $count_upload_doc = $tabel_filds->count_upload_doc + 1;
                            $position = $tabel_filds->fieldform . $count_upload_doc;
                            $testMimeType = FileHelper::getMimeTypeByExtension($name);
                            $s3->putObject([
                                'Bucket' => $bucket,
                                'Key' => $position,
                                'Body' => file_get_contents($_FILES['document']['tmp_name'][$file]),
                                'ContentDisposition' => '"inline"',
                                'ContentType' => $testMimeType
                            ]);
                            $s3->listBuckets();
                            $command = $s3->getCommand('GetObject', [
                                'Bucket' => $bucket,
                                'Key' => $position
                            ]);
                            $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                            $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                            $lastdotposition = strpos($presignedUrl, "?");
                            if ($lastdotposition !== false) {
                                $link = substr($presignedUrl, 0, $lastdotposition);
                            }
                            $saveintable = new Dataforms();
                            $saveintable->titel = $request->post('document')[$file][2];
                            $saveintable->fieldsforms_id = $request->post('document')[$file][1];
                            $saveintable->data = $link;
                            $saveintable->position = $position;
                            if ($saveintable->validate()) {
                                $tabel_filds->count_upload_doc = $count_upload_doc;
                                $tabel_filds->save();
                                $saveintable->save();
                            } else {
                                $p = 1;
                            }
                        }
                    } else {
                        $p = 1;
                    }
                } else {
                    //Запись в бд при отсутствии файла
                    //Проверка,что запись старая
                    if ($request->post('document')[$file][0] != '0') {
                        $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                        //Поиск записи и её перезапись
                        if (!empty($saveintable) && $saveintable['titel'] != $request->post('document')[$file][2]) {
                            $saveintable->titel = $request->post('document')[$file][2];
                            $saveintable->updated_at = new \yii\db\Expression('NOW()');
                            if ($saveintable->validate()) {
                                $saveintable->save();
                            } else {
                                $p = 1;
                            }
                        }
                    } else {
                        //Запись новых данных
                        $tabel_filds = Fieldsforms::findOne($request->post('document')[$file][1]);
                        $count_upload_doc = $tabel_filds->count_upload_doc + 1;
                        $position = $tabel_filds->fieldform . $count_upload_doc;
                        $saveintable = new Dataforms();
                        $saveintable->titel = $request->post('document')[$file][2];
                        $saveintable->fieldsforms_id = $request->post('document')[$file][1];
                        $saveintable->position = $position;
                        if ($saveintable->validate()) {
                            $tabel_filds->count_upload_doc = $count_upload_doc;
                            $tabel_filds->save();
                            $saveintable->save();
                        } else {
                            $p = 1;
                        }
                    }
                }
                //Проверка была ли допущена,где-то ошибка при добавлении данных
                if ($p == 1) {
                    //Проверка, что  запись старая
                    if ($request->post('document')[$file][0] != '0') {
                        $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                        $wrong[] = [
                            'titel' => $request->post('document')[$file][2],
                            'fieldsforms_id' => $request->post('document')[$file][1],
                            'position' => $request->post('document')[$file][0],
                            'data' => $saveintable->data
                        ];
                    } else {
                        $wrong[] = [
                            'titel' => $request->post('document')[$file][2],
                            'fieldsforms_id' => $request->post('document')[$file][1],
                            'position' => '0',
                            'data' => ''
                        ];
                    }
                    //Создание в сесси переменной wrong_data, куда передается массив wrong с ошибками
                    Yii::$app->session->set('wrong_data', $wrong);
                    Yii::$app->session->setFlash('error', 'Проверьте правильность введенных данных.');
                }
            }
            return $this->redirect('');
        }
        $filteredMenuItems = self::getFilteredMenuItems();
        return $this->render('eduStandarts', ['tabledata' => $data, 'menuItems' => $filteredMenuItems,]);
    }
    public function actionInter()
    {
        $request = Yii::$app->request;
        $tabledata = new Dataforms();
        if ($request->post("inter")) {
            foreach ($request->post("inter") as $inter) {
                if ($inter[0][0] != 0) {
                    $data = $tabledata::findOne($inter[0][0]);
                    if ($inter[0][2] != $data["titel"] or $inter[0][3] != $data["data"]) {
                        $data->titel = $inter[0][2];
                        $data->data = $inter[0][3];
                        $data->updated_at = new \yii\db\Expression('NOW()');
                        $data->save();
                    }
                    if (!empty($inter[1])) {
                        foreach ($inter[1] as $number => $inter_dop) {
                            $extrafields = new ExtraFields();
                            $dop = $extrafields::find()->where(["dataforms_id" => $inter[0][0]])->all();
                            if (!empty($dop)) {
                                if (!empty($dop[$number]["data"])) {
                                    if ($dop[$number]["data"] != $inter_dop) {
                                        $change = $extrafields::findOne($dop[$number]["id"]);
                                        $change->data = $inter_dop;
                                        $change->save();
                                        $change = Dataforms::findOne($inter[0][0]);
                                        $change->updated_at = new \yii\db\Expression('NOW()');
                                    }
                                } else {
                                    $extrafields = new ExtraFields();
                                    $extrafields->dataforms_id = $inter[0][0];
                                    $extrafields->type = "document";
                                    $extrafields->data = $inter_dop;
                                    $extrafields->save();
                                    $change = Dataforms::findOne($inter[0][0]);
                                    $change->updated_at = new \yii\db\Expression('NOW()');
                                }
                            } else {
                                $extrafields = new ExtraFields();
                                $extrafields->dataforms_id = $inter[0][0];
                                $extrafields->type = "document";
                                $extrafields->data = $inter_dop;
                                $extrafields->save();
                                $change = Dataforms::findOne($inter[0][0]);
                                $change->updated_at = new \yii\db\Expression('NOW()');
                            }
                        }
                    }
                } else {
                    $dataforms = new Dataforms();
                    $dataforms->fieldsforms_id = $inter[0][1];
                    $dataforms->titel = $inter[0][2];
                    $dataforms->data = $inter[0][3];
                    $dataforms->save();
                    if (!empty($inter[1])) {
                        $idDataformsforExtraFields = Yii::$app->db->getLastInsertID();
                        foreach ($inter[1] as $inter_dop) {
                            $extrafields = new ExtraFields();
                            $extrafields->dataforms_id = $idDataformsforExtraFields;
                            $extrafields->type = "document";
                            $extrafields->data = $inter_dop;
                            $extrafields->save();
                        }
                    }
                }
            }
            return $this->redirect('');
        }
        $data = $tabledata::find()
            ->joinWith('fieldsforms')
            ->andWhere(['fieldsforms.nameform' => 'inter'])
            ->joinWith('extraFields')
            ->all();

        $filteredMenuItems = self::getFilteredMenuItems();
        return $this->render('inter', ["data" => $data, 'menuItems' => $filteredMenuItems,]);
    }
    public function actionGrants()
    {
        $request = Yii::$app->request;
        $key = $this->module->params['key'];
        $secret = $this->module->params['secret'];
        $endpoint = $this->module->params['endpoint'];
        $bucket = $this->module->params['Bucket'];
        //массив с разрешенными расширениями файлов
        $acTypesFileForUploading = array(
            "image/jpeg",//jpg or jpeg
            "image/png",//png
            "application/pdf",//pdf
            "application/msword",//doc (not docx)
            "application/vnd.ms-excel",//xls (not xlsx)
            "text/csv",//csv
            //"application/vnd.openxmlformats-officedocument.wordprocessingml.document",//docx
            //"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",//xlsx
            //"application/vnd.ms-powerpoint",//ppt
            //"application/vnd.openxmlformats-officedocument.presentationml.presentation",//pptx
        );
        if ($request->post()) {
            if ($request->post("grants")) {
                foreach ($request->post("grants") as $grants) {
                    if ($grants[0] != "0") {
                        $saveintable = Dataforms::findOne($grants[0]);
                        if ($grants[3] != $saveintable->data) {
                            $saveintable->data = $grants[3];
                            $saveintable->updated_at = new \yii\db\Expression('NOW()');
                            $saveintable->save();
                        }
                    } else {
                        $saveintable = new Dataforms();
                        $saveintable->fieldsforms_id = $grants[1];
                        $saveintable->titel = $grants[2];
                        $saveintable->data = $grants[3];
                        $saveintable->save();
                    }
                }
            }
            if (isset($_FILES['document']) && $request->post('document')) {
                foreach ($_FILES['document']['name'] as $file => $name) {
                    $link = '';
                    $p = 0;
                    $position = '';
                    //Проверка на наличие файла
                    if ($name != '') {
                        $testMimeType = FileHelper::getMimeTypeByExtension($name);
                        //Проверка на расширение файла
                        if (in_array($testMimeType, $acTypesFileForUploading)) {
                            //Проверка, что запись старая
                            if ($request->post('document')[$file][0] != '0') {
                                //Поиск записи и её перезапись
                                $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                                if (!empty($saveintable)) {
                                    $s3 = new S3Client([
                                        'version' => 'latest',
                                        'region' => 'msk',
                                        'use_path_style_endpoint' => true,
                                        'credentials' => [
                                            'key' => $key,
                                            'secret' => $secret,
                                        ],
                                        'endpoint' => $endpoint,
                                    ]);
                                    $position = $saveintable['position'];
                                    $s3->putObject([
                                        'Bucket' => $bucket,
                                        'Key' => $position,
                                        'Body' => file_get_contents($_FILES['document']['tmp_name'][$file]),
                                        'ContentDisposition' => '"inline"',
                                        'ContentType' => $testMimeType
                                    ]);
                                    $s3->listBuckets();
                                    $command = $s3->getCommand('GetObject', [
                                        'Bucket' => $bucket,
                                        'Key' => $position
                                    ]);
                                    $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                                    $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                                    $lastdotposition = strpos($presignedUrl, "?");
                                    if ($lastdotposition !== false) {
                                        $link = substr($presignedUrl, 0, $lastdotposition);
                                    }
                                    $saveintable->titel = $request->post('document')[$file][2];
                                    $saveintable->data = $link;
                                    $saveintable->updated_at = new \yii\db\Expression('NOW()');
                                    if ($saveintable->validate()) {
                                        $saveintable->save();
                                    } else {
                                        $p = 1;
                                    }
                                }
                            } else {
                                //Новая запись в бд
                                $s3 = new S3Client([
                                    'version' => 'latest',
                                    'region' => 'msk',
                                    'use_path_style_endpoint' => true,
                                    'credentials' => [
                                        'key' => $key,
                                        'secret' => $secret,
                                    ],
                                    'endpoint' => $endpoint,
                                ]);
                                $tabel_filds = Fieldsforms::findOne($request->post('document')[$file][1]);
                                $count_upload_doc = $tabel_filds->count_upload_doc + 1;
                                $position = $tabel_filds->fieldform . $count_upload_doc;
                                $testMimeType = FileHelper::getMimeTypeByExtension($name);
                                $s3->putObject([
                                    'Bucket' => $bucket,
                                    'Key' => $position,
                                    'Body' => file_get_contents($_FILES['document']['tmp_name'][$file]),
                                    'ContentDisposition' => '"inline"',
                                    'ContentType' => $testMimeType
                                ]);
                                $s3->listBuckets();
                                $command = $s3->getCommand('GetObject', [
                                    'Bucket' => $bucket,
                                    'Key' => $position
                                ]);
                                $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                                $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                                $lastdotposition = strpos($presignedUrl, "?");
                                if ($lastdotposition !== false) {
                                    $link = substr($presignedUrl, 0, $lastdotposition);
                                }
                                $saveintable = new Dataforms();
                                $saveintable->titel = $request->post('document')[$file][2];
                                $saveintable->fieldsforms_id = $request->post('document')[$file][1];
                                $saveintable->data = $link;
                                $saveintable->position = $position;
                                if ($saveintable->validate()) {
                                    $tabel_filds->count_upload_doc = $count_upload_doc;
                                    $tabel_filds->save();
                                    $saveintable->save();
                                } else {
                                    $p = 1;
                                }
                            }
                        } else {
                            $p = 1;
                        }
                    } else {
                        //Запись в бд при отсутствии файла
                        //Проверка,что запись старая
                        if ($request->post('document')[$file][0] != '0') {
                            $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                            //Поиск записи и её перезапись
                            if (!empty($saveintable) && $saveintable['titel'] != $request->post('document')[$file][2]) {
                                $saveintable->titel = $request->post('document')[$file][2];
                                $saveintable->updated_at = new \yii\db\Expression('NOW()');
                                if ($saveintable->validate()) {
                                    $saveintable->save();
                                } else {
                                    $p = 1;
                                }
                            }
                        } else {
                            //Запись новых данных
                            $tabel_filds = Fieldsforms::findOne($request->post('document')[$file][1]);
                            $count_upload_doc = $tabel_filds->count_upload_doc + 1;
                            $position = $tabel_filds->fieldform . $count_upload_doc;
                            $saveintable = new Dataforms();
                            $saveintable->titel = $request->post('document')[$file][2];
                            $saveintable->fieldsforms_id = $request->post('document')[$file][1];
                            $saveintable->position = $position;
                            if ($saveintable->validate()) {
                                $tabel_filds->count_upload_doc = $count_upload_doc;
                                $tabel_filds->save();
                                $saveintable->save();
                            } else {
                                $p = 1;
                            }
                        }
                    }
                    //Проверка была ли допущена,где-то ошибка при добавлении данных
                    if ($p == 1) {
                        //Проверка, что  запись старая
                        if ($request->post('document')[$file][0] != '0') {
                            $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                            $wrong[] = [
                                'titel' => $request->post('document')[$file][2],
                                'fieldsforms_id' => $request->post('document')[$file][1],
                                'position' => $request->post('document')[$file][0],
                                'data' => $saveintable->data
                            ];
                        } else {
                            $wrong[] = [
                                'titel' => $request->post('document')[$file][2],
                                'fieldsforms_id' => $request->post('document')[$file][1],
                                'position' => '0',
                                'data' => ''
                            ];
                        }
                        //Создание в сесси переменной wrong_data, куда передается массив wrong с ошибками
                        Yii::$app->session->set('wrong_data', $wrong);
                        Yii::$app->session->setFlash('error', 'Проверьте правильность введенных данных.');
                    }
                }
            }
            return $this->redirect('');
        }
        $singledata = Dataforms::find()
            ->joinWith('fieldsforms')
            ->andWhere(['and', ['fieldsforms.nameform' => 'grants'], ['=', 'fieldsforms.count_upload_doc', 0]])
            ->all();
        $savefilestable = Dataforms::find()
            ->joinWith('fieldsforms')
            ->andWhere(['and', ['fieldsforms.nameform' => 'grants'], ['>', 'fieldsforms.count_upload_doc', 0]])
            ->all();
        $position_wrong[] = '';
        if (Yii::$app->session->has('wrong_data')) {
            $position_wrong[] = '0';
            $wrong_data = Yii::$app->session->get('wrong_data');
            //Если переменная wrong_data есть, сравнимаем полученные данные из таблицы 
            //и либо заменяем их, либо добавляем новые в массив data
            foreach ($wrong_data as $wr) {
                if ($wr["position"] != '0') {
                    foreach ($savefilestable as $tabledata) {
                        if ($wr["position"] == $tabledata["position"]) {
                            $tabledata["titel"] = $wr["titel"];
                            $position_wrong[] = $wr["position"];
                            break;
                        }
                    }
                } else {
                    $savefilestable[] = $wr;
                }
            }
            Yii::$app->session->remove('wrong_data');
        }
        $filteredMenuItems = self::getFilteredMenuItems();
        return $this->render("grants", ['tabledata' => $savefilestable, 'singledata' => $singledata, 'menuItems' => $filteredMenuItems,]);
    }
    public function actionBudget()
    {
        $request = Yii::$app->request;
        $key = $this->module->params['key'];
        $secret = $this->module->params['secret'];
        $endpoint = $this->module->params['endpoint'];
        $bucket = $this->module->params['Bucket'];
        //массив с разрешенными расширениями файлов
        $acTypesFileForUploading = array(
            "image/jpeg",//jpg or jpeg
            "image/png",//png
            "application/pdf",//pdf
            "application/msword",//doc (not docx)
            "application/vnd.ms-excel",//xls (not xlsx)
            "text/csv",//csv
            //"application/vnd.openxmlformats-officedocument.wordprocessingml.document",//docx
            //"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",//xlsx
            //"application/vnd.ms-powerpoint",//ppt
            //"application/vnd.openxmlformats-officedocument.presentationml.presentation",//pptx
        );
        if ($request->post()) {
            if ($request->post("budget")) {
                foreach ($request->post("budget") as $budget) {
                    if ($budget[0] != "0") {
                        $saveintable = Dataforms::findOne($budget[0]);
                        if ($budget[3] != $saveintable->data) {
                            $saveintable->data = $budget[3];
                            $saveintable->updated_at = new \yii\db\Expression('NOW()');
                            $saveintable->save();
                        }
                    } else {
                        $saveintable = new Dataforms();
                        $saveintable->fieldsforms_id = $budget[1];
                        $saveintable->titel = $budget[2];
                        $saveintable->data = $budget[3];
                        $saveintable->save();
                    }
                }
            }
            if ($request->post('report')) {
                foreach ($request->post('report') as $report) {
                    if ($report[0] != 0) {
                        $change_true = false;
                        $dataforms = Dataforms::findOne($report[0]);
                        if ($report[2] != $dataforms->data) {
                            $dataforms->data = $report[2];
                            $dataforms->save();
                            $change_true = true;
                        }
                        if (!empty($report[3]) && !empty($report[4])) {
                            $extraFields = ExtraFields::findOne($report[3]);
                            if (!empty($extraFields)) {
                                if ($extraFields["data"] != $report[4]) {
                                    $chagedata = ExtraFields::findOne($extraFields["id"]);
                                    $chagedata->data = $report[4];
                                    $chagedata->save();
                                    $change_true = true;
                                }
                            }
                        }
                        if (!empty($report[5]) && !empty($report[6])) {
                            $extraFields = ExtraFields::findOne($report[5]);
                            if (!empty($extraFields)) {
                                if ($extraFields["data"] != $report[6]) {
                                    $chagedata = ExtraFields::findOne($extraFields["id"]);
                                    $chagedata->data = $report[6];
                                    $chagedata->save();
                                    $change_true = true;
                                }
                            }
                        }
                        if ($change_true) {
                            $dataforms = Dataforms::findOne($report[0]);
                            $dataforms->updated_at = new \yii\db\Expression('NOW()');
                            $dataforms->save();
                        }
                    } else {
                        $dataforms = new Dataforms();
                        $dataforms->fieldsforms_id = 44;
                        $dataforms->titel = "Год отчетности";
                        $dataforms->data = $report[2];
                        $dataforms->save();
                        $idDataformsforExtraFields = Yii::$app->db->getLastInsertID();
                        if (!empty($report[4])) {
                            $extraFields = new ExtraFields();
                            $extraFields->type = 'income';
                            $extraFields->data = $report[4];
                            $extraFields->dataforms_id = $idDataformsforExtraFields;
                            $extraFields->fieldsforms_id = 47;
                            $extraFields->save();
                        }
                        if (!empty($report[6])) {
                            $extraFields = new ExtraFields();
                            $extraFields->type = 'expenditure';
                            $extraFields->data = $report[6];
                            $extraFields->dataforms_id = $idDataformsforExtraFields;
                            $extraFields->fieldsforms_id = 48;
                            $extraFields->save();
                        }
                    }
                }
            }
            //Сохранение url
            if ($request->post('paid_educational')) {
                foreach ($request->post('paid_educational') as $row) {
                    $p = 0;
                    if (!empty($row[3]) && ((new UrlValidator())->validate($row[3]))) {
                        if ($row[0] != '0') {
                            $saveintable = Dataforms::findOne($row[0]);
                            if (!empty($saveintable) && ($row[3] != $saveintable['data'] || $row[2] != $saveintable['titel'])) {
                                $saveintable->titel = $row[2];
                                $saveintable->data = $row[3];
                                $saveintable->updated_at = new \yii\db\Expression('NOW()');
                                if ($saveintable->validate()) {
                                    $saveintable->save();
                                } else {
                                    $p = 1;
                                }
                            }
                        } else {
                            $saveintable = new Dataforms();
                            $saveintable->fieldsforms_id = $row[1];
                            $saveintable->titel = $row[2];
                            $saveintable->data = $row[3];
                            if ($saveintable->validate()) {
                                $saveintable->save();
                            } else {
                                $p = 1;
                            }
                        }
                    } else {
                        $p = 1;
                    }
                    //ПРОВЕРИТЬ НА БАГИ, ТАК КАК ТАКОЙ ЖЕ МАССИВ И ДЛЯ ДОКУМЕНТОВ, но там еще добавляется в него position
                    // if ($p == 1) {
                    //     //Заполняем пустую link следующим текстом
                    //     if (empty($row[3])) {
                    //         $row[3] = "Введите данные";
                    //     }
                    //     // Проверка на то какая это запись, новая или старая
                    //     if ($row[0] == 0) {
                    //         $wrong[] = [
                    //             "titel" => $row[2],
                    //             "id" => 0,
                    //             "data" => $row[3],
                    //             "fieldsforms_id" => $row[1]
                    //         ];
                    //     } else {
                    //         $wrong[] = [
                    //             "titel" => $row[2],
                    //             "id" => $row[0],
                    //             "data" => $row[3],
                    //             "fieldsforms_id" => $row[1]
                    //         ];
                    //     }
                    //     // Создание переменной в сесси wrong_data, которая будет содержать ошибки допущенные пользователем
                    //     Yii::$app->session->set('wrong_data', $wrong);
                    //     Yii::$app->session->setFlash('error', 'Проверьте правильность введенных данных.');
                    // }
                }
            }
            if (isset($_FILES['document']) && $request->post('document')) {
                foreach ($_FILES['document']['name'] as $file => $name) {
                    $link = '';
                    $p = 0;
                    $position = '';
                    //Проверка на наличие файла
                    if ($name != '') {
                        $testMimeType = FileHelper::getMimeTypeByExtension($name);
                        //Проверка на расширение файла
                        if (in_array($testMimeType, $acTypesFileForUploading)) {
                            //Проверка, что запись старая
                            if ($request->post('document')[$file][0] != '0') {
                                //Поиск записи и её перезапись
                                $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                                if (!empty($saveintable)) {
                                    $s3 = new S3Client([
                                        'version' => 'latest',
                                        'region' => 'msk',
                                        'use_path_style_endpoint' => true,
                                        'credentials' => [
                                            'key' => $key,
                                            'secret' => $secret,
                                        ],
                                        'endpoint' => $endpoint,
                                    ]);
                                    $position = $saveintable['position'];
                                    $s3->putObject([
                                        'Bucket' => $bucket,
                                        'Key' => $position,
                                        'Body' => file_get_contents($_FILES['document']['tmp_name'][$file]),
                                        'ContentDisposition' => '"inline"',
                                        'ContentType' => $testMimeType
                                    ]);
                                    $s3->listBuckets();
                                    $command = $s3->getCommand('GetObject', [
                                        'Bucket' => $bucket,
                                        'Key' => $position
                                    ]);
                                    $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                                    $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                                    $lastdotposition = strpos($presignedUrl, "?");
                                    if ($lastdotposition !== false) {
                                        $link = substr($presignedUrl, 0, $lastdotposition);
                                    }
                                    $saveintable->titel = $request->post('document')[$file][2];
                                    $saveintable->data = $link;
                                    $saveintable->updated_at = new \yii\db\Expression('NOW()');
                                    if ($saveintable->validate()) {
                                        $saveintable->save();
                                    } else {
                                        $p = 1;
                                    }
                                }
                            } else {
                                //Новая запись в бд
                                $s3 = new S3Client([
                                    'version' => 'latest',
                                    'region' => 'msk',
                                    'use_path_style_endpoint' => true,
                                    'credentials' => [
                                        'key' => $key,
                                        'secret' => $secret,
                                    ],
                                    'endpoint' => $endpoint,
                                ]);
                                $tabel_filds = Fieldsforms::findOne($request->post('document')[$file][1]);
                                $count_upload_doc = $tabel_filds->count_upload_doc + 1;
                                $position = $tabel_filds->fieldform . $count_upload_doc;
                                $testMimeType = FileHelper::getMimeTypeByExtension($name);
                                $s3->putObject([
                                    'Bucket' => $bucket,
                                    'Key' => $position,
                                    'Body' => file_get_contents($_FILES['document']['tmp_name'][$file]),
                                    'ContentDisposition' => '"inline"',
                                    'ContentType' => $testMimeType
                                ]);
                                $s3->listBuckets();
                                $command = $s3->getCommand('GetObject', [
                                    'Bucket' => $bucket,
                                    'Key' => $position
                                ]);
                                $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                                $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                                $lastdotposition = strpos($presignedUrl, "?");
                                if ($lastdotposition !== false) {
                                    $link = substr($presignedUrl, 0, $lastdotposition);
                                }
                                $saveintable = new Dataforms();
                                $saveintable->titel = $request->post('document')[$file][2];
                                $saveintable->fieldsforms_id = $request->post('document')[$file][1];
                                $saveintable->data = $link;
                                $saveintable->position = $position;
                                if ($saveintable->validate()) {
                                    $tabel_filds->count_upload_doc = $count_upload_doc;
                                    $tabel_filds->save();
                                    $saveintable->save();
                                } else {
                                    $p = 1;
                                }
                            }
                        } else {
                            $p = 1;
                        }
                    } else {
                        //Запись в бд при отсутствии файла
                        //Проверка,что запись старая
                        if ($request->post('document')[$file][0] != '0') {
                            $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                            //Поиск записи и её перезапись
                            if (!empty($saveintable) && $saveintable['titel'] != $request->post('document')[$file][2]) {
                                $saveintable->titel = $request->post('document')[$file][2];
                                $saveintable->updated_at = new \yii\db\Expression('NOW()');
                                if ($saveintable->validate()) {
                                    $saveintable->save();
                                } else {
                                    $p = 1;
                                }
                            }
                        } else {
                            //Запись новых данных
                            $tabel_filds = Fieldsforms::findOne($request->post('document')[$file][1]);
                            $count_upload_doc = $tabel_filds->count_upload_doc + 1;
                            $position = $tabel_filds->fieldform . $count_upload_doc;
                            $saveintable = new Dataforms();
                            $saveintable->titel = $request->post('document')[$file][2];
                            $saveintable->fieldsforms_id = $request->post('document')[$file][1];
                            $saveintable->position = $position;
                            if ($saveintable->validate()) {
                                $tabel_filds->count_upload_doc = $count_upload_doc;
                                $tabel_filds->save();
                                $saveintable->save();
                            } else {
                                $p = 1;
                            }
                        }
                    }
                    //Проверка была ли допущена,где-то ошибка при добавлении данных
                    if ($p == 1) {
                        //Проверка, что  запись старая
                        if ($request->post('document')[$file][0] != '0') {
                            $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                            $wrong[] = [
                                'titel' => $request->post('document')[$file][2],
                                'fieldsforms_id' => $request->post('document')[$file][1],
                                'position' => $request->post('document')[$file][0],
                                'data' => $saveintable->data
                            ];
                        } else {
                            $wrong[] = [
                                'titel' => $request->post('document')[$file][2],
                                'fieldsforms_id' => $request->post('document')[$file][1],
                                'position' => '0',
                                'data' => ''
                            ];
                        }
                        //Создание в сесси переменной wrong_data, куда передается массив wrong с ошибками
                        Yii::$app->session->set('wrong_data', $wrong);
                        Yii::$app->session->setFlash('error', 'Проверьте правильность введенных данных.');
                    }
                }
            }
            return $this->redirect('');
        }
        //Ссылки и одиночные поля
        $singledata = Dataforms::find()
            ->joinWith('fieldsforms')
            ->andWhere(['and', ['fieldsforms.nameform' => 'budget'], ['=', 'fieldsforms.count_upload_doc', 0], ['not in', 'fieldsforms.id', [44, 47, 48]]])
            ->all();
        //Отчетность по доходам и расходам
        $report = Dataforms::find()
            ->joinWith('fieldsforms')
            ->andWhere(['and', ['fieldsforms.nameform' => 'budget'], ['=', 'fieldsforms.count_upload_doc', 0], ['not in', 'fieldsforms.id', [40, 41, 42, 43, 45, 46]]])
            ->all();
        //Файлы
        $tabledata = Dataforms::find()
            ->joinWith('fieldsforms')
            ->andWhere(['and', ['fieldsforms.nameform' => 'budget'], ['>', 'fieldsforms.count_upload_doc', 0]])
            ->all();
        $filteredMenuItems = self::getFilteredMenuItems();
        return $this->render("budget", ["tabledata" => $tabledata, "singledata" => $singledata, "report" => $report, 'menuItems' => $filteredMenuItems,]);
    }
    public function actionObjects()
    {
        $request = Yii::$app->request;

        if ($request->post()) {
            if ($request->post("tableobj")) {
                foreach ($request->post("tableobj") as $obj) {
                    if ($obj[0][0] != "0") {
                        for ($i = 2; $i <= count($obj[0]) - 2; $i += 2) {
                            $saveintable = ExtraFields::findOne($obj[0][$i]);
                            if ($saveintable->data != $obj[0][$i + 1]) {
                                $saveintable->data = $obj[0][$i + 1];
                                $saveintable->save();
                                $saveintable = Dataforms::findOne($obj[0][0]);
                                $saveintable->updated_at = new \yii\db\Expression('NOW()');
                                $saveintable->save();
                            }
                        }
                    } else {
                        $saveintable = new Dataforms();
                        if ($obj[0][1] == "49") {
                            $saveintable->titel = "Сведения о библиотеке";
                            $saveintable->fieldsforms_id = $obj[0][1];
                            $saveintable->save();
                        } else {
                            $saveintable->titel = "Сведения об объекте спорта";
                            $saveintable->fieldsforms_id = $obj[0][1];
                            $saveintable->save();
                        }
                        $idDataformsforExtraFields = Yii::$app->db->getLastInsertID();
                        for ($i = 2; $i <= count($obj[0]) - 2; $i += 2) {
                            $type;
                            $saveintable = new ExtraFields();
                            $saveintable->dataforms_id = $idDataformsforExtraFields;
                            switch ($obj[0][$i]) {
                                case "51":
                                case "52":
                                    $type = "text";
                                    break;
                                case "53":
                                    $type = "float";
                                    break;
                                case "54":
                                case "55":
                                    $type = "int";
                                    break;
                            }
                            $saveintable->fieldsforms_id = $obj[0][$i];
                            if (!empty($obj[0][$i + 1])) {
                                $saveintable->data = $obj[0][$i + 1];
                            } else {
                                $saveintable->data = "0";
                            }
                            $saveintable->type = $type;
                            $saveintable->save();
                        }
                    }
                }
            }
            if ($request->post("budget")) {
                foreach ($request->post("budget") as $budget) {
                    if ($budget[0] != "0") {
                        $saveintable = Dataforms::findOne($budget[0]);
                        if ($budget[3] != $saveintable->data) {
                            $saveintable->data = $budget[3];
                            $saveintable->updated_at = new \yii\db\Expression('NOW()');
                            $saveintable->save();
                        }
                    } else {
                        $saveintable = new Dataforms();
                        $saveintable->fieldsforms_id = $budget[1];
                        $saveintable->titel = $budget[2];
                        $saveintable->data = $budget[3];
                        $saveintable->save();
                    }
                }
            }
            //Сохранение url
            if ($request->post('paid_educational')) {
                foreach ($request->post('paid_educational') as $row) {
                    $p = 0;
                    if (!empty($row[3]) && ((new UrlValidator())->validate($row[3]))) {
                        if ($row[0] != '0') {
                            $saveintable = Dataforms::findOne($row[0]);
                            if (!empty($saveintable) && ($row[3] != $saveintable['data'] || $row[2] != $saveintable['titel'])) {
                                $saveintable->titel = $row[2];
                                $saveintable->data = $row[3];
                                $saveintable->updated_at = new \yii\db\Expression('NOW()');
                                if ($saveintable->validate()) {
                                    $saveintable->save();
                                } else {
                                    $p = 1;
                                }
                            }
                        } else {
                            $saveintable = new Dataforms();
                            $saveintable->fieldsforms_id = $row[1];
                            $saveintable->titel = $row[2];
                            $saveintable->data = $row[3];
                            if ($saveintable->validate()) {
                                $saveintable->save();
                            } else {
                                $p = 1;
                            }
                        }
                    } else {
                        $p = 1;
                    }
                    //ПРОВЕРИТЬ НА БАГИ, ТАК КАК ТАКОЙ ЖЕ МАССИВ И ДЛЯ ДОКУМЕНТОВ, но там еще добавляется в него position
                    // if ($p == 1) {
                    //     //Заполняем пустую link следующим текстом
                    //     if (empty($row[3])) {
                    //         $row[3] = "Введите данные";
                    //     }
                    //     // Проверка на то какая это запись, новая или старая
                    //     if ($row[0] == 0) {
                    //         $wrong[] = [
                    //             "titel" => $row[2],
                    //             "id" => 0,
                    //             "data" => $row[3],
                    //             "fieldsforms_id" => $row[1]
                    //         ];
                    //     } else {
                    //         $wrong[] = [
                    //             "titel" => $row[2],
                    //             "id" => $row[0],
                    //             "data" => $row[3],
                    //             "fieldsforms_id" => $row[1]
                    //         ];
                    //     }
                    //     // Создание переменной в сесси wrong_data, которая будет содержать ошибки допущенные пользователем
                    //     Yii::$app->session->set('wrong_data', $wrong);
                    //     Yii::$app->session->setFlash('error', 'Проверьте правильность введенных данных.');
                    // }
                }
            }
            return $this->redirect('');
        }
        $tables = Dataforms::find()
            ->joinWith('fieldsforms')
            ->andWhere(['and', ['fieldsforms.nameform' => 'objects'], ['or', ['fieldsforms.id' => "50"], ['fieldsforms.id' => "49"]]])
            ->joinWith('extraFields')
            ->all();
        //Ссылки и одиночные поля
        $singledata = Dataforms::find()
            ->joinWith('fieldsforms')
            ->andWhere(['and', ['fieldsforms.nameform' => 'objects'], ['not in', 'fieldsforms.id', [49, 50, 51, 52, 53, 54, 55]]])
            ->all();
        $filteredMenuItems = self::getFilteredMenuItems();
        return $this->render("objects", ["singledata" => $singledata, "tables" => $tables, 'menuItems' => $filteredMenuItems,]);
    }
    public function actionCatering()
    {
        $request = Yii::$app->request;
        if ($request->post("tableobj")) {
            foreach ($request->post("tableobj") as $obj) {
                if ($obj[0][0] != "0") {
                    for ($i = 2; $i <= count($obj[0]) - 2; $i += 2) {
                        $saveintable = ExtraFields::findOne($obj[0][$i]);
                        if ($saveintable->data != $obj[0][$i + 1]) {
                            $saveintable->data = $obj[0][$i + 1];
                            $saveintable->save();
                            $saveintable = Dataforms::findOne($obj[0][0]);
                            $saveintable->updated_at = new \yii\db\Expression('NOW()');
                            $saveintable->save();
                        }
                    }
                } else {
                    $saveintable = new Dataforms();
                    if ($obj[0][1] == "69") {
                        $saveintable->titel = "Сведения об условиях питания обучающихся";
                        $saveintable->fieldsforms_id = $obj[0][1];
                        $saveintable->save();
                    } else {
                        $saveintable->titel = "Сведения об условиях охраны здоровья обучающихся";
                        $saveintable->fieldsforms_id = $obj[0][1];
                        $saveintable->save();
                    }
                    $idDataformsforExtraFields = Yii::$app->db->getLastInsertID();
                    for ($i = 2; $i <= count($obj[0]) - 2; $i += 2) {
                        $type;
                        $saveintable = new ExtraFields();
                        $saveintable->dataforms_id = $idDataformsforExtraFields;
                        switch ($obj[0][$i]) {
                            case "51":
                            case "52":
                                $type = "text";
                                break;
                            case "53":
                                $type = "float";
                                break;
                            case "54":
                            case "55":
                                $type = "int";
                                break;
                        }
                        $saveintable->fieldsforms_id = $obj[0][$i];
                        $saveintable->data = $obj[0][$i + 1];
                        $saveintable->type = $type;#!
                        $saveintable->save();
                    }
                }
            }
            return $this->redirect('');
        }
        $tables = Dataforms::find()
            ->joinWith('fieldsforms')
            ->andWhere(['and', ['fieldsforms.nameform' => 'catering']])
            ->joinWith('extraFields')
            ->all();
        $filteredMenuItems = self::getFilteredMenuItems();
        return $this->render("catering", ["tables" => $tables, 'menuItems' => $filteredMenuItems,]);
    }
    public function actionEducation()
    {
        $request = Yii::$app->request;
        $takedata = new Dataforms();
        $data = $takedata::find()
            ->joinWith('fieldsforms')
            ->andWhere(['fieldsforms.nameform' => 'education'])
            ->all();
        if ($request->post()) {
            if ($request->post("tableobj")) {
                foreach ($request->post("tableobj") as $obj) {
                    if ($obj[0][0] != "0") {
                        for ($i = 2; $i <= count($obj[0]) - 2; $i += 2) {
                            $saveintable = ExtraFields::findOne($obj[0][$i]);
                            if ($saveintable->data != $obj[0][$i + 1]) {
                                $saveintable->data = $obj[0][$i + 1];
                                $saveintable->save();
                                $saveintable = Dataforms::findOne($obj[0][0]);
                                $saveintable->updated_at = new \yii\db\Expression('NOW()');
                                $saveintable->save();
                            }
                        }
                    } else {
                        $saveintable = new Dataforms();
                        $saveintable->titel = "Информация о трудоустройстве выпускников для каждой реализуемой образовательной программы, по которой состоялся выпуск";
                        $saveintable->fieldsforms_id = $obj[0][1];
                        $saveintable->save();
                        $idDataformsforExtraFields = Yii::$app->db->getLastInsertID();
                        for ($i = 2; $i <= count($obj[0]) - 2; $i += 2) {
                            $type;
                            $saveintable = new ExtraFields();
                            $saveintable->dataforms_id = $idDataformsforExtraFields;
                            switch ($obj[0][$i]) {
                                case "76":
                                case "77":
                                case "78":
                                    $type = "text";
                                    break;
                                case "79":
                                case "80":
                                    $type = "int";
                                    break;
                            }
                            $saveintable->fieldsforms_id = $obj[0][$i];
                            $saveintable->data = $obj[0][$i + 1];
                            $saveintable->type = $type;
                            $saveintable->save();
                        }
                    }
                }
            }
            $key = $this->module->params['key'];
            $secret = $this->module->params['secret'];
            $endpoint = $this->module->params['endpoint'];
            $bucket = $this->module->params['Bucket'];
            //массив с разрешенными расширениями файлов
            $acTypesFileForUploading = array(
                "image/jpeg",//jpg or jpeg
                "image/png",//png
                "application/pdf",//pdf
                "application/msword",//doc (not docx)
                "application/vnd.ms-excel",//xls (not xlsx)
                "text/csv",//csv
                //"application/vnd.openxmlformats-officedocument.wordprocessingml.document",//docx
                //"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",//xlsx
                //"application/vnd.ms-powerpoint",//ppt
                //"application/vnd.openxmlformats-officedocument.presentationml.presentation",//pptx
            );
            if (isset($_FILES['document']) && $request->post('document')) {
                foreach ($_FILES['document']['name'] as $file => $name) {
                    $link = '';
                    $p = 0;
                    $position = '';
                    //Проверка на наличие файла
                    if ($name != '') {
                        $testMimeType = FileHelper::getMimeTypeByExtension($name);
                        //Проверка на расширение файла
                        if (in_array($testMimeType, $acTypesFileForUploading)) {
                            //Проверка, что запись старая
                            if ($request->post('document')[$file][0] != '0') {
                                //Поиск записи и её перезапись
                                $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                                if (!empty($saveintable)) {
                                    $s3 = new S3Client([
                                        'version' => 'latest',
                                        'region' => 'msk',
                                        'use_path_style_endpoint' => true,
                                        'credentials' => [
                                            'key' => $key,
                                            'secret' => $secret,
                                        ],
                                        'endpoint' => $endpoint,
                                    ]);
                                    $position = $saveintable['position'];
                                    $s3->putObject([
                                        'Bucket' => $bucket,
                                        'Key' => $position,
                                        'Body' => file_get_contents($_FILES['document']['tmp_name'][$file]),
                                        'ContentDisposition' => '"inline"',
                                        'ContentType' => $testMimeType
                                    ]);
                                    $s3->listBuckets();
                                    $command = $s3->getCommand('GetObject', [
                                        'Bucket' => $bucket,
                                        'Key' => $position
                                    ]);
                                    $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                                    $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                                    $lastdotposition = strpos($presignedUrl, "?");
                                    if ($lastdotposition !== false) {
                                        $link = substr($presignedUrl, 0, $lastdotposition);
                                    }
                                    $saveintable->titel = $request->post('document')[$file][2];
                                    $saveintable->data = $link;
                                    $saveintable->updated_at = new \yii\db\Expression('NOW()');
                                    if ($saveintable->validate()) {
                                        $saveintable->save();
                                    } else {
                                        $p = 1;
                                    }
                                }
                            } else {
                                //Новая запись в бд
                                $s3 = new S3Client([
                                    'version' => 'latest',
                                    'region' => 'msk',
                                    'use_path_style_endpoint' => true,
                                    'credentials' => [
                                        'key' => $key,
                                        'secret' => $secret,
                                    ],
                                    'endpoint' => $endpoint,
                                ]);
                                $tabel_filds = Fieldsforms::findOne($request->post('document')[$file][1]);
                                $count_upload_doc = $tabel_filds->count_upload_doc + 1;
                                $position = $tabel_filds->fieldform . $count_upload_doc;
                                $testMimeType = FileHelper::getMimeTypeByExtension($name);
                                $s3->putObject([
                                    'Bucket' => $bucket,
                                    'Key' => $position,
                                    'Body' => file_get_contents($_FILES['document']['tmp_name'][$file]),
                                    'ContentDisposition' => '"inline"',
                                    'ContentType' => $testMimeType
                                ]);
                                $s3->listBuckets();
                                $command = $s3->getCommand('GetObject', [
                                    'Bucket' => $bucket,
                                    'Key' => $position
                                ]);
                                $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                                $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                                $lastdotposition = strpos($presignedUrl, "?");
                                if ($lastdotposition !== false) {
                                    $link = substr($presignedUrl, 0, $lastdotposition);
                                }
                                $saveintable = new Dataforms();
                                $saveintable->titel = $request->post('document')[$file][2];
                                $saveintable->fieldsforms_id = $request->post('document')[$file][1];
                                $saveintable->data = $link;
                                $saveintable->position = $position;
                                if ($saveintable->validate()) {
                                    $tabel_filds->count_upload_doc = $count_upload_doc;
                                    $tabel_filds->save();
                                    $saveintable->save();
                                } else {
                                    $p = 1;
                                }
                            }
                        } else {
                            $p = 1;
                        }
                    } else {
                        //Запись в бд при отсутствии файла
                        //Проверка,что запись старая
                        if ($request->post('document')[$file][0] != '0') {
                            $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                            //Поиск записи и её перезапись
                            if (!empty($saveintable) && $saveintable['titel'] != $request->post('document')[$file][2]) {
                                $saveintable->titel = $request->post('document')[$file][2];
                                $saveintable->updated_at = new \yii\db\Expression('NOW()');
                                if ($saveintable->validate()) {
                                    $saveintable->save();
                                } else {
                                    $p = 1;
                                }
                            }
                        } else {
                            //Запись новых данных
                            $tabel_filds = Fieldsforms::findOne($request->post('document')[$file][1]);
                            $count_upload_doc = $tabel_filds->count_upload_doc + 1;
                            $position = $tabel_filds->fieldform . $count_upload_doc;
                            $saveintable = new Dataforms();
                            $saveintable->titel = $request->post('document')[$file][2];
                            $saveintable->fieldsforms_id = $request->post('document')[$file][1];
                            $saveintable->position = $position;
                            if ($saveintable->validate()) {
                                $tabel_filds->count_upload_doc = $count_upload_doc;
                                $tabel_filds->save();
                                $saveintable->save();
                            } else {
                                $p = 1;
                            }
                        }
                    }
                    //Проверка была ли допущена,где-то ошибка при добавлении данных
                    if ($p == 1) {
                        //Проверка, что  запись старая
                        if ($request->post('document')[$file][0] != '0') {
                            $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                            $wrong[] = [
                                'titel' => $request->post('document')[$file][2],
                                'fieldsforms_id' => $request->post('document')[$file][1],
                                'position' => $request->post('document')[$file][0],
                                'data' => $saveintable->data
                            ];
                        } else {
                            $wrong[] = [
                                'titel' => $request->post('document')[$file][2],
                                'fieldsforms_id' => $request->post('document')[$file][1],
                                'position' => '0',
                                'data' => ''
                            ];
                        }
                        //Создание в сесси переменной wrong_data, куда передается массив wrong с ошибками
                        Yii::$app->session->set('wrong_data', $wrong);
                        Yii::$app->session->setFlash('error', 'Проверьте правильность введенных данных.');
                    }
                }
            }
            return $this->redirect('');
        }
        $tables = Dataforms::find()
            ->joinWith('fieldsforms')
            ->andWhere(['between', 'fieldsforms.id', 75, 80])
            ->joinWith('extraFields')
            ->all();
        $filteredMenuItems = self::getFilteredMenuItems();
        return $this->render("education", ['tabledata' => $data, 'tables' => $tables, 'menuItems' => $filteredMenuItems,]);
    }

    //Дальше идут удаления
    public function actionDeletepaidedu()
    {
        //document
        $request = Yii::$app->request;
        $table = new Dataforms();
        $delintable = $table::find()
            ->joinWith('fieldsforms')
            ->andWhere(['fieldsforms.nameform' => 'paid_edu'])
            ->all();
        if ($request->post('paid_educational')) {
            $post_paid_educational = [];
            foreach ($request->post('paid_educational') as $postdata) {
                $post_paid_educational[] = $postdata[0];
            }
            foreach ($delintable as $deldata) {
                if (in_array($deldata['id'], $post_paid_educational)) {
                } else {
                    //Если enabled не существует то мы его удаляем, а если существует, скрываем элемент
                    if (!$request->post('enabled')) {
                        $del = $table::findOne($deldata['id']);
                        $del->delete();
                    } else {
                        $del = $table::findOne($deldata['id']);
                        $del->enabled = 0;
                        $del->updated_at = new \yii\db\Expression('NOW()');
                        $del->save();
                    }
                }
            }
        } else {
            $table = $table::find()
                ->joinWith('fieldsforms')
                ->andWhere(['and', ['fieldsforms.nameform' => 'paid_edu'], ['enabled' => 1]])
                ->one();
            if (!$request->post('enabled')) {
                $table->delete();
            } else {
                $table->enabled = 0;
                $table->updated_at = new \yii\db\Expression('NOW()');
                $table->save();
            }
        }
    }
    public function actionDeletegrants()
    {
        $request = Yii::$app->request;
        $table = new Dataforms();
        $delintable = $table::find()
            ->joinWith('fieldsforms')
            ->andWhere(['fieldsforms.nameform' => 'grants'])
            ->all();
        if ($request->post('paid_educational')) {
            $post_paid_educational = [];
            foreach ($request->post('paid_educational') as $postdata) {
                $post_paid_educational[] = $postdata[0];
            }
            foreach ($delintable as $deldata) {
                if (in_array($deldata['id'], $post_paid_educational)) {
                } else {
                    //Если enabled не существует то мы его удаляем, а если существует, скрываем элемент
                    if (!$request->post('enabled')) {
                        $del = $table::findOne($deldata['id']);
                        $del->delete();
                    } else {
                        $del = $table::findOne($deldata['id']);
                        $del->enabled = 0;
                        $del->updated_at = new \yii\db\Expression('NOW()');
                        $del->save();
                    }
                }
            }
        } else {
            $table = $table::find()
                ->joinWith('fieldsforms')
                ->andWhere(['and', ['fieldsforms.nameform' => 'grants'], ['enabled' => 1]])
                ->one();
            if (!$request->post('enabled')) {
                $table->delete();
            } else {
                $table->enabled = 0;
                $table->updated_at = new \yii\db\Expression('NOW()');
                $table->save();
            }
        }
    }
    public function actionDeletedocument()
    {
        $userId = Yii::$app->user->id;
        $trimmedNamesInRoles = self::getSelfUserRoles($userId);
        $request = Yii::$app->request;
        $table = new Dataforms();
        if ($request->post('document')) {
            //создаем массив id из POST
            foreach ($request->post('document') as $postdata) {
                $post_document[] = $postdata[0];
            }
            if ($request->post('whatisurl')) {
                switch ($request->post('whatisurl')) {
                    //document
                    case "1":
                        self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                        $delintable = $table::find()
                            ->joinWith('fieldsforms')
                            ->andWhere(['and', ['fieldsforms.nameform' => 'document'], ['enabled' => 1]])
                            ->all();
                        break;
                    //common
                    case "2":
                        self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                        $delintable = $table::find()->joinWith('fieldsforms')
                            ->andWhere(['fieldsforms.fieldform' => 'licence_to_carry_out_educational_activities'])
                            ->orWhere(['fieldsforms.fieldform' => 'state_accreditation_of_educational_activities_under_implemented_educational_programmes'])
                            ->andWhere(['enabled' => 1])
                            ->all();
                        break;
                    //edustandarts
                    case "3":
                        self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                        $delintable = $table::find()->joinWith('fieldsforms')
                            ->joinWith('fieldsforms')
                            ->andWhere(['and', ['fieldsforms.nameform' => 'edustandarts'], ['enabled' => 1]])
                            ->all();
                        break;
                    //paid_edu
                    case "4":
                        self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                        $delintable = $table::find()->joinWith('fieldsforms')
                            ->joinWith('fieldsforms')
                            ->andWhere(['and', ['fieldsforms.nameform' => 'paid_edu'], ['enabled' => 1]])
                            ->all();
                        break;
                    //grants
                    case "5":
                        self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                        $delintable = $table::find()->joinWith('fieldsforms')
                            ->joinWith('fieldsforms')
                            ->andWhere(['and', ['fieldsforms.nameform' => 'grants'], ['enabled' => 1], ['>', 'fieldsforms.count_upload_doc', 0]])
                            ->all();
                        break;
                    //budget
                    case "6":
                        self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                        $delintable = $table::find()->joinWith('fieldsforms')
                            ->andWhere(['and', ['fieldsforms.nameform' => 'budget'], ['enabled' => 1], ['>', 'fieldsforms.count_upload_doc', 0]])
                            ->all();
                        break;
                    //education
                    case "7":
                        self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                        $delintable = $table::find()->joinWith('fieldsforms')
                            ->andWhere(['and', ['fieldsforms.nameform' => 'education'], ['enabled' => 1]])
                            ->all();
                        break;
                }
            }
            foreach ($delintable as $deldata) {
                if (in_array($deldata['position'], $post_document)) {
                } else {
                    //Если enabled не существует то мы его удаляем, а если существует, скрываем элемент
                    if (!$request->post('enabled')) {
                        $link = $table::findOne(['position' => $deldata['position']]);
                        //Если ссылка пустая, то удаляем только из таблицы, если нет, то удаляем еще и файл
                        if ($link['data'] == '') {
                            $del = $table::findOne(['position' => $deldata['position']]);
                            $del->delete();
                        } else {
                            if (!$request->post('enabled')) {
                                $key = $this->module->params['key'];
                                $secret = $this->module->params['secret'];
                                $endpoint = $this->module->params['endpoint'];
                                $bucket = $this->module->params['Bucket'];
                                $s3 = new S3Client([
                                    'version' => 'latest',
                                    'region' => 'msk',
                                    'use_path_style_endpoint' => true,
                                    'credentials' => [
                                        'key' => $key,
                                        'secret' => $secret,
                                    ],
                                    'endpoint' => $endpoint,
                                ]);
                                $s3->deleteObject([
                                    'Bucket' => $bucket,
                                    'Key' => $deldata['position'],
                                ]);
                                $del = $table::findOne(['position' => $deldata['position']]);
                                $del->delete();
                            } else {
                                $del = $table::findOne(['position' => $deldata['position']]);
                                $del->enabled = 0;
                                $del->save();
                            }
                        }
                    } else {
                        $del = $table::findOne(['position' => $deldata['position']]);
                        $del->enabled = 0;
                        $del->updated_at = new \yii\db\Expression('NOW()');
                        $del->save();
                    }
                }
            }
        } else {
            if ($request->post('whatisurl')) {
                switch ($request->post('whatisurl')) {
                    //document
                    case "1":
                        self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                        $table = $table::find()
                            ->joinWith('fieldsforms')
                            ->andWhere(['and', ['fieldsforms.nameform' => 'document'], ['enabled' => 1]])
                            ->one();
                        break;
                    //common
                    case "2":
                        self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                        $table = $table::find()->joinWith('fieldsforms')
                            ->andWhere(['or', ['fieldsforms.fieldform' => 'licence_to_carry_out_educational_activities'], ['fieldsforms.fieldform' => 'state_accreditation_of_educational_activities_under_implemented_educational_programmes']])
                            ->andWhere(['enabled' => 1])
                            ->one();
                        break;
                    //edustandarts
                    case "3":
                        self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                        $table = $table::find()->joinWith('fieldsforms')
                            ->joinWith('fieldsforms')
                            ->andWhere(['and', ['fieldsforms.nameform' => 'edustandarts'], ['enabled' => 1]])
                            ->one();
                        break;
                    //paid_edu
                    case "4":
                        self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                        $table = $table::find()->joinWith('fieldsforms')
                            ->joinWith('fieldsforms')
                            ->andWhere(['and', ['fieldsforms.nameform' => 'paid_edu'], ['enabled' => 1]])
                            ->one();
                        break;
                    //grants
                    case "5":
                        self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                        $table = $table::find()->joinWith('fieldsforms')
                            ->joinWith('fieldsforms')
                            ->andWhere(['and', ['fieldsforms.nameform' => 'grants'], ['>', 'fieldsforms.count_upload_doc', 0], ['enabled' => 1]])
                            ->one();
                        break;
                    //budget
                    case "6":
                        self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                        $table = $table::find()->joinWith('fieldsforms')
                            ->andWhere(['and', ['fieldsforms.nameform' => 'budget'], ['>', 'fieldsforms.count_upload_doc', 0], ['enabled' => 1]])
                            ->one();
                        break;
                    //education
                    case "7":
                        self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                        $table = $table::find()->joinWith('fieldsforms')
                            ->andWhere(['and', ['fieldsforms.nameform' => 'education'], ['enabled' => 1]])
                            ->one();
                        break;
                }
            }
            if (!$request->post('enabled')) {
                //Если ссылка для файла пустая, удаляем только запись, если нет то и сам файл
                if ($table['data'] == '') {
                    $table->delete();
                } else {
                    $key = $this->module->params['key'];
                    $secret = $this->module->params['secret'];
                    $endpoint = $this->module->params['endpoint'];
                    $bucket = $this->module->params['Bucket'];
                    $s3 = new S3Client([
                        'version' => 'latest',
                        'region' => 'msk',
                        'use_path_style_endpoint' => true,
                        'credentials' => [
                            'key' => $key,
                            'secret' => $secret,
                        ],
                        'endpoint' => $endpoint,
                    ]);
                    $s3->deleteObject([
                        'Bucket' => $bucket,
                        'Key' => $table['position'],
                    ]);
                    $table->delete();
                }
            } else {
                $table->enabled = 0;
                $table->updated_at = new \yii\db\Expression('NOW()');
                $table->save();
            }
        }
    }
    public function actionDeleteinter()
    {

        $userId = Yii::$app->user->id;
        $trimmedNamesInRoles = self::getSelfUserRoles($userId);
        $request = Yii::$app->request;
        switch ($request->post('whatisurl')) {
            case 6:
                self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                if ($request->post("id") && !$request->post("name")) {
                    $dataforms = new Dataforms();
                    $del = $dataforms::findOne($request->post("id"));
                    $del->delete();
                }
                if ($request->post("name")) {
                    $extrafields = new ExtraFields();
                    $del = $extrafields::findOne($request->post("id"));
                    $del->delete();
                }
                break;
            case 7:
                self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                if ($request->post("id") && !$request->post("name")) {
                    $dataforms = new Dataforms();
                    $del = $dataforms::findOne($request->post("id"));
                    $del->delete();
                }
                if ($request->post("name")) {
                    $extrafields = new ExtraFields();
                    $del = $extrafields::findOne($request->post("id"));
                    $del->delete();
                }
                break;
            case 8:
                self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                if ($request->post("id") && !$request->post("name")) {
                    $dataforms = new Dataforms();
                    $del = $dataforms::findOne($request->post("id"));
                    $del->delete();
                }
                if ($request->post("name")) {
                    $extrafields = new ExtraFields();
                    $del = $extrafields::findOne($request->post("id"));
                    $del->delete();
                }
                break;
            case 9:
                self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                if ($request->post("id") && !$request->post("name")) {
                    $dataforms = new Dataforms();
                    $del = $dataforms::findOne($request->post("id"));
                    $del->delete();
                }
                if ($request->post("name")) {
                    $extrafields = new ExtraFields();
                    $del = $extrafields::findOne($request->post("id"));
                    $del->delete();
                }
                break;
            case 10:
                self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                if ($request->post("id") && !$request->post("name")) {
                    $dataforms = new Dataforms();
                    $del = $dataforms::findOne($request->post("id"));
                    $del->delete();
                }
                if ($request->post("name")) {
                    $extrafields = new ExtraFields();
                    $del = $extrafields::findOne($request->post("id"));
                    $del->delete();
                }
                break;
        }
    }
    public function actionDeletebudget()
    {
        //$userId = Yii::$app->user->id;
        //$trimmedNamesInRoles = self::getSelfUserRoles($userId);
        $request = Yii::$app->request;
        //self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);


        $table = new Dataforms();
        $delintable = $table::find()
            ->joinWith('fieldsforms')
            ->andWhere(['and', ['fieldsforms.nameform' => 'budget'], ['=', 'fieldsforms.count_upload_doc', 0], ['enabled' => 1], ['fieldsforms.id' => 46]])
            ->all();
        if ($request->post('paid_educational')) {
            $post_paid_educational = [];
            foreach ($request->post('paid_educational') as $postdata) {
                $post_paid_educational[] = $postdata[0];
            }
            foreach ($delintable as $deldata) {
                if (in_array($deldata['id'], $post_paid_educational)) {
                } else {
                    //Если enabled не существует то мы его удаляем, а если существует, скрываем элемент
                    if (!$request->post('enabled')) {
                        $del = $table::findOne($deldata['id']);
                        $del->delete();
                    } else {
                        $del = $table::findOne($deldata['id']);
                        $del->enabled = 0;
                        $del->updated_at = new \yii\db\Expression('NOW()');
                        $del->save();
                    }
                }
            }
        } else {
            $table = $table::find()
                ->joinWith('fieldsforms')
                ->andWhere(['and', ['fieldsforms.nameform' => 'budget'], ['=', 'fieldsforms.count_upload_doc', 0], ['enabled' => 1], ['fieldsforms.id' => 46]])
                ->one();
            if (!$request->post('enabled')) {
                $table->delete();
            } else {
                $table->enabled = 0;
                $table->updated_at = new \yii\db\Expression('NOW()');
                $table->save();
            }
        }
    }
    public function actionDeleteobjects()
    {
        $userId = Yii::$app->user->id;
        $trimmedNamesInRoles = self::getSelfUserRoles($userId);
        $request = Yii::$app->request;

        switch ($request->post('whatisurl')) {
            case 8:
                self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                $table = new Dataforms();
                $delintable = $table::find()
                    ->joinWith('fieldsforms')
                    ->andWhere(['and', ['enabled' => 1], ['or', ['fieldsforms.id' => 65], ['fieldsforms.id' => 66]]])
                    ->all();
                if ($request->post('paid_educational')) {
                    $post_paid_educational = [];
                    foreach ($request->post('paid_educational') as $postdata) {
                        $post_paid_educational[] = $postdata[0];
                    }
                    foreach ($delintable as $deldata) {
                        if (in_array($deldata['id'], $post_paid_educational)) {
                        } else {
                            //Если enabled не существует то мы его удаляем, а если существует, скрываем элемент
                            if (!$request->post('enabled')) {
                                $del = $table::findOne($deldata['id']);
                                $del->delete();
                            } else {
                                $del = $table::findOne($deldata['id']);
                                $del->enabled = 0;
                                $del->updated_at = new \yii\db\Expression('NOW()');
                                $del->save();
                            }
                        }
                    }
                } else {
                    $table = $table::find()
                        ->joinWith('fieldsforms')
                        ->andWhere(['and', ['enabled' => 1], ['or', ['fieldsforms.id' => 65], ['fieldsforms.id' => 66]]])
                        ->one();
                    if (!$request->post('enabled')) {
                        $table->delete();
                    } else {
                        $table->enabled = 0;
                        $table->updated_at = new \yii\db\Expression('NOW()');
                        $table->save();
                    }
                }
                break;
            case 10:
                self::checkPageDeleteAccess($request->post('whatisurl'), $trimmedNamesInRoles);
                $table = new Dataforms();
                $delintable = $table::find()
                    ->joinWith('fieldsforms')
                    ->andWhere(['and', ['enabled' => 1], ['or', ['fieldsforms.id' => 65], ['fieldsforms.id' => 66]]])
                    ->all();
                if ($request->post('paid_educational')) {
                    $post_paid_educational = [];
                    foreach ($request->post('paid_educational') as $postdata) {
                        $post_paid_educational[] = $postdata[0];
                    }
                    foreach ($delintable as $deldata) {
                        if (in_array($deldata['id'], $post_paid_educational)) {
                        } else {
                            //Если enabled не существует то мы его удаляем, а если существует, скрываем элемент
                            if (!$request->post('enabled')) {
                                $del = $table::findOne($deldata['id']);
                                $del->delete();
                            } else {
                                $del = $table::findOne($deldata['id']);
                                $del->enabled = 0;
                                $del->updated_at = new \yii\db\Expression('NOW()');
                                $del->save();
                            }
                        }
                    }
                } else {
                    $table = $table::find()
                        ->joinWith('fieldsforms')
                        ->andWhere(['and', ['enabled' => 1], ['or', ['fieldsforms.id' => 65], ['fieldsforms.id' => 66]]])
                        ->one();
                    if (!$request->post('enabled')) {
                        $table->delete();
                    } else {
                        $table->enabled = 0;
                        $table->updated_at = new \yii\db\Expression('NOW()');
                        $table->save();
                    }
                }
                break;
        }
    }
    private function getFilteredMenuItems()
    {

        $userId = Yii::$app->user->id;

        $baseSectionUrl = '/specialsection/section/';
        $menuItems = [];
        $sections = Section::getSections();

        $sectionLabels = [
            'common' => 'Основные сведения',
            'struct' => 'Структура и органы управления образовательной организацией',
            'document' => 'Документы',
            'education' => 'Образование',
            'edustandarts' => 'Образовательные стандарты и требования',
            'managers' => 'Руководство',
            'employees' => 'Педагогический (научно-педагогический) состав',
            'objects' => 'Материально-техническое обеспечение и оснащенность образовательного процесса. Доступная среда',
            'grants' => 'Стипендии и меры поддержки обучающихся',
            'paidedu' => 'Платные образовательные услуги',
            'budget' => 'Финансово-хозяйственная деятельность',
            'vacant' => 'Вакантные места для приема (перевода) обучающихся',
            'ovz' => 'Доступная среда',
            'inter' => 'Международное сотрудничество',
            'catering' => 'Организация питания в образовательной организации',
        ];

        foreach ($sections as $section) {
            $url = $baseSectionUrl . $section;
            $menuItems[$section] = [
                'url' => $url,
                'label' => $sectionLabels[$section],
            ];
        }

        $trimmedNamesInRoles = self::getSelfUserRoles($userId);

        $filteredMenuItems = [];
        foreach ($menuItems as $key => $item) {
            if (in_array($key, $trimmedNamesInRoles)) {
                $filteredMenuItems[$key] = $item;
            }
        }

        return $filteredMenuItems;
    }
    private function getSelfUserRoles($userId)
    {
        $access = [
            Section::PAIDEDU => 'paidedu',
            Section::GRANTS => 'grants',
            Section::DOCUMENT => 'document',
            Section::COMMON => 'common',
            Section::EDUSTANDARTS => 'eduStandarts',
            Section::INTER => 'inter',
            Section::BUDGET => 'budget',
            Section::OBJECTS => 'objects',
            Section::CATERING => 'catering',
            Section::EDUCATION => 'education',
        ];
        $user = User::findOne($userId);
        $trimmedNamesInRoles = [];
        foreach ($access as $key => $role) {
            if ($user->isInRole('editor_' . $role)) {
                array_push($trimmedNamesInRoles, ($access[$key]));
            }
        }
        return $trimmedNamesInRoles;
    }

    private function getListControllerActions()
    {
        return get_class_methods(self::class);
    }

    private function checkPageDeleteAccess($whatIsUrlId, $listNamesRoles)
    {
        /*
        $request = Yii::$app->request;
        $userId = Yii::$app->user->id;
        $trimmedNamesInRoles = self::getSelfUserRoles($userId);
        var_dump($trimmedNamesInRoles);
        die();
        self::checkPageDeleteAccess('2',$trimmedNamesInRoles);
        */
        /*
        //document
                    case "1":
        //common
                    case "2":
        //edustandarts
                    case "3":
        //paid_edu
                    case "4":
        //grants
                    case "5":
        //budget
                    case "6":
        //education
                    case "7":
        */
        $access = [];
        for ($i = 1; $i <= 10; $i++) {
            $access[] = (string) $i;
        }
        if (!in_array($whatIsUrlId, $access)) {
            throw new \yii\web\ForbiddenHttpException('У вас нет доступа к этой странице.');
        }
        switch ($whatIsUrlId) {
            case '1':
                if (!in_array('document', $listNamesRoles)) {
                    throw new \yii\web\ForbiddenHttpException('У вас нет доступа к этой странице.');
                }
                continue;
            case "2":
                if (!in_array('common', $listNamesRoles)) {
                    throw new \yii\web\ForbiddenHttpException('У вас нет доступа к этой странице.');
                }
                continue;
            case "3":
                if (!in_array('edustandarts', $listNamesRoles)) {
                    throw new \yii\web\ForbiddenHttpException('У вас нет доступа к этой странице.');
                }
                continue;
            case "4":
                if (!in_array('paid_edu', $listNamesRoles)) {
                    throw new \yii\web\ForbiddenHttpException('У вас нет доступа к этой странице.');
                }
                continue;
            case "5":
                if (!in_array('grants', $listNamesRoles)) {
                    throw new \yii\web\ForbiddenHttpException('У вас нет доступа к этой странице.');
                }
                continue;
            case "6":
                if (!in_array('budget', $listNamesRoles)) {
                    throw new \yii\web\ForbiddenHttpException('У вас нет доступа к этой странице.');
                }
                continue;
            case "7":
                if (!in_array('education', $listNamesRoles)) {
                    throw new \yii\web\ForbiddenHttpException('У вас нет доступа к этой странице.');
                }
                continue;
            case "8":
                if (!in_array('objects', $listNamesRoles)) {
                    throw new \yii\web\ForbiddenHttpException('У вас нет доступа к этой странице.');
                }
            case "9":
                if (!in_array('inter', $listNamesRoles)) {
                    throw new \yii\web\ForbiddenHttpException('У вас нет доступа к этой странице.');
                }
            case "10":
                if (!in_array('catering', $listNamesRoles)) {
                    throw new \yii\web\ForbiddenHttpException('У вас нет доступа к этой странице.');
                }
        }
    }

}