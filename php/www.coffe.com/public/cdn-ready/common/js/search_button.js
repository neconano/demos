        $(".btn_cat").on('click',function () {
            var cat = $(this).attr('data-cat');
            $('.'+cat+'-0').removeClass('btn-primary')
            // $('.'+cat).removeClass('btn-primary')
            if(cat == 'cat1'){
                $('.p_cat2').hide();
                var cat_id = $(this).attr('data-id');
                $('#p_cat2'+cat_id).show();
                $('.cat2-all').addClass('btn-primary');
                $('#s_cat1').val($(this).attr('data-val'));
            }

            if(cat == 'cat2'){
                $('#s_cat2').val($(this).attr('data-val'));
            }
            if (cat =='new'){
                $('.cat3').removeClass('btn-primary');
                var s_new=$('#new').val();
                if (s_new){
                    $('#new').val('');
                }else {
                    $('#new').val($(this).attr('data-val'));
                }
            }
            if (cat =='hot'){
                $('.cat3').removeClass('btn-primary');
                var hot=$('#hot').val();
                if (hot){
                    $('#hot').val('');
                }else {
                    $('#hot').val($(this).attr('data-val'));
                }
            }
            if (cat=='cat3'){
                $('.cat3-hot').removeClass('btn-primary');
                $('.cat3-new').removeClass('btn-primary');
                $('#new').val('');
                $('#hot').val('');
            }
            if ($(this).hasClass('btn-primary')){
                $(this).find('input').val('');
                $(this).removeClass('btn-primary');
            }else {
                $(this).find('input').val($(this).data('val'));
                $(this).addClass('btn-primary');
            }

        });
        function set_cat1(id){
            $('.cat1-0').removeClass('btn-primary')
            // $('.cat1').removeClass('btn-primary');
            $('.cat1-'+id).addClass('btn-primary');
            $('#s_cat1').val(id);
            if(id){
                $('#p_cat2'+id).show();
            }
        }
        function set_cat2(id){
            $('.cat2').removeClass('btn-primary');
            $('.cat2-'+id).addClass('btn-primary');
            $('#s_cat2').val(id);
        }

        function set_new(id) {
            $('.cat3').removeClass('btn-primary');
            $('.cat3-new').addClass('btn-primary');
            $('#new').val(id);
        }

        function set_hot(id) {
            $('.cat3').removeClass('btn-primary');
            $('.cat3-hot').addClass('btn-primary');
            $('#hot').val(id);
        }