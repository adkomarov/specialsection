<?php
use yii\helpers\Html;
/** @var yii\web\View $this */
use app\modules\specialsection\assets\AppAsset;
use app\modules\specialsection\widgets\MenuSectionsWidget;
AppAsset::register($this);
$this->registerJsFile('//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
$this->registerJsFile('@module_specialsection_js/document.js');
$this->registerJsFile('@module_specialsection_js/education.js');
$this->registerCssFile('@module_specialsection_css/styles.css')
    ?>
<head>
    <title>Образование</title>
</head>

<body>
    <?= MenuSectionsWidget::widget(['type' => MenuSectionsWidget::TYPE_SELECT,'items'=> $menuItems]) ?>
    <input type="hidden" id="whatisurl" value=7>
    <h1>Образование</h1>
    <!--Сгенерированные сведения-->
    <form method="post" enctype="multipart/form-data">
        <?php
        $count_row = 0;
        $count_rows_tabels = 0;
        ?>
        <h4>Языки, на которых осуществляется образование (обучение)</h4>
        <?php if (isset($tabledata)) {
            foreach ($tabledata as $table) {
                if ($table["fieldsforms_id"] == 71 && $table["enabled"] == 1) { ?>
                    <div class="row oform_row temporarystyle" value=<?php echo $count_row ?>>
                        <input type="hidden" name="document[<?php echo $count_row ?>][]" value="<?php echo $table["position"] ?>">
                        <input type="hidden" name="document[<?php echo $count_row ?>][]" value=71>
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
                <div class="rightbuttonposition"><button type="button" id="add_row" class="btn btn-success" value=71>+
                        Добавить</button></div>
                <h4>Информация о численности обучающихся по реализуемым образовательным программам по источникам
                    финансирования</h4>
                <?php foreach ($tabledata as $table) {
                    if ($table["fieldsforms_id"] == 72 && $table["enabled"] == 1) { ?>
                        <div class="row oform_row temporarystyle" value=<?php echo $count_row ?>>
                            <input type="hidden" name="document[<?php echo $count_row ?>][]"
                                value="<?php echo $table["position"] ?>">
                            <input type="hidden" name="document[<?php echo $count_row ?>][]" value=72>
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
                    <div class="rightbuttonposition"><button type="button" id="add_row" class="btn btn-success" value=72>+
                            Добавить</button></div>
                    <h4>Информация о результатах приема</h4>
                    <?php foreach ($tabledata as $table) {
                        if ($table["fieldsforms_id"] == 73 && $table["enabled"] == 1) { ?>
                            <div class="row oform_row temporarystyle" value=<?php echo $count_row ?>>
                                <input type="hidden" name="document[<?php echo $count_row ?>][]"
                                    value="<?php echo $table["position"] ?>">
                                <input type="hidden" name="document[<?php echo $count_row ?>][]" value=73>
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
                                value=73>+
                                Добавить</button></div>
                        <h4>Информация о результатах перевода, восстановления и отчисления в форме электронного документа,
                            подписанного простой электронной подписью</h4>
                        <?php foreach ($tabledata as $table) {
                            if ($table["fieldsforms_id"] == 74 && $table["enabled"] == 1) { ?>
                                <div class="row oform_row temporarystyle" value=<?php echo $count_row ?>>
                                    <input type="hidden" name="document[<?php echo $count_row ?>][]"
                                        value="<?php echo $table["position"] ?>">
                                    <input type="hidden" name="document[<?php echo $count_row ?>][]" value=74>
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
                                value=74>+ Добавить</button></div>
                        <?php if (isset($tables)) { ?>
                            <h4>Информация о трудоустройстве выпускников для каждой реализуемой образовательной программы,
                                по которой состоялся выпуск</h4>
                            <?php foreach ($tables as $number => $row) {
                                if ($row["fieldsforms_id"] == 75) { ?>
                                    <input type="hidden" name="tableobj[<?php echo $number ?>][0][]"
                                        value="<?php echo $row["id"] ?>">
                                    <input type="hidden" name="tableobj[<?php echo $number ?>][0][]"
                                        value="<?php echo $row["fieldsforms_id"] ?>">
                                    <div class="row oform_row temporarystyle">
                                        <div class="col-sm-2"><label for="Code">Код</label>
                                            <input type="hidden" name="tableobj[<?php echo $number ?>][0][]"
                                                value="<?php echo $row["extraFields"][0]["id"] ?>">
                                            <input type="text" class="form-control margin_for_code" id="Code"
                                                name="tableobj[<?php echo $number ?>][0][]"
                                                value="<?php echo $row["extraFields"][0]["data"] ?>" required>
                                        </div>
                                        <div class="col-sm-3"><label for="NameProfession">Наименование профессии, специальности, в
                                                том числе научной, направления подготовки</label>
                                            <input type="hidden" name="tableobj[<?php echo $number ?>][0][]"
                                                value="<?php echo $row["extraFields"][1]["id"] ?>">
                                            <input type="text" class="form-control input_margin_top_whit_short_text"
                                                id="NameProfession" name="tableobj[<?php echo $number ?>][0][]"
                                                value="<?php echo $row["extraFields"][1]["data"] ?>" required>
                                        </div>
                                        <div class="col-sm-3"><label for="EducationalProgramme">Образовательная программа,
                                                направленность, профиль, шифр и наименование научной специальности</label>
                                            <input type="hidden" name="tableobj[<?php echo $number ?>][0][]"
                                                value="<?php echo $row["extraFields"][2]["id"] ?>">
                                            <input type="text" class="form-control input_margin_top_whit_short_text"
                                                id="EducationalProgramme" name="tableobj[<?php echo $number ?>][0][]"
                                                value="<?php echo $row["extraFields"][2]["data"] ?>">
                                        </div>
                                        <div class="col-sm-2"><label for="NumberGraduates">Численность выпускников прошлого учебного
                                                года</label>
                                            <input type="hidden" name="tableobj[<?php echo $number ?>][0][]"
                                                value="<?php echo $row["extraFields"][3]["id"] ?>">
                                            <input type="number" min="0" class="form-control input_margin_top_whit_short_text"
                                                id="NumberGraduates" name="tableobj[<?php echo $number ?>][0][]"
                                                value="<?php echo $row["extraFields"][3]["data"] ?>">
                                        </div>
                                        <div class="col-sm-2"><label for="NumberEmployed">Численность трудоустроенных выпускников
                                                прошлого учебного года</label>
                                            <input type="hidden" name="tableobj[<?php echo $number ?>][0][]"
                                                value="<?php echo $row["extraFields"][4]["id"] ?>">
                                            <input type="number" min="0" class="form-control input_margin_top_whit_long_text"
                                                id="NumberEmployed" name="tableobj[<?php echo $number ?>][0][]"
                                                value="<?php echo $row["extraFields"][4]["data"] ?>">
                                        </div>
                                        <button type="button" id="delrowtabel" class="btn btn-danger delbutton"
                                            value="<?php echo $row["id"] ?>" tabindex="-1">X</button>
                                    </div>
                                    <?php $count_rows_tabels++;
                                }
                            }
                        } ?>
                        <div class="rightbuttonposition"><button type="button" id="add_row_tabel"
                                class="btn btn-success" value=75>+
                                Добавить</button></div>
                        <div class="form-group" style="margin-top:10px;">
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                        </div>
                        <?php echo Html::hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), ['id' => "csfr"]) ?>
    </form>
    <input type="hidden" id="count_row" value=<?php echo $count_row ?>>
    <input type="hidden" id="count_rows_tabels" value=<?php echo $count_rows_tabels ?>>
    <h4>Информация о реализуемых образовательных программах, в том числе о реализуемыхадаптированных образовательных
        программах, с указанием в отношении каждой образовательной программы</h4>
    <table>
        <thead class="table-fixed-head">
            <tr>
                <td>Код профессии, специальности, направления подготовки, научной специальности</td>
                <td>Наименование профессии, специальности, направления подготовки, научной специальности</td>
                <td>Образовательная программа, направленность, профиль, шифр и наименование научной специальности</td>
                <td>Реализуемый уровень образования</td>
                <td>Форма обучения</td>
                <td>Нормативный срок обучения</td>
                <td>Срок действия государственной аккредитации образовательной программы (при наличии государственной
                    аккредитации)</td>
                <td>Учебные предметы, курсы, дисциплины (модули), предусмотренные соответствующей образовательной
                    программой</td>
                <td>Практики, предусмотренные соответствующей образовательной программой</td>
                <td>Информация об использовании при реализации образовательных программ электронного обучения и
                    дистанционных образовательных технологий</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="10">
                    <div class="content_alert alert-1c danger_oform">
                    <i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i>

                        <p>ВНИМАНИЕ !</p>
                        <p>Поля для этой таблицы выгружаются из 1C</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <h4>Информация о профессионально-общественной аккредитации образовательной программы (при наличии)</h4>
    <table>
        <thead class="table-fixed-head">
            <tr>
                <td>Код специальности, направления подготовки</td>
                <td>Наименование специальности, направления подготовки, научной специальности</td>
                <td>Уровень образования</td>
                <td>Образовательная программа, направленность, профиль, шифр и наименование научной специальности</td>
                <td>Наименование аккредитующей организации</td>
                <td>Срок действия профессионально-общественной аккредитации образовательной программы</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6">
                    <div class="content_alert alert-danger danger_oform">
                    <i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i>
                        <p>ВНИМАНИЕ !</p>
                        <p>Поля для этой таблицы внесены в шаблон</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <h4>Информация об общественной аккредитации образовательной программы</h4>
    <table>
        <thead class="table-fixed-head">
            <tr>
                <td>Код специальности, направления подготовки</td>
                <td>Наименование специальности, направления подготовки, научной специальности</td>
                <td>Уровень образования</td>
                <td>Образовательная программа, направленность, профиль, шифр и наименование научной специальности</td>
                <td>Наименование аккредитующей организации</td>
                <td>Срок действия профессионально-общественной аккредитации образовательной программы</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6">
                    <div class="content_alert alert-danger danger_oform">
                    <i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i>
                        <p>ВНИМАНИЕ !</p>
                        <p>Поля для этой таблицы внесены в шаблон</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <h4>Информация об образовательной программе</h4>
    <table>
        <thead class="table-fixed-head">
            <tr>
                <td>Код специальности, направления подготовки, шифр группы научных специальностей</td>
                <td>Наименование профессии, специальности, направления подготовки, наименование группы научных
                    специальностей</td>
                <td>Реализуемый уровень образования</td>
                <td>Образовательная программа, направленность, профиль, шифр и наименование научной специальности</td>
                <td>Форма обучения</td>
                <td>Ссылка на описание образовательной программы с приложением ее копии в виде электронного документа,
                    подписанного электронной подписью</td>
                <td>Ссылка на учебный план в виде электронного документа, подписанного электронной подписью</td>
                <td>Ссылки на рабочие программы (по каждой дисциплине в составе образовательной программы) в виде
                    электронного документа, подписанного электронной подписью</td>
                <td>Ссылка на календарный учебный график в виде электронного документа, подписанного электронной
                    подписью</td>
                <td>Рабочие программы практик, предусмотренных соответствующей образовательной программой в виде
                    электронного документа, подписанного электронной подписью</td>
                <td>Методические и иные документы, разработанные образовательной организацией для обеспечения
                    образовательного процесса, а также рабочие программы воспитания и календарные планы воспитательной
                    работы, включаемых в ООП в виде электронного документа, подписанного электронной подписью</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="11">
                    <div class="content_alert alert-1c danger_oform">
                    <i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i>
                        <p>ВНИМАНИЕ !</p>
                        <p>Поля для этой таблицы выгружаются из 1C</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <h4>Информация об адаптированной образовательной программе</h4>
    <table>
        <thead class="table-fixed-head">
            <tr>
                <td>Код специальности, направления подготовки, шифр группы научных специальностей</td>
                <td>Наименование специальности, направления подготовки</td>
                <td>Уровень образования</td>
                <td>Образовательная программа, направленность, профиль, шифр и наименование научной специальности</td>
                <td>Реализуемые формы обучения</td>
                <td>Описание образовательной программы с приложением ее копии в виде электронного документа,
                    подписанного электронной подписью</td>
                <td>Учебный план в виде электронного документа, подписанного электронной подписью</td>
                <td>Рабочие программы (по каждой дисциплине в составе образовательной программы) в виде электронного
                    документа, подписанного электронной подписью</td>
                <td>Календарный учебный график в виде электронного документа, подписанного электронной подписью</td>
                <td>Рабочие программы практик, предусмотренных соответствующей образовательной программой в виде
                    электронного документа, подписанного электронной подписью</td>
                <td>Методические и иные документы, разработанные образовательной организацией для обеспечения
                    образовательного процесса, а также рабочие программы воспитания и календарные планы воспитательной
                    работы, включаемых в ООП в виде электронного документа, подписанного электронной подписью</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="11">
                    <div class="content_alert alert-1c danger_oform">
                    <i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i>
                        <p>ВНИМАНИЕ !</p>
                        <p>Поля для этой таблицы выгружаются из 1C</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <h4>Информация о направлениях и результатах научной (научно-исследовательской) деятельности и
        научно-исследовательской базе для ее осуществления (для образовательных организаций высшего образования и
        организаций дополнительного профессионального образования)</h4>
    <table>
        <thead class="table-fixed-head">
            <tr>
                <td>Код специальности, направления подготовки, шифр группы научных специальностей</td>
                <td>Наименование профессии, специальности, направления подготовки, наименование группы научных
                    специальностей</td>
                <td>Перечень научных направлений, в рамках которых ведется научная (научно-исследовательская)
                    деятельность</td>
                <td>Образовательная программа, направленность, профиль, шифр и наименование научной специальности</td>
                <td>Уровень образования</td>
                <td>Название научного направления/научной школы</td>
                <td>Результаты научной (научно-исследовательской) деятельности</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7">
                    <div class="content_alert alert-1c danger_oform">
                    <i class="fa fa-eye-slash fa-2x" aria-hidden="true"></i>
                        <p>ВНИМАНИЕ !</p>
                        <p>Поля для этой таблицы выгружаются из 1C</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>
<!--Конец сведений-->