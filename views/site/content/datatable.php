<?php

use yii\data\Pagination;
use yii\widgets\LinkPager; ?>


<?php if(count($data) > 0): ?>
    <?php
    $kI = 0;
    $keys = $data[0]

    ?>

    <div class="row animate__animated animate__bounceInLeft" id="report__datatable__table">
        <table class="table table-striped" style="background: #fff">
            <tr>
                <?php foreach (array_keys($data[0]) as $key): ?>
                <?php
                    switch ($key) {
                        case 'name':
                            $key = 'Тема лабораторной';
                            break;
                        case 'week':
                            $key = 'Неделя';
                            break;
                    }
                    ?>
                    <th data-name="<?=$key?>">
                        <?=$key?>
                    </th>
                <?php endforeach; ?>
            </tr>
            <?php foreach ($data as $row): ?>
                <tr>
                    <?php foreach ($row as $field): ?>
                        <td><?=$field?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php else: ?>
    <div class="row">
        <div class="col-sm-12">
            <h3>Данные отсутствуют</h3>
        </div>
    </div>
<?php endif; ?>
