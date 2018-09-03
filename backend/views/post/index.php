<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', ($post_type == 'posts') ? 'Posts' : 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="post-index">

    <div class="alert btn-area">
        <form action="">
            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <input type="hidden" value="<?= $post_type?>" name="post_type"/>
                <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Search in <?= $this->title?>"/>
            </div>
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', ('Create '.(($post_type == 'posts') ? 'Post' : 'Page'))), ['create','post_type'=>$post_type], ['class' => 'btn btn-primary']) ?>
        </form>

        <div class="clearfix"></div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title text-center" style="width: 50px"># </th>
                    <th class="column-title">Title </th>
                    <th class="column-title">Date</th>
                    <th class="column-title">Created On</th>
                    <th class="column-title">Last Updated On</th>
                    <th class="column-title">Created By</th>
                    <th class="column-title no-link last"><span class="nobr">Action</span>
                    </th>
                   
                </tr>
            </thead>

            <tbody>
                <?php foreach ($posts as $post){?>
                <tr class="even pointer">
                    <td>
                        <label class="checkbox-container"> 
                            <input type="checkbox"  name="posts[]" value="<?= $post->ID;?>"> <i></i>
                            <span class="checkmark"></span>
                        </label>
                    </td>
                    <td class=" "><a href="" class="post-title"><?= $post->post_title;?></a></td>
                    <td class=" "><?= $post->post_date;?></td>
                    <td class=" "><?= $post->created_on;?></td>
                    <td class=" "><?= $post->updated_on;?></td>
                    <td class=" "><?= $post->created_by;?></td>
                    <td class=" last">  <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', Url::to(['post/update', 'id' => $post->ID]), ['class' => '']) ?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>
