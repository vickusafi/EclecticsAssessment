<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }
</style>

<h2>Loan Repayment Schedule for User: <?= Yii::$app->user->identity->full_name ?></h2>

<table>
    <thead>
        <tr>
            <th>Month</th>
            <th>Payment Amount (KSH)</th>
            <th>Principal Paid (KSH)</th>
            <th>Interest Paid (KSH)</th>
            <th>Remaining Balance (KSH)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>500</td>
            <td>300</td>
            <td>200</td>
            <td>4700</td>
        </tr>
        <tr>
            <td>2</td>
            <td>500</td>
            <td>305</td>
            <td>195</td>
            <td>4395</td>
        </tr>
        <tr>
            <td>3</td>
            <td>500</td>
            <td>310</td>
            <td>190</td>
            <td>4085</td>
        </tr>
    </tbody>
</table>