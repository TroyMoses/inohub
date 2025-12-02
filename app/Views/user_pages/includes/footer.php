<div id="print_footer">
    <div class="foot_print">
        <p style="position:fixed; bottom:0; width:100%; font-size: 11px;color: #555;padding:10px;text-transform: uppercase;border-top: 1px solid #bbb;">
            &copy; Schoolhub SYSTEM | <i>PRINTED AS AT : <?= esc(date('Y-m-d H:i:s')); ?></i>
        </p>
    </div>
</div>

<script type="text/javascript">
    var disable_right_click = "no";
    var use_display_friendly_amount = "yes";
    var user_start_time = "2024-08-22 08:00:00";
    var user_logout_time = "2024-08-22 17:00:00";

    $(document).ready(function(){
        $('img.profile_images').zoomify();
        $('#number_display').click(function(){ 
            $(this).hide();
        });
    });
</script>