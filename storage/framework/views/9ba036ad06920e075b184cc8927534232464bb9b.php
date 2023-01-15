<div class="card">
    <div class="card-header">
        <div class="row d-flex justify-content-between">
            <div class="col-md-2 me-2 mt-1">
                <label>Type</label>
                <select class="form-select" name="type" id="type">
                    <?php $__currentLoopData = config('constants.kpi_types'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php echo e($key == $type? 'selected' : ''); ?> value="<?php echo e($key); ?>"><?php echo e($val); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="col-md-2 mt-1">
                <label>Year</label>
                <input type="text" name="year" value="<?php echo e($year); ?>" class="form-control" id="datepicker">
            </div>

            <div class="col-md-2 mt-1">
                <label>Group</label>
                <select class="form-select" name="type" id="group_id">
                    <option <?php echo e(-1 == $group_id? 'selected' : ''); ?> value="-1">All</option>
                    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php echo e($item->id == $group_id? 'selected' : ''); ?> value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive table-card">
            <table class="editable-table table table-hover table-striped align-middle table-nowrap mb-0" id="editableTable">
                <thead>
                <tr>
                    <th>Group</th>
                    <th>Criteria</th>
                    <th>Unit</th>
                    <th>Jan</th>
                    <th>Feb</th>
                    <th>Mar</th>
                    <th>Apr</th>
                    <th>May</th>
                    <th>Jun</th>
                    <th>Jul</th>
                    <th>Aug</th>
                    <th>Sep</th>
                    <th>Oct</th>
                    <th>Nov</th>
                    <th>Dec</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $kpis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kpi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($kpi->group->name); ?></td>
                        <td><?php echo e($kpi->criteria); ?></td>
                        <td><?php echo e($kpi->unit->name); ?></td>
                        <td><?php echo e($kpi->data($year, $type)->jan ?? ""); ?></td>
                        <td><?php echo e($kpi->data($year, $type)->feb ?? ""); ?></td>
                        <td><?php echo e($kpi->data($year, $type)->mar ?? ""); ?></td>
                        <td><?php echo e($kpi->data($year, $type)->apr ?? ""); ?></td>
                        <td><?php echo e($kpi->data($year, $type)->may ?? ""); ?></td>
                        <td><?php echo e($kpi->data($year, $type)->jun ?? ""); ?></td>
                        <td><?php echo e($kpi->data($year, $type)->jul ?? ""); ?></td>
                        <td><?php echo e($kpi->data($year, $type)->aug ?? ""); ?></td>
                        <td><?php echo e($kpi->data($year, $type)->sep ?? ""); ?></td>
                        <td><?php echo e($kpi->data($year, $type)->oct ?? ""); ?></td>
                        <td><?php echo e($kpi->data($year, $type)->nov ?? ""); ?></td>
                        <td><?php echo e($kpi->data($year, $type)->dec ?? ""); ?></td>
                        <td style="display: none"><?php echo e($kpi->id); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    (function (global, factory) {
        if (typeof define === "function" && define.amd) {
            define('/tables/editable', ['jquery', 'Site'], factory);
        } else if (typeof exports !== "undefined") {
            factory(require('jquery'), require('Site'));
        } else {
            var mod = {
                exports: {}
            };
            factory(global.jQuery, global.Site);
            global.tablesEditable = mod.exports;
        }
    })(this, function (_jquery, _Site) {
        'use strict';

        var _jquery2 = babelHelpers.interopRequireDefault(_jquery);

        // Example editable Table
        // ----------------------
        /* this is an example for validation and change events */
        _jquery2.default.fn.numericInputExample = function () {
            'use strict';

            var element = (0, _jquery2.default)(this);

            element.find('td').on('change', function (evt) {
                var cell = (0, _jquery2.default)(this),
                    column = cell.index(),
                    total = 0,
                    _row = cell.parent().children();
                if (column === 0 || column === 1 || column === 2) {
                    return false; // changes can be rejected
                }

                // if (column === 1 && total > 5000) {
                //     (0, _jquery2.default)('.alert').show();
                //     return false; // changes can be rejected
                // }

                var data = [];
                for (let i = 3; i < _row.length; i++){
                    data.push($(_row[i]).text());
                }

                update_kpi_data(data);

            }).on('validate', function (evt, value) {
                var cell = (0, _jquery2.default)(this),
                    column = cell.index();
                if (column < 3) {
                    return !!value && value.trim().length > 0;
                }
                else {
                    if (value === "")
                        return true;
                    else
                        return !isNaN(parseFloat(value)) && isFinite(value);
                }
            });
            return this;
        };
        (0, _jquery2.default)('#editableTable').editableTableWidget().numericInputExample().find('td:first').focus();
    });

    function update_kpi_data(data){
        $.ajax({
            url: "<?php echo e(url('kpi/update_kpi_data')); ?>",
            method: "post",
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
                year: $("#datepicker").val(),
                type: $("#type").val(),
                data: data
            }
        }).done(function () {
            setTimeout(function(){
                $("#overlay").fadeOut(200);
            },500);
        });
    }

    function getKpis(type, year, group_id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "<?php echo e(url('kpi/get_kpi_data')); ?>",
                method: 'post',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    group_id: group_id,
                    year: year,
                    type: type,
                },
            }).done(function (data){
                resolve(data);
                setTimeout(function(){
                    $("#overlay").fadeOut(200);
                },500);
            }).fail((err) => reject(err));
        });
    }


    $("#datepicker").datepicker( {
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true,
        orientation: "bottom right"
    }).on('changeDate', function(e){
        update_view();
    });

    $("#type").change(function () {
        update_view();
    });

    $("#group_id").change(function () {
        update_view();
    });

    function update_view(){
        getKpis($("#type").val(), $("#datepicker").val(), $("#group_id").val())
            .then((result) => {
                $('#kpi_data_container').empty();
                $('#kpi_data_container').html(result);
            })
            .catch((err) => {
                console.log(err);
            })
    }
</script>
<?php /**PATH /home/mchdmana/public_html/resources/views/admin/kpi/partial_kpi_data.blade.php ENDPATH**/ ?>