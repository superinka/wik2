<?php echo validation_errors(); ?>
<form class="form-horizontal" role="form" action="" method="POST">
<button class="btn btn-white btn-default btn-round add_field_button">
    <i class="ace-icon fa fa-plus-circle blue"></i>
    Thêm
</button>


<button class="btn btn-white btn-default btn-round" type="submit">SUBMIT</button>



    <div class="input_fields_wrap">
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Chọn Danh Mục Câu Hỏi </label>

            <div class="col-sm-4">
                <?php echo $html ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 col-xs-12 control-label no-padding-right" for="form-field-1"> Câu hỏi 1 </label>

            <div class="col-md-9 col-xs-12">
                <input type="text" id="form-field-0" name="q1" placeholder="Câu hỏi" class="col-md-10" required />
            </div>
            <label class="col-md-3 col-xs-12 control-label no-padding-right" for="form-field-1"> Random Code </label>

            <div class="col-md-9 col-xs-12" style="padding-top:5px;">
                <input type="text" id="form-field-0" value="<?=generateRandomString(5)?>" name="code1" placeholder="Random Code" class="col-md-3" required />
                <div class="col-md-3">
                    <div class="staticParent">
                        <label>
                            <input id="spinner0" class="child" name="point1" value="1" type="text"/>
                            <span class="lbl"></span>
                        </label>
                    </div>
                </div>
            </div>
            <label class="col-md-3 col-xs-12 control-label no-padding-right" for="form-field-1"> Đáp án </label>

            <div class="col-md-9 col-xs-12">
                <input type="text" id="form-field-1" name="a11" placeholder="Đáp án 1" class="col-md-8" />
                <div class="checkbox col-md-2">
                    <label>
                        <input name="c11" class="ace ace-checkbox-2" type="checkbox" />
                        <span class="lbl"> Đúng</span>
                    </label>
                </div>
                <input type="text" id="form-field-2" name="a12" placeholder="Đáp án 2" class="col-md-8" />
                <div class="checkbox col-md-2">
                    <label>
                        <input name="c12" class="ace ace-checkbox-2" type="checkbox" />
                        <span class="lbl"> Đúng</span>
                    </label>
                </div>
                <input type="text" id="form-field-3" name="a13" placeholder="Đáp án 3" class="col-md-8" />
                <div class="checkbox col-md-2">
                    <label>
                        <input name="c13" class="ace ace-checkbox-2" type="checkbox" />
                        <span class="lbl"> Đúng</span>
                    </label>
                </div>
                <input type="text" id="form-field-4" name="a14" placeholder="Đáp án 4" class="col-md-8" />
                <div class="checkbox col-md-2">
                    <label>
                        <input name="c14" class="ace ace-checkbox-2" type="checkbox" />
                        <span class="lbl"> Đúng</span>
                    </label>
                </div>
            </div>
        </div>

        <hr/>
    </div>
</form>

<script>
function randomString(len, charSet) {
    charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var randomString = '';
    for (var i = 0; i < len; i++) {
        var randomPoz = Math.floor(Math.random() * charSet.length);
        randomString += charSet.substring(randomPoz,randomPoz+1);
    }
    return randomString;
}

$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    $('.staticParent').on('keydown', '.child', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||(/65|67|86|88/.test(e.keyCode)&&(e.ctrlKey===true||e.metaKey===true))&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        var random_code = randomString(5);
        //$('.staticParent').on('keydown', '.child', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||(/65|67|86|88/.test(e.keyCode)&&(e.ctrlKey===true||e.metaKey===true))&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            var html = '';
            html += '<div class="combo">';
            html += '<a href="#" class="remove_field">Remove</a>';
            html += '<div class="form-group">';
            html += '<label class="col-md-3 col-xs-12 control-label no-padding-right" for="form-field-1"> Câu hỏi '+ x +'</label>';
            html += '<div class="col-md-9 col-xs-12"><input type="text" id="form-field-0" name="q'+x+'" placeholder="Câu hỏi" class="col-md-10" required /></div>';
            html += '<label class="col-md-3 col-xs-12 control-label no-padding-right" for="form-field-1"> Random Code </label>';
            html += '<div class="col-md-9 col-xs-12" style="padding-top:5px;">';
            html += '<input type="text" id="form-field-0" value="'+ random_code +'" name="code'+ x +'" placeholder="Random Code" class="col-md-3" required />';
            html += '<div class="col-md-3"><div class="staticParent"><label><input id="spinner'+ x +'" class="child" name="point'+x+'" value="1" type="text"/><span class="lbl"></span></label></div></div></div>';
            html += '<label class="col-md-3 col-xs-12 control-label no-padding-right" for="form-field-1"> Đáp án </label>';
            html += '<div class="col-md-9 col-xs-12">';
            html += '<input type="text" id="form-field-1" name="a'+ x +'1" placeholder="Đáp án 1" class="col-md-8" />';
            html += '<div class="checkbox col-md-2"><label><input name="c'+ x +'1" class="ace ace-checkbox-2" type="checkbox" /><span class="lbl"> Đúng</span></label></div>';
            html += '<input type="text" id="form-field-1" name="a'+ x +'2" placeholder="Đáp án 1" class="col-md-8" />';
            html += '<div class="checkbox col-md-2"><label><input name="c'+ x +'2" class="ace ace-checkbox-2" type="checkbox" /><span class="lbl"> Đúng</span></label></div>';
            html += '<input type="text" id="form-field-1" name="a'+ x +'3" placeholder="Đáp án 1" class="col-md-8" />';
            html += '<div class="checkbox col-md-2"><label><input name="c'+ x +'3" class="ace ace-checkbox-2" type="checkbox" /><span class="lbl"> Đúng</span></label></div>';
            html += '<input type="text" id="form-field-1" name="a'+ x +'4" placeholder="Đáp án 1" class="col-md-8" />';
            html += '<div class="checkbox col-md-2"><label><input name="c'+ x +'4" class="ace ace-checkbox-2" type="checkbox" /><span class="lbl"> Đúng</span></label></div>';
            html += '</div>';
            html += '<hr />';
            html += '</div>';
            $(wrapper).append(html); //add input box
             $('.staticParent').on('keydown', '.child', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||(/65|67|86|88/.test(e.keyCode)&&(e.ctrlKey===true||e.metaKey===true))&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div.combo').remove(); x--;
    })
});

</script>


