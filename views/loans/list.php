<?php

use app\models\loans\Loans;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = 'My Loans';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= Html::encode($this->title) ?></h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <div class="card">

                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
                                <div class="row">
                                    <div class="col-lg-3 col-6">

                                        <div class="small-box bg-info">
                                            <div class="inner">
                                                <h3><?= $all_loans ?></h3>
                                                <p>Total Loaned Amount</p>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-bag"></i>
                                            </div>
                                            <a href="#" class="small-box-footer">More info <i
                                                    class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-6">

                                        <div class="small-box bg-success">
                                            <div class="inner">
                                                <h3>53</h3>
                                                <p>Loan Limit</p>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-stats-bars"></i>
                                            </div>
                                            <a href="#" class="small-box-footer">More info <i
                                                    class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>




                                </div>
                                <div class="card-body">
                                    <div class="col-xs-12">
                                        <?= Html::a('<i class="fa fa-eraser" aria-hidden="true"></i> Clear Form', ['list'], ['class' => 'btn btn-warning pull-right']);

                                        ?>
                                        <?= Html::button(
                                            '<i class="fa fa-plus" aria-hidden="true"></i> Apply',
                                            [
                                                'id' => 'apply-new-loan', 'class' => 'btn btn-primary float-right',
                                                'value' => Url::to(['loans/apply'])
                                            ]
                                        ); ?>
                                    </div>

                                    <br>
                                    <?=
                                    GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'filterModel' => $model,
                                        'pager' => [
                                            'class' => 'yii\bootstrap5\LinkPager'
                                        ],
                                        'tableOptions' => ['class' => 'table table-bordered'],
                                        'layout' => '
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    {items}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div style="text-indent: 0px;">
                                                    {summary}
                                                </div>
                                            <div class="col-xs-6">
                                            <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
                                                {pager}
                                            </div>
                                            </div>
                                            </div><br>
                                        ',
                                        'summary' => 'Showing <b>{begin}-{end}</b> of <b>{totalCount}</b> My Loans',
                                        'columns' => [

                                            [
                                                'label' => 'Loan ID',
                                                'format' => 'raw',
                                                'value' => function ($data) {
                                                    return Html::a(Html::encode($data->id), ['details', 'id' => $data->id], ['data-pjax' => 0]);
                                                },
                                                'filter' => "
                                                <div class='input-group input-group-sm col-md-12'>
                                                    " . Html::input('text', 'Loans[id]', $model->id, ['class' => 'form-control']) . "
                                                </div>
                                            ",

                                            ],
                                            [
                                                'label' => 'Loan Type',
                                                'format' => 'raw',
                                                'value' => function ($data) {
                                                    if (!empty($data->loanType)) {
                                                        return Html::encode($data->loanType->name);
                                                    }
                                                },
                                                'filter' => "
                                                <div class='input-group input-group-sm col-md-12'>
                                                    " . Html::input('text', 'Loans[loan_type_id]', $model->loan_type_id, ['class' => 'form-control']) . "
                                                </div>
                                            ",

                                            ],
                                            [
                                                'label' => 'Loaned Amount',
                                                'format' => 'text',
                                                'value' => function ($data) {
                                                    if (!empty($data->amount)) {
                                                        return Html::encode($data->amount);
                                                    }
                                                    return '';
                                                },
                                                'filter' => "
                                                <div class='input-group input-group-sm col-md-12'>
                                                    " . Html::input('text', 'Loans[amount]', $model->amount, ['class' => 'form-control']) . "
                                                </div>
                                                ",


                                            ],

                                            [
                                                'label' => 'Interest Rate',
                                                'format' => 'text',
                                                'value' => function ($data) {
                                                    if (!empty($data->loanType)) {
                                                        return Html::encode($data->loanType->interest_rate);
                                                    }
                                                    return '';
                                                },
                                                'filter' => "
                                                <div class='input-group input-group-sm col-md-12'>
                                                    " . Html::input('text', 'Loans[interest_rate]', $model->interest_rate, ['class' => 'form-control']) . "
                                                </div>
                                                ",


                                            ],


                                            [
                                                'label' => 'Loan Due Amount',
                                                'format' => 'text',
                                                'value' => function ($data) {
                                                    $loan = new Loans();
                                                    if (!empty($data)) {
                                                        $loan_to_be_paid = $loan->calculateTotalLoanAmountToBePaid($data->amount, $data->loanType->interest_rate);
                                                        if (!empty($loan_to_be_paid)) {
                                                            return round($loan_to_be_paid, 2);
                                                        }
                                                        return '0.00';
                                                    }
                                                    return '';
                                                },
                                                'filter' => "
                                                <div class='input-group input-group-sm col-md-12'>
                                                    " . Html::input('text', 'Loans[interest_rate]', $model->interest_rate, ['class' => 'form-control']) . "
                                                </div>
                                                ",


                                            ],

                                            [
                                                'label' => 'Applied Date',
                                                'format' => 'text',
                                                'value' => function ($data) {
                                                    if (!empty($data->cdate)) {
                                                        return date('Y-m-d H:i', strtotime($data->cdate));
                                                    }
                                                    return '';
                                                },
                                                'filter' => "
                                                <div class='input-group input-group-sm col-md-12'>
                                                    " . Html::input('text', 'Loans[interest_rate]', $model->interest_rate, ['class' => 'form-control']) . "
                                                </div>
                                                ",


                                            ],

                                            [
                                                'label' => 'Action',
                                                'format' => 'raw',
                                                'contentOptions' => ['class' => 'project-actions text-right', 'style' => 'width: 20%'],
                                                'value' => function ($data) {
                                                    return '
                                                        ' . Html::a('<i class="fas fa-pencil-alt"></i> Repayment Schedule', ['paymentschedule', 'id' => $data->id], ['class' => 'btn btn-warning btn-sm']) . '
                                                        ' . Html::button('<i class="fas fa-folder"></i> Pay', ['id' => 'loan-payment', 'class' => 'btn btn-success btn-sm', 'value' => Url::to(['loans/repayment', 'id' => $data->id])]) . '
                                                    ';
                                                },
                                            ],
                                        ],
                                    ]);
                                    ?>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- /.modal to apply for a loan-->
<div class="modal fade show" id="modal-loan_application">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Apply for a loan</h4>

            </div>
            <div class="modal-body modal-md" role="document" id="loan-details">
            </div>
        </div>
    </div>
</div>

<!-- /.modal to pay for a loan-->
<div class="modal fade show" id="modal-loan_payment">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- <div class="modal-header bg-primary">
                <h4 class="modal-title">Loan Repayment Checkout</h4>
            </div> -->
            <div class="modal-body modal-md" role="document" id="loan-payment-details">
            </div>
        </div>
    </div>
</div>



<script>
$(function() {
    $('#apply-new-loan').click(function() {
        $('#modal-loan_application').modal('show')
            .find('#loan-details')
            .load($(this).attr('value'));
    });

    //loan payment
    $('#loan-payment').click(function() {
        $('#modal-loan_payment').modal('show')
            .find('#loan-payment-details')
            .load($(this).attr('value'));
    });


});
</script>