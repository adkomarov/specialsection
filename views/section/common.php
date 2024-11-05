<?php
use yii\helpers\Html;
/** @var yii\web\View $this */
use app\modules\specialsection\assets\AppAsset;
use app\modules\specialsection\widgets\MenuSectionsWidget;
AppAsset::register($this);
$this->registerJsFile('//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
$this->registerCssFile('@module_specialsection_css/styles.css');
$this->registerJsFile('@module_specialsection_js/document.js');
?>

<head>
    <title>Основные сведения</title>
</head>

<body>
    <?= MenuSectionsWidget::widget(['type' => MenuSectionsWidget::TYPE_SELECT,'items'=> $menuItems]) ?>
    <input type="hidden" id="whatisurl" value=2>
    <h1>Основные сведения</h1>
    <table>
        <tbody>
            <tr>
                <td>
                    Полное наименование образовательной организации
                </td>
                <td rowspan="9">
                    <div class="content_alert alert-danger danger_oform">
                        <i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i>
                        <p>ВНИМАНИЕ !</p>
                        <p>Поля для этой таблицы внесены в шаблон</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    Сокращенное (при наличии) наименование образовательной организации
                </td>
            </tr>
            <tr>
                <td>
                    Дата создания образовательной организации
                </td>
            </tr>
            <tr>
                <td>
                    Адрес местонахождения образовательной организации
                </td>
            </tr>
            <tr>
                <td>
                    Филиалы образовательной организации
                </td>
            </tr>
            <tr>
                <td>
                    Представительства образовательной организации
                </td>

            </tr>
            <tr>
                <td>
                    Режим, график работы
                </td>
            </tr>
            <tr>
                <td>
                    Контактные телефоны
                </td>
            </tr>
            <tr>
                <td>
                    Адреса электронной почты
                </td>
            </tr>
        </tbody>
    </table>
    <?php
    $count_row = 0;
    $phone = false;
    $email = false;
    $website = false;
    ?>
    <form method="post" enctype="multipart/form-data">
        <h4>Сведения о каждом учредителе образовательной организации</h4>
        <?php if (isset($datarows) && !empty($datarows)) { ?>
            <div class="row oform_row temporarystyle">
                <input type="hidden" name="common[0][0][]" value="<?php echo $datarows[0]["id"] ?>">
                <input type="hidden" name="common[0][0][]" value=24>
                <div class="col-sm-3"><label for="NameFounderEduOrganization">Наименование учредителя образовательной
                        организации</label><input type="text" class="form-control label_text"
                        id="NameFounderEduOrganization" name="common[0][0][]"
                        placeholder="Наименование учредителя образовательной организации" required
                        value="<?php echo $datarows[0]["titel"] ?>"></div>
                <div class="col-sm-2"><label for="LegaLaddressFounder">Юридический адрес учредителя</label><input
                        type="text" class="form-control label_text" id="LegaLaddressFounder" name="common[0][0][]"
                        placeholder="Юридический адрес учредителя" required value="<?php echo $datarows[0]["data"]; ?>">
                </div>
                <?php if (isset($datarows[0]["extraFields"]) && !empty($datarows[0]["extraFields"])) {
                    foreach ($datarows[0]["extraFields"] as $exrafield) {
                        if ($exrafield["type"] == "phone") {
                            $phone = true; ?>
                            <div class="col-sm-2"><label for="ContactTelephoneNumbers">Контактные телефоны</label>
                                <input type="text" class="form-control input_margin_extra_phone" id="ContactTelephoneNumbers"
                                    name="common[0][1][]" placeholder="Контактные телефоны" value="<?php echo $exrafield["data"] ?>">
                            </div>
                        <?php }
                    }
                    if (!$phone) {
                        $phone = true; ?>
                        <div class="col-sm-2"><label for="ContactTelephoneNumbers">Контактные телефоны</label>
                            <input type="text" class="form-control input_margin_extra_phone" id="ContactTelephoneNumbers"
                                name="common[0][1][]" placeholder="Контактные телефоны">
                        </div>
                    <?php }
                    foreach ($datarows[0]["extraFields"] as $exrafield) {
                        if ($exrafield["type"] == "email") {
                            $email = true; ?>
                            <div class="col-sm-2"><label for="EmailAddress">Адрес электронной почты</label>
                                <input type="email" class="form-control input_margin_extra" id="EmailAddress" name="common[0][2][]"
                                    placeholder="Адрес электронной почты" value="<?php echo $exrafield["data"] ?>">
                            </div>
                        <?php }
                    }
                    if (!$email) {
                        $email = true; ?>
                        <div class="col-sm-2"><label for="EmailAddress">Адрес электронной почты</label>
                            <input type="email" class="form-control input_margin_extra" id="EmailAddress" name="common[0][2][]"
                                placeholder="Адрес электронной почты">
                        </div>
                    <?php }
                    foreach ($datarows[0]["extraFields"] as $exrafield) {
                        if ($exrafield["type"] == "website") {
                            $website = true; ?>
                            <div class="col-sm-3"><label for="WebsiteAddress">Адрес сайта учредителя в сети «Интернет»</label>
                                <input type="url" class="form-control input_margin_extra" id="WebsiteAddress" name="common[0][3][]"
                                    placeholder="Адрес сайта учредителя в сети «Интернет»" value="<?php echo $exrafield["data"] ?>">
                            </div>
                        <?php }
                    }
                    if (!$website) {
                        $website = true; ?>
                        <div class="col-sm-3"><label for="WebsiteAddress">Адрес сайта учредителя в сети «Интернет»</label>
                            <input type="url" class="form-control input_margin_extra" id="WebsiteAddress" name="common[0][3][]"
                                placeholder="Адрес сайта учредителя в сети «Интернет»">
                        </div>
                    <?php }
                }
                if (!$phone) { ?>
                    <div class="col-sm-2"><label for="ContactTelephoneNumbers">Контактные телефоны</label>
                        <input type="text" class="form-control input_margin_extra_phone" id="ContactTelephoneNumbers"
                            name="common[0][1][]" placeholder="Контактные телефоны">
                    </div>
                <?php }
                if (!$email) { ?>
                    <div class="col-sm-2"><label for="EmailAddress">Адрес электронной почты</label>
                        <input type="email" class="form-control input_margin_extra" id="EmailAddress" name="common[0][2][]"
                            placeholder="Адрес электронной почты">
                    </div>
                <?php }
                if (!$website) { ?>
                    <div class="col-sm-3"><label for="WebsiteAddress">Адрес сайта учредителя в сети «Интернет»</label>
                        <input type="url" class="form-control input_margin_extra" id="WebsiteAddress" name="common[0][3][]"
                            placeholder="Адрес сайта учредителя в сети «Интернет»">
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="row oform_row temporarystyle">
                <input type="hidden" name="common[0][0][]" value=0>
                <input type="hidden" name="common[0][0][]" value=24>
                <div class="col-sm-3"><label for="NameFounderEduOrganization">Наименование учредителя образовательной
                        организации</label><input type="text" class="form-control label_text"
                        id="NameFounderEduOrganization" name="common[0][0][]"
                        placeholder="Наименование учредителя образовательной организации" required></div>
                <div class="col-sm-2"><label for="LegaLaddressFounder">Юридический адрес учредителя</label><input
                        type="text" class="form-control label_text" id="LegaLaddressFounder" name="common[0][0][]"
                        placeholder="Юридический адрес учредителя" required></div>
                <div class="col-sm-2"><label for="ContactTelephoneNumbers">Контактные телефоны</label>
                    <input type="text" class="form-control input_margin_extra_phone" id="ContactTelephoneNumbers"
                        name="common[0][1][]" placeholder="Контактные телефоны">
                </div>
                <div class="col-sm-2"><label for="EmailAddress">Адрес электронной почты</label>
                    <input type="email" class="form-control input_margin_extra" id="EmailAddress" name="common[0][2][]"
                        placeholder="Адрес электронной почты">
                </div>
                <div class="col-sm-3"><label for="WebsiteAddress">Адрес сайта учредителя в сети «Интернет»</label>
                    <input type="url" class="form-control input_margin_extra" id="WebsiteAddress" name="common[0][3][]"
                        placeholder="Адрес сайта учредителя в сети «Интернет»">
                </div>
            </div>
        <?php } ?>
        <h4>Лицензия на осуществление образовательной деятельности</h4>
        <?php if (isset($tabledata)) {
            foreach ($tabledata as $table) {
                if ($table["fieldsforms_id"] == 25 && $table["enabled"] == 1) { ?>
                    <div class="row oform_row temporarystyle" value=<?php echo $count_row ?>>
                        <input type="hidden" name="document[<?php echo $count_row ?>][]" value="<?php echo $table["position"] ?>">
                        <input type="hidden" name="document[<?php echo $count_row ?>][]" value=25>
                        <div class="col-sm-11">
                            <label for="document_purpose<?php echo $count_row ?>"> Комментарий</label>
                            <input class="form-control" type="text" name="document[<?php echo $count_row ?>][]"
                                placeholder="Устав; Локальный нормативный акт, регламентирующий режим занятий обучающихся и т.д."
                                value="<?php echo $table["titel"] ?>" required><br>
                            <?php if ($table["data"] == '') { ?>
                                <div><label class="control-label" for="File<?php echo $count_row ?>">Документ для
                                        загрузки</label>
                                    <?php if (isset($position_wrong) && in_array($table["position"], $position_wrong)) { ?><input
                                            type="file" id="File<?php echo $count_row ?>" class="form-control file-loading wrong_file"
                                            name="document[<?php echo $count_row ?>]" accept=".jpeg,.jpg,.png,.doc,.pdf,.csv,.xls">
                                    <?php } else { ?><input type="file" id="File<?php echo $count_row ?>"
                                            class="form-control file-loading" name="document[<?php echo $count_row ?>]"
                                            accept=".jpeg,.jpg,.png,.doc,.pdf,.csv,.xls"><?php } ?>
                                <?php } else { ?>
                                    <div class="labeloform"><a class="colorhref" target="_blank"
                                            href="<?php echo $table["data"] ?>">Ссылка на загруженный
                                            файл</a></div>
                                    <div style="margin-top:20px;"><label class="control-label"
                                            for="File<?php echo $count_row ?>">Заменить загруженный файл с сохранением ссылки</label>
                                        <?php if (isset($position_wrong) && in_array($table["position"], $position_wrong)) { ?><input
                                                type="file" id="File<?php echo $count_row ?>" class="form-control file-loading wrong_file"
                                                name="document[<?php echo $count_row ?>]" accept=".jpeg,.jpg,.png,.doc,.pdf,.csv,.xls">
                                        <?php } else { ?><input type="file" id="File<?php echo $count_row ?>"
                                                class="form-control file-loading" name="document[<?php echo $count_row ?>]"
                                                accept=".jpeg,.jpg,.png,.doc,.pdf,.csv,.xls"><?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <div>
                                <button type="button" id="delrow" class="btn btn-danger delbutton" tabindex="-1"
                                    value='/delete_document'>X</button>
                                <button type="button" id="hide_button" value='/delete_document' class="hidebutton btn delbutton"
                                    tabindex="-1" style="background-color: #f5f5f5;"><i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        <?php $count_row++;
                }
            } ?>
                <div class="rightbuttonposition"><button type="button" id="add_row" class="btn btn-success" value=25>+
                        Добавить</button></div>
                <h4>Государственная аккредитация образовательной деятельности по реализуемым образовательным программам</h4>
                <?php foreach ($tabledata as $table) {
                    if ($table["fieldsforms_id"] == 26 && $table["enabled"] == 1) { ?>
                        <div class="row oform_row temporarystyle" value=<?php echo $count_row ?>>
                            <input type="hidden" name="document[<?php echo $count_row ?>][]"
                                value="<?php echo $table["position"] ?>">
                            <input type="hidden" name="document[<?php echo $count_row ?>][]" value=25>
                            <div class="col-sm-11">
                                <label for="document_purpose<?php echo $count_row ?>"> Комментарий</label>
                                <input class="form-control" type="text" name="document[<?php echo $count_row ?>][]"
                                    placeholder="Устав; Локальный нормативный акт, регламентирующий режим занятий обучающихся и т.д."
                                    value="<?php echo $table["titel"] ?>" required><br>
                                <?php if ($table["data"] == '') { ?>
                                    <div><label class="control-label" for="File<?php echo $count_row ?>">Документ для
                                            загрузки</label>
                                        <?php if (isset($position_wrong) && in_array($table["position"], $position_wrong)) { ?><input
                                                type="file" id="File<?php echo $count_row ?>" class="form-control file-loading wrong_file"
                                                name="document[<?php echo $count_row ?>]" accept=".jpeg,.jpg,.png,.doc,.pdf,.csv,.xls">
                                        <?php } else { ?><input type="file" id="File<?php echo $count_row ?>"
                                                class="form-control file-loading" name="document[<?php echo $count_row ?>]"
                                                accept=".jpeg,.jpg,.png,.doc,.pdf,.csv,.xls"><?php } ?>
                                    <?php } else { ?>
                                        <div class="labeloform"><a class="colorhref" target="_blank"
                                                href="<?php echo $table["data"] ?>">Ссылка на загруженный
                                                файл</a></div>
                                        <div style="margin-top:20px;"><label class="control-label"
                                                for="File<?php echo $count_row ?>">Заменить загруженный файл с сохранением ссылки</label>
                                            <?php if (isset($position_wrong) && in_array($table["position"], $position_wrong)) { ?><input
                                                    type="file" id="File<?php echo $count_row ?>"
                                                    class="form-control file-loading wrong_file" name="document[<?php echo $count_row ?>]"
                                                    accept=".jpeg,.jpg,.png,.doc,.pdf,.csv,.xls">
                                            <?php } else { ?><input type="file" id="File<?php echo $count_row ?>"
                                                    class="form-control file-loading" name="document[<?php echo $count_row ?>]"
                                                    accept=".jpeg,.jpg,.png,.doc,.pdf,.csv,.xls"><?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" id="delrow" class="btn btn-danger delbutton" tabindex="-1"
                                        value='/delete_document'>X</button>
                                    <button type="button" id="hide_button" value='/delete_document' class="btn delbutton hidebutton"
                                        tabindex="-1"><i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <?php $count_row++;
                    }
                }
        } ?>
                <div class="rightbuttonposition"><button type="button" id="add_row" class="btn btn-success" value=26>+
                        Добавить</button></div>
                <div class="form-group" style="margin-top:10px;">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php echo Html::hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []) ?>
    </form>
    <input type="hidden" id="count_row" value=<?php echo $count_row ?>>
    <h4>Места осуществления образовательной деятельности при использовании сетевой формы реализации образовательных
        программ</h4>
    <table>
        <thead class="table-fixed-head">
            <tr>
                <td>№ <nobr>п/п</nobr>
                </td>
                <td>Адрес места осуществления образовательной деятельности</td>
            </tr>
        </thead>
        <tbody>
            <tr itemprop="addressPlaceSet">
                <td colspan="2">
                    <div class="content_alert alert-danger danger_oform">
                        <i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i>
                        <p>ВНИМАНИЕ !</p>
                        <p>Поля для этой таблицы внесены в шаблон</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <h4>Места проведения практики</h4>
    <table>
        <thead class="table-fixed-head">
            <tr>
                <td>№ <nobr>п/п</nobr>
                </td>
                <td>Адрес места осуществления образовательной деятельности</td>
            </tr>
        </thead>
        <tbody>
            <tr itemprop="addressPlaceSet">
                <td colspan="2">
                    <div class="content_alert alert-1c danger_oform">
                    <i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i>

                        <p>ВНИМАНИЕ !</p>
                        <p>Поля для этой таблицы выгружаются из 1C</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <h4>Места проведения практической подготовки обучающихся</h4>
    <table>
        <thead class="table-fixed-head">
            <tr>
                <td>№ <nobr>п/п</nobr>
                </td>
                <td>Адрес места осуществления образовательной деятельности</td>
            </tr>
        </thead>
        <tbody>
            <tr itemprop="addressPlaceSet">
                <td colspan="2">
                    <div class="content_alert alert-danger danger_oform">
                        <i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i>
                        <p>ВНИМАНИЕ !</p>
                        <p>Поля для этой таблицы внесены в шаблон</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <h4>Места проведения государственной итоговой аттестации</h4>
    <table>
        <thead class="table-fixed-head">
            <tr>
                <td>№ <nobr>п/п</nobr>
                </td>
                <td>Адрес места осуществления образовательной деятельности</td>
            </tr>
        </thead>
        <tbody>
            <tr itemprop="addressPlaceSet">
                <td colspan="2">
                    <div class="content_alert alert-danger danger_oform">
                        <i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i>
                        <p>ВНИМАНИЕ !</p>
                        <p>Поля для этой таблицы внесены в шаблон</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <h4>Места осуществления образовательной деятельности по дополнительным образовательным программам</h4>
    <table>
        <thead class="table-fixed-head">
            <tr>
                <td>№ <nobr>п/п</nobr>
                </td>
                <td>Адрес места осуществления образовательной деятельности</td>
            </tr>
        </thead>
        <tbody>
            <tr itemprop="addressPlaceSet">
                <td colspan="2">
                    <div class="content_alert alert-danger danger_oform">
                        <i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i>
                        <p>ВНИМАНИЕ !</p>
                        <p>Поля для этой таблицы внесены в шаблон</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <h4>Места осуществления образовательной деятельности по основным программам профессионального обучения</h4>
    <table>
        <thead class="table-fixed-head">
            <tr>
                <td>№ <nobr>п/п</nobr>
                </td>
                <td>Адрес места осуществления образовательной деятельности</td>
            </tr>
        </thead>
        <tbody>
            <tr itemprop="addressPlaceSet">
                <td colspan="2">
                    <div class="content_alert alert-danger danger_oform">
                        <i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i>
                        <p>ВНИМАНИЕ !</p>
                        <p>Поля для этой таблицы внесены в шаблон</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>