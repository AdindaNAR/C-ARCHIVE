    <footer class="main-footer">
        <strong>Copyright <b>C-Archive<b/> &copy; 2022 - Develop by KKNTM Politeknik LP3I Tasikmalaya</a>.</strong>
    </footer>

    <!-- jQuery 3 -->
    <script src="<?php echo base_url('assets/'); ?>vendor/AdminLTE-2.4.13/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo base_url('assets/'); ?>vendor/AdminLTE-2.4.13/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Slimscroll -->
    <script src="<?php echo base_url('assets/'); ?>vendor/AdminLTE-2.4.13/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url('assets/'); ?>vendor/AdminLTE-2.4.13/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url('assets/'); ?>vendor/AdminLTE-2.4.13/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url('assets/'); ?>vendor/AdminLTE-2.4.13/dist/js/demo.js"></script>
    <!-- Sweetalert -->
    <script src="<?php echo base_url('assets/'); ?>vendor/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>js/alert.js"></script>
    <!-- Date Picker -->
    <script src="<?php echo base_url('assets/'); ?>vendor/AdminLTE-2.4.13/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url('assets/'); ?>vendor/AdminLTE-2.4.13/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>vendor/AdminLTE-2.4.13/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <script>
        $(function() {
            $('#example1').DataTable({
                'info': false,
                'lengthMenu': [
                    [20, 50, 100, -1],
                    [20, 50, 100, "All"]
                ]
            })
            $('#example2').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                'lengthMenu': [
                    [20, 50, 100, -1],
                    [20, 50, 100, "All"]
                ]
            })
        })
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#listToko').hide();
            $('#edit').hide();

            $('select').on('change', function(e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;

                if (valueSelected == 2) {
                    $('#listToko').hide();
                } else {
                    $('#listToko').show();
                }
            });
        });
    </script>

    <script type="text/javascript" src="<?php echo base_url() . 'assets/vendor/dropify/dropify.min.js' ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/bootstrap-select.js' ?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.bootstrap-select').selectpicker();
            $('.dropify').dropify({
                messages: {
                    default: 'Drag atau drop untuk memilih gambar',
                    replace: 'Ganti',
                    remove: 'Hapus',
                    error: 'error'
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {


            $(".add-diskon").click(function() {
                var length = $('.one').length;
                var cloned = $(this).closest('.one').clone(true);
                cloned.appendTo("#mainDiv").find('.no').val(length + 1);
                cloned.find(':input:not(".no")').val(" ");
                cloned.find("input[onKeyUp*='showHint']").attr('onKeyUp', 'showHint' + (length + 1) + '(this.value)');
                cloned.find("input[id*='item_name']").attr('id', 'item_name' + (length + 1));
                var parent = $(this).closest('.one');
                calculate(parent);
            });

            $('.delete-diskon').click(function() {
                if ($('.one').length == 1) {
                    alert("This is default row and can't deleted");
                    return false;
                }
                var parent = $(this).closest('.one');
                $(this).parents(".one").remove();
                calculate(parent);
                // reset serial numbers again
                $('.one').each(function(index, item) {
                    $(this).find('.no').val(index + 1);
                    $(this).find("input[onKeyUp*='showHint']").attr('onKeyUp', 'showHint' + (index + 1) + '(this.value)');
                    $(this).find("input[id*='item_name']").attr('id', 'item_name' + (index + 1));
                })
            });


            $(".add_cb").click(function() {
                var length = $('.two').length;
                var cloned = $(this).closest('.two').clone(true);
                cloned.appendTo("#mainDiv_cb").find('.no_cb').val(length + 1);
                cloned.find(':input:not(".no_cb")').val(" ");
                cloned.find("input[onKeyUp*='showHint']").attr('onKeyUp', 'showHint' + (length + 1) + '(this.value)');
                cloned.find("input[id*='item_name2']").attr('id', 'item_name2' + (length + 1));
                var parent_cb = $(this).closest('.two');
                calculate(parent_cb);
            });

            $('.delete_cb').click(function() {
                if ($('.two').length == 1) {
                    alert("This is default row and can't deleted");
                    return false;
                }
                var parent_cb = $(this).closest('.two');
                $(this).parents(".two").remove();
                calculate(parent_cb);
                // reset serial numbers again
                $('.two').each(function(index, item) {
                    $(this).find('.no_cb').val(index + 1);
                    $(this).find("input[onKeyUp*='showHint']").attr('onKeyUp', 'showHint' + (index + 1) + '(this.value)');
                    $(this).find("input[id*='item_name2']").attr('id', 'item_name2' + (index + 1));
                })
            });
        });

        $(document).on('keyup', '.diskon, .cashback, .harga_awal', function() {
            var parent = $(this).closest('.one');
            var parent_cb = $(this).closest('.two');
            calculate(parent_cb);
            calculate(parent);
        })

        function calculate(e) {
            var dsc = +$(e).find('.diskon').val();
            var cb = +$(e).find('.cashback').val();
            var sum_cb = 0;
            var sum_sementara_if_cb = 0;
            var sum_sementara_else_cb = 0;


            var ha = $('.harga_barang_edit').val();
            if (parseInt(ha) > 0) {
                console.log("dsc:" + parseInt(dsc));
                console.log("cb:" + parseInt(cb));

                var sum_sementara = parseInt(ha);

                if (parseInt(dsc) >= 0) {
                    $(e).find('.subtotal').val(1 - dsc / 100);

                    $('.subtotal').each(function(i, e) {
                        sum_sementara *= +$(e).val();
                    });

                    // if(parseInt(cb) >= 0){
                    //     $(e).find('.subtotal_cb').val(parseInt(cb));

                    //     $('.subtotal_cb').each(function(i,e){
                    //         sum_cb += +$(e).val(); 
                    //     });
                    //     sum_sementara = parseInt(sum_sementara)-parseInt(sum_cb);
                    //     // sum_sementara_if_cb = 2;     
                    // }
                    // else{
                    //     sum_sementara = parseInt(sum_sementara);
                    //     // sum_sementara_else_cb = 1;
                    // }
                    // $(e).find('.subtotal_cb').val(parseInt(cb));

                    // $('.subtotal_cb').each(function(i,e){
                    //     sum_cb += +$(e).val(); 
                    // });

                    // sum_sementara = $('.harga_awal').val()-parseInt(sum_cb); 

                    // console.log("cb:"+document.getElementById("cashback").value);
                    // console.log("dsc:"+parseInt(dsc));
                    $('#grand_total').val(sum_sementara);
                } else if (parseInt(cb) >= 0) {

                    $(e).find('.subtotal_cb').val(parseInt(cb));

                    $('.subtotal_cb').each(function(i, e) {
                        sum_cb += +$(e).val();
                    });

                    // sum_sementara = $('.harga_akhir_edit').val()-parseInt(sum_cb); 
                    sum_sementara = $('.harga_barang_edit').val() - parseInt(sum_cb);
                    $('#grand_total_cb').val(sum_sementara);
                }




            }
            // else
            // {   
            //     $('.diskon').val('');
            //     $('.cashback').val('');
            // }

            console.log("sum_sementara_if_cb:" + sum_sementara_if_cb);
            console.log("sum_sementara_else_cb:" + sum_sementara_else_cb);
            console.log("sum_cb:" + sum_cb);
            console.log("sum_sementara:" + sum_sementara);
            console.log("----------------------------------------------------------------------");
            // $('#grand_total').val(parseInt(sum_cb));

        };
    </script>

    <script>
        function sum() {
            var txtFirstNumberValue = document.getElementById('harga_barang').value;
            var txtSecondNumberValue = document.getElementById('persentase1').value;
            var txtThirdNumberValue = document.getElementById('persentase2').value;
            var txtFourthNumberValue = document.getElementById('persentase3').value;
            var txtFifthNumberValue = document.getElementById('cashback').value;
            var diskon1 = parseFloat(txtFirstNumberValue) - (parseFloat(txtSecondNumberValue) / 100 * parseFloat(txtFirstNumberValue));
            var diskon2 = parseFloat(diskon1) - (parseFloat(txtThirdNumberValue) / 100 * parseFloat(diskon1));
            var diskon3 = parseFloat(diskon2) - (parseFloat(txtFourthNumberValue) / 100 * parseFloat(diskon2));
            var cashback = parseFloat(diskon3) - parseFloat(txtFifthNumberValue);
            if (!isNaN(cashback)) {
                document.getElementById('harga_akhir').value = cashback;
            }
        }

        function sum_edit() {
            var txtFirstNumberValue = document.getElementById('harga_barang_edit').value;
            var txtSecondNumberValue = document.getElementById('diskon1_edit').value;
            var txtThirdNumberValue = document.getElementById('diskon2_edit').value;
            var txtFourthNumberValue = document.getElementById('diskon3_edit').value;
            var txtFifthNumberValue = document.getElementById('cashback_edit').value;

            var diskon1 = parseFloat(txtFirstNumberValue) - (parseFloat(txtSecondNumberValue) / 100 * parseFloat(txtFirstNumberValue));
            var diskon2 = parseFloat(diskon1) - (parseFloat(txtThirdNumberValue) / 100 * parseFloat(diskon1));
            var diskon3 = parseFloat(diskon2) - (parseFloat(txtFourthNumberValue) / 100 * parseFloat(diskon2));
            var cashbackin = parseFloat(diskon3) - parseFloat(txtFifthNumberValue);
            if (!isNaN(cashbackin)) {
                document.getElementById('harga_akhir_edit').value = cashbackin;
            }
        }
    </script>

    <script>
        window.onload = function() {
            jam();
            $('#shalat').modal('show');
        }

        function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))

                return false;
            return true;
        }

        function jam() {
            var e = document.getElementById('jam'),
                d = new Date(),
                h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());

            e.innerHTML = '<?= date('Y-m-d'); ?> ' + h + ':' + m + ':' + s;

            setTimeout('jam()', 1000);
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }
        $(document).ready(function() {
            function load_ping(view = '') {
                $.ajax({
                    url: "<?php echo site_url('auth/ping'); ?>",
                    method: "POST",
                    data: {
                        view: view
                    },
                    dataType: "json",
                    success: function(data) {
                        $('.ping').html(data.ping);
                        $('.ic').html(data.ic);
                        $('.ico').html(data.ic);
                    }
                });
            }

            load_ping();
            setInterval(function() {
                load_ping();
            }, 2000);
        });
    </script>

    <script type='text/javascript'>
        //<![CDATA[
        var Nanobar = function() {
            var c, d, e, f, g, h, k = {
                    width: "100%",
                    height: "4px",
                    zIndex: 9999,
                    top: "0"
                },
                l = {
                    width: 0,
                    height: "100%",
                    clear: "both",
                    transition: "height .3s"
                };
            c = function(a, b) {
                for (var c in b) a.style[c] = b[c];
                a.style["float"] = "left"
            };
            f = function() {
                var a = this,
                    b = this.width - this.here;
                0.1 > b && -0.1 < b ? (g.call(this, this.here), this.moving = !1, 100 == this.width && (this.el.style.height = 0, setTimeout(function() {
                    a.cont.el.removeChild(a.el)
                }, 100))) : (g.call(this, this.width - b / 4), setTimeout(function() {
                    a.go()
                }, 16))
            };
            g = function(a) {
                this.width =
                    a;
                this.el.style.width = this.width + "%"
            };
            h = function() {
                var a = new d(this);
                this.bars.unshift(a)
            };
            d = function(a) {
                this.el = document.createElement("div");
                this.el.style.backgroundColor = a.opts.bg;
                this.here = this.width = 0;
                this.moving = !1;
                this.cont = a;
                c(this.el, l);
                a.el.appendChild(this.el)
            };
            d.prototype.go = function(a) {
                a ? (this.here = a, this.moving || (this.moving = !0, f.call(this))) : this.moving && f.call(this)
            };
            e = function(a) {
                a = this.opts = a || {};
                var b;
                a.bg = a.bg || "#008000";
                this.bars = [];
                b = this.el = document.createElement("div");
                c(this.el,
                    k);
                a.id && (b.id = a.id);
                b.style.position = a.target ? "relative" : "fixed";
                a.target ? a.target.insertBefore(b, a.target.firstChild) : document.getElementsByTagName("body")[0].appendChild(b);
                h.call(this)
            };
            e.prototype.go = function(a) {
                this.bars[0].go(a);
                100 == a && h.call(this)
            };
            return e
        }();
        var nanobar = new Nanobar();
        nanobar.go(30);
        nanobar.go(60);
        nanobar.go(100);
        //]]>
    </script>
    </body>

    </html>