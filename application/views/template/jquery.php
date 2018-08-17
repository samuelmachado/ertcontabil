<!-- jQuery  -->
<script src="<?php echo site_url() ?>assets/js/jquery.min.js"></script>
<script src="<?php echo site_url() ?>assets/js/jquery.mask.min.js"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js')?>"></script>

<!-- Typehead -->
<script src="<?php print site_url() ?>assets/plugins/handlebars/handlebars.js" type="text/javascript"></script>
<script src="<?php print site_url() ?>assets/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
<script src="<?php print site_url() ?>assets/pages/jquery.typehead.init.js" type="text/javascript"></script>

<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.responsive.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/responsive.bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/styleSweetalert2.js')?>"></script>
<script src="<?php echo base_url('assets/js/styleSweetalert2.js')?>"></script>
<script src="<?php echo base_url('assets/plugins/tooltipster/tooltipster.bundle.min.js')?>"></script>
<script src="<?php echo base_url('assets/pages/jquery.tooltipster.js')?>"></script>

<script type="text/javascript">
$('.datepicker').datepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            orientation: "bottom auto",
            todayBtn: true,
            todayHighlight: true
});
$('.money').mask('#.##0,00', {reverse: true});
$('.moneyUs').mask('###0.00', {reverse: true});
$('.porcent').mask('000', {reverse: true});

$('.date').mask('00/00/0000');
$('.number').mask('###');

</script>