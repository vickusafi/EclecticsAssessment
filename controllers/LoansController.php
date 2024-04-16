<?php

namespace app\controllers;

use app\models\loans\LoanPayment;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\helpers\ArrayHelper;

use kartik\mpdf\Pdf;

//models
use app\models\loans\Loans;
use app\models\loans\LoanTypes;

class LoansController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['list', 'apply', 'loanlimit', 'paymentschedule'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['details', 'repayment'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' =>
                        // Verify if user has access to this action
                        function ($rule, $action) {
                            $loan = Loans::find()->where('id=:id', [':id' => Yii::$app->request->get('id')])->limit(1)->one();
                            if (!empty($loan)) {

                                return true;
                            }
                            return false;
                        }
                    ],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /*
    * Set default layout for main
    */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        #defualt layout for loans controller
        $this->layout = 'main';

        return true;
    }

    public function actionList()
    {
        $model = new Loans();
        $model->scenario = 'search';
        //get all loans a user has ever asked forr
        $loans_for_a_user = $model->getTotalLoansForAuser();
        $model->load(Yii::$app->request->get());
        if ($model->validate()) {
            return $this->render('list', [
                'dataProvider' => $model->search(),
                'model' => $model,
                'all_loans' => $loans_for_a_user
            ]);
        }
    }

    public function actionApply()
    {
        $model = new Loans();
        $loan_types = new LoanTypes();
        $all_loan_types = $loan_types->getLoanTypes();
        $model->scenario = 'add';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->applyForLoan()) {
                    Yii::$app->getSession()->setFlash('success', 'You have successfully applied for a new Loan');
                    return $this->redirect(['list']);
                }
                Yii::$app->getSession()->setFlash('error', 'There was an error while applying for a loan');
            }
            $errors  = json_encode($model->getFirstErrors());
            Yii::$app->getSession()->setFlash('error', !empty($errors) ? $errors : 'Error While applying for  a new loan');
            return $this->redirect(['list']);
        }
        return $this->renderAjax('apply', [
            'model' => $model,
            'loan_types' => empty($all_loan_types) ? [] : ArrayHelper::map($all_loan_types, 'id', 'name'),
        ]);
    }
    public function actionPaymentschedule()
    {
        $model = Loans::find()->where(['id' => Yii::$app->request->get('id')])->limit(1)->one();
        if (empty($model)) {
            Yii::$app->getSession()->setFlash('error', 'Selected Loan Details do not exist');
            return $this->redirect(['list']);
        }
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('payment_schedule', ['model' => $model]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['Krajee Report Header'],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionDetails()
    {
        $model = Loans::find()->where(['id' => Yii::$app->request->get('id')])->limit(1)->one();
        if (empty($model)) {
            Yii::$app->getSession()->setFlash('error', 'Selected Loan Details do not exist');
            return $this->redirect(['list']);
        }
        $loan_payment = new LoanPayment();
        $loan_balance = $loan_payment->loanBalance($model->id);
        $total_amount_paid = $loan_payment->getTotalLoanPaid($model->id);
        return $this->render('details', [
            'model' => $model,
            'loan_balance' => $loan_balance,
            'total_amount_paid' => $total_amount_paid
        ]);
    }

    public function actionRepayment()
    {
        $model = Loans::find()->where(['id' => Yii::$app->request->get('id')])->limit(1)->one();
        if (empty($model)) {
            Yii::$app->getSession()->setFlash('error', 'Selected Loan Details do not exist');
            return $this->redirect(['list']);
        }

        return $this->renderPartial('repayment', [
            'model' => $model,

        ]);
    }
}
