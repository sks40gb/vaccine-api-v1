<?php

namespace Ziletech\Models;

class ChargeModel {

    public $adminCharge;
    public $tdsCharge;
    
    
    function setAdminCharge($adminCharge) {
        $this->adminCharge = $adminCharge;
    }

    function setTdsCharge($tdsCharge) {
        $this->tdsCharge = $tdsCharge;
    }


}
