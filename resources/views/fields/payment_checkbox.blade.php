@php
    $allow_payments = false;
    $allow_credit_payments = false;

    if($action === "edit") {
        $allow_payments = (bool)$entry->allow_payments;
        $allow_credit_payments = (bool)$entry->allow_credit_payments;
    }
@endphp

<div class="form-group col-sm-12">
    <input type="checkbox" id='payment_checkbox' name="allow_payments" {{ $allow_payments? "checked" : '' }}> &nbsp; Allow Payments on account <br/>
    <input type="checkbox" id='credit_payment_checkbox' name="allow_credit_payments" {{ $allow_payments? '' : "disabled" }} {{ $allow_credit_payments? "checked" : '' }}> &nbsp; Allow credits in payments
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script>

    $('#payment_checkbox').click(function(){
        if($(this).prop('checked')) {
            $('#credit_payment_checkbox').removeAttr('disabled');
        } else {
            $('#credit_payment_checkbox').attr('disabled', 'disabled');
        }
    });


</script>
