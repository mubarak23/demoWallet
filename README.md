Demo Wallet Edpoint

1.  Create Account
    URL: /api/v1/account
    payload: {
    "first_name": "Demo",
    "last_name": "Account",
    "account_type": "saving",
    "branch": "area 1"
    }
    Response: {
    "message": "Client Account Created Successfully",
    "data": {
    "first_name": "Demo",
    "last_name": "Account",
    "account_type": "saving",
    "branch": "area 1",
    "\_account_balance": "0.00",
    "account_no": 5901534443,
    "updated_at": "2021-09-20T14:38:24.000000Z",
    "created_at": "2021-09-20T14:38:24.000000Z",
    "id": 5
    }
    }

2.  Credit Account
    URL: /api/v1/credit_account
    Payload: {
    "account_no": 7715050794,
    "amount": 4000,
    "txn_type": "credit"
    }

        Response : {

    "message": "Account Credited Successfully",
    "data": {
    "txn_type": "Credit",
    "amount": 4000,
    "account_no": 7715050794,
    "reference": "976c47f7-41e6-4fad-b8c7-562ca67b8585",
    "balance_before": null,
    "balance_after": 4000,
    "metadata": 7715050794,
    "updated_at": "2021-09-20T15:02:11.000000Z",
    "created_at": "2021-09-20T15:02:11.000000Z",
    "id": 1
    }
    }
