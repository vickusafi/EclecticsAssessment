<?php

use app\models\loans\Loans;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = 'Loan Details';
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
                                                <h3><?= $model->amount ?></h3>
                                                <p>Total Loaned Amount</p>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-bag"></i>
                                            </div>
                                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>



                                    <div class="col-lg-3 col-6">

                                        <div class="small-box bg-warning">
                                            <div class="inner">
                                                <h3><?= $loan_balance ?></h3>
                                                <p>Loan Balance</p>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-person-add"></i>
                                            </div>
                                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-6">

                                        <div class="small-box bg-danger">
                                            <div class="inner">
                                                <h3><?= $total_amount_paid ?></h3>
                                                <p>Loan Paid</p>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-pie-graph"></i>
                                            </div>
                                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <div class="col-xs-12">






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

<div class="modal fade show" id="modal-loan_limit">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">My loan Limit</h4>

            </div>
            <div class="modal-body modal-md" role="document" id="loan-limit-details">
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#add-new-loan').click(function() {
            $('#modal-loan_limit').modal('show')
                .find('#loan-details')
                .load($(this).attr('value'));
        });

        $('#check-loan-limit').click(function() {
            $('#modal-loan_application').modal('show')
                .find('#loan-limit-details')
                .load($(this).attr('value'));
        });
    });
</script>