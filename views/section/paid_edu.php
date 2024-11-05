<?php
use yii\helpers\Html;
/** @var yii\web\View $this */
use app\modules\specialsection\assets\AppAsset;
use app\modules\specialsection\widgets\MenuSectionsWidget;
AppAsset::register($this);
$this->registerJsFile('//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
$this->registerJsFile('@module_specialsection_js/document.js');
$this->registerCssFile('@module_specialsection_css/styles.css')
    ?>

<head>
    <title>Образовательные стандарты и требования</title>
</head>

<body>
    <?= MenuSectionsWidget::widget(['type' => MenuSectionsWidget::TYPE_SELECT,'items'=> $menuItems]) ?>

    <input type="hidden" id="whatisurl" value=4>
    <h1>Образовательные стандарты и требования</h1>
    <!--Сгенерированные сведения-->
    <form method="post" enctype="multipart/form-data">
        <?php $count_row = 0; ?>
        <h4>Образец договора об оказании платных образовательных услуг</h4>
        <?php if (isset($tabledata)) {
            foreach ($tabledata as $table) {
                if ($table["fieldsforms_id"] == 1 && $table["enabled"] == 1) { ?>
                    <div class="row oform_row temporarystyle" value=<?php echo $count_row ?>>
                        <input type="hidden" name="document[<?php echo $count_row ?>][]" value="<?php echo $table["position"] ?>">
                        <input type="hidden" name="document[<?php echo $count_row ?>][]" value=1>
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
            }
            ?>
                <div class="rightbuttonposition"><button type="button" id="add_row" class="btn btn-success" value=1>+
                        Добавить</button></div>
                <h4>Документ об утверждении стоимости обучения по каждой образовательной программе в виде электронного
                    документа, подписанного электронной подписью</h4>
                <?php foreach ($tabledata as $table) {
                    if ($table["fieldsforms_id"] == 2 && $table["enabled"] == 1) { ?>
                        <div class="row oform_row temporarystyle" value=<?php echo $count_row ?>>
                            <input type="hidden" name="document[<?php echo $count_row ?>][]"
                                value="<?php echo $table["position"] ?>">
                            <input type="hidden" name="document[<?php echo $count_row ?>][]" value=2>
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
                ?>
                    <div class="rightbuttonposition"><button type="button" id="add_row" class="btn btn-success" value=2>+
                            Добавить</button></div>
                    <h4>Порядок оказания платных образовательных услуг в виде электронного документа, подписанного
                        электронной подписью</h4>
                    <?php foreach ($tabledata as $table) {
                        if ($table["fieldsforms_id"] == 3 && $table["enabled"] == 1) { ?>
                            <div class="row oform_row temporarystyle" value=<?php echo $count_row ?>>
                                <input type="hidden" name="document[<?php echo $count_row ?>][]"
                                    value="<?php echo $table["position"] ?>">
                                <input type="hidden" name="document[<?php echo $count_row ?>][]" value=3>
                                <div class="col-sm-11">
                                    <label for="document_purpose<?php echo $count_row ?>"> Комментарий</label>
                                    <input class="form-control" type="text" name="document[<?php echo $count_row ?>][]"
                                        placeholder="Устав; Локальный нормативный акт, регламентирующий режим занятий обучающихся и т.д."
                                        value="<?php echo $table["titel"] ?>" required><br>
                                    <?php if ($table["data"] == '') { ?>
                                        <div><label class="control-label" for="File<?php echo $count_row ?>">Документ для
                                                загрузки</label>
                                            <?php if (isset($position_wrong) && in_array($table["position"], $position_wrong)) { ?><input
                                                    type="file" id="File<?php echo $count_row ?>"
                                                    class="form-control file-loading wrong_file" name="document[<?php echo $count_row ?>]"
                                                    accept=".jpeg,.jpg,.png,.doc,.pdf,.csv,.xls">
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
                                                        class="form-control file-loading wrong_file"
                                                        name="document[<?php echo $count_row ?>]"
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
                                        <button type="button" id="hide_button" value='/delete_document'
                                            class="btn delbutton hidebutton" tabindex="-1"><i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                                <?php $count_row++;
                        }
                    }
                    ?>
                        <div class="rightbuttonposition"><button type="button" id="add_row" class="btn btn-success"
                                value=3>+
                                Добавить</button></div>
                        <h4>Документ об установлении размера платы, взимаемой с родителей (законных представителей) за
                            присмотр и уход за детьми, осваивающими образовательные программы дошкольного образования в
                            организациях, осуществляющих образовательную деятельность, за содержание детей в образовательной
                            организации, реализующей образовательные программы начального общего, основного общего или
                            среднего общего образования, если в такой образовательной организации созданы условия для
                            проживания обучающихся в интернате, либо за осуществление присмотра и ухода за детьми в группах
                            продленного дня в образовательной организации, реализующей образовательные программы начального
                            общего, основного общего или среднего общего образования в виде электронного документа,
                            подписанного электронной подписью</h4>
                        <?php foreach ($tabledata as $table) {
                            if ($table["fieldsforms_id"] == 4 && $table["enabled"] == 1) { ?>
                                <div class="row oform_row temporarystyle" value=<?php echo $count_row ?>>
                                    <input type="hidden" name="document[<?php echo $count_row ?>][]"
                                        value="<?php echo $table["position"] ?>">
                                    <input type="hidden" name="document[<?php echo $count_row ?>][]" value=4>
                                    <div class="col-sm-11">
                                        <label for="document_purpose<?php echo $count_row ?>"> Комментарий</label>
                                        <input class="form-control" type="text" name="document[<?php echo $count_row ?>][]"
                                            placeholder="Устав; Локальный нормативный акт, регламентирующий режим занятий обучающихся и т.д."
                                            value="<?php echo $table["titel"] ?>" required><br>
                                        <?php if ($table["data"] == '') { ?>
                                            <div><label class="control-label" for="File<?php echo $count_row ?>">Документ для
                                                    загрузки</label>
                                                <?php if (isset($position_wrong) && in_array($table["position"], $position_wrong)) { ?><input
                                                        type="file" id="File<?php echo $count_row ?>"
                                                        class="form-control file-loading wrong_file"
                                                        name="document[<?php echo $count_row ?>]"
                                                        accept=".jpeg,.jpg,.png,.doc,.pdf,.csv,.xls">
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
                                                            class="form-control file-loading wrong_file"
                                                            name="document[<?php echo $count_row ?>]"
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
                                            <button type="button" id="hide_button" value='/delete_document'
                                                class="btn delbutton hidebutton" tabindex="-1"><i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                    <?php $count_row++;
                            }
                        }
        } ?>
                        <div class="rightbuttonposition"><button type="button" id="add_row" class="btn btn-success"
                                value=4>+ Добавить</button></div>
                        <div class="form-group" style="margin-top:10px;">
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                        </div>
                        <?php echo Html::hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []) ?>
    </form>
    <input type="hidden" id="count_row" value=<?php echo $count_row ?>>
</body>
<!--Конец сведений-->