<?php
    require_once 'BaseService.php';
    require_once __DIR__ . '/../Dao/PaymentDao.php';

    class PaymentService extends BaseService{
        public function __construct(){
            $dao = new PaymentDao();
            parent::__construct($dao);
        }

        public function processPayment($data){
            if($data['amount'] <= 0){
                throw new Exception("Amount cannot be zero or less!");
            }

            $allowedPaymentMethods = ['cash', 'card', 'PayPal'];
            if(!in_array($data['payment_method'], $allowedPaymentMethods)){
                throw new Exception("The payment method is not allowed. Please try with the ones suggested!");
            }

            return $this->dao->insert($data);
        }
    }
?>