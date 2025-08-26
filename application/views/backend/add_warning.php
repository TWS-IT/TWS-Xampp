<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>

<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-plus"></i> New Warning</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Warning'); ?>">Warnings</a></li>
                <li class="breadcrumb-item active">New Warning</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Add Warning</h4>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo base_url('Warning/Add_Warning'); ?>">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="emid">Employee</label>
                            <select name="emid" id="emid" class="form-control select2" required>
                                <option value="">-- Select Employee --</option>
                                <?php foreach ($employee as $emp): ?>
                                    <option value="<?php echo $emp->em_id; ?>" <?php echo (isset($warning) && $warning->employee_id == $emp->em_id) ? 'selected' : ''; ?>>
                                        <?php echo $emp->first_name . ' ' . $emp->last_name . ' (' . $emp->em_code . ')'; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="employee_id">Employee ID</label>
                            <input type="text" name="employee_id" id="employee_id" class="form-control"
                                value="<?php echo isset($warning) ? $warning->employee_id : ''; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="designation">Designation</label>
                            <input type="text" name="designation" id="designation" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="reason_for_warning">Reason for Warning</label>
                            <select name="reason_for_warning" id="reason_for_warning" class="form-control" required>
                                <option value="">-- Select Reason --</option>
                                <option value="Performance" <?php echo (isset($warning) && $warning->reason_for_warning == 'Performance') ? 'selected' : ''; ?>>Performance
                                </option>
                                <option value="Disciplinary" <?php echo (isset($warning) && $warning->reason_for_warning == 'Disciplinary') ? 'selected' : ''; ?>>Disciplinary
                                </option>
                                <option value="SOP Violations / Poor quality of work" <?php echo (isset($warning) && $warning->reason_for_warning == 'SOP Violations / Poor quality of work') ? 'selected' : ''; ?>>SOP Violations / Poor quality of work</option>
                                <option value="Punctuality" <?php echo (isset($warning) && $warning->reason_for_warning == 'Punctuality') ? 'selected' : ''; ?>>Punctuality
                                </option>
                                <option value="Termination" <?php echo (isset($warning) && $warning->reason_for_warning == 'Termination') ? 'selected' : ''; ?>>Termination
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="sub_reasons">Sub Reason</label>
                            <select name="sub_reasons" id="sub_reasons" class="form-control" required>
                                <option value="">-- Select Sub Reason --</option>
                                <?php if (isset($warning)): ?>
                                    <option value="<?php echo $warning->sub_reasons; ?>" selected>
                                        <?php echo $warning->sub_reasons; ?>
                                    </option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="brief_explanation">Brief Explanation</label>
                        <textarea name="brief_explanation" id="brief_explanation" class="form-control" rows="4"
                            placeholder="Enter detailed explanation..."><?php echo isset($warning) ? $warning->brief_explanation : ''; ?></textarea>
                    </div>


                    <div class="form-group col-md-6">
                        <label for="supervisors_comments">Supervisor Comments</label>
                        <textarea name="supervisors_comments" id="supervisors_comments" class="form-control" rows="4"
                            placeholder="Enter detailed explanation..."><?php echo isset($warning) ? $warning->supervisors_comments : ''; ?></textarea>
                    </div>
                    </div>

                    <div class="form-row">
                        <!-- Skip Supervisor -->
                        <div class="form-group col-md-4">
                            <label>Skip Supervisor Approval</label>
                            <input type="text" name="skp_requested_approval" class="form-control"
                                placeholder="Skip Supervisor">
                        </div>

                        <!-- Divisional Head -->
                        <div class="form-group col-md-4">
                            <label>Divisional Head Approval</label>
                            <input type="text" name="dh_requested_approval" class="form-control"
                                placeholder="Divisional Head">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Acknowledgement</label>
                            <input type="text" name="acknowledgement" class="form-control"
                                placeholder="acknowledgement">
                        </div>
                    </div>





                    <input type="hidden" name="id" value="<?php echo isset($warning->id) ? $warning->id : ''; ?>">

                    <div class="form-group row">
                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="<?php echo base_url('Warning'); ?>" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const reasonDropdown = document.getElementById("reason_for_warning");
        const subReasonDropdown = document.getElementById("sub_reasons");

        const subReasons = {
            "Performance": [
                "Failure to meet individual KPI's",
                "Failure to meet team KPI's"
            ],
            "Disciplinary": [
                "Verbal Harassment",
                "Physical Harassment",
                "Sleep during work hours",
                "Consuming food at workstation"
            ],
            "SOP Violations / Poor quality of work": [
                "Non-compliance with the established protocol",
                "Breach of confidential information"
            ],
            "Punctuality": [
                "Late Reporting",
                "Early Exits",
                "Break time violation",
                "Unauthorized Absence",
                "Failure to punch attendance"
            ],
            "Termination": [
                "Sexual Harassment",
                "Alcohol / drugs abuse"
            ]
        };

        reasonDropdown.addEventListener("change", function () {
            const selectedReason = this.value;
            subReasonDropdown.innerHTML = '<option value="">-- Select Sub Reason --</option>';

            if (subReasons[selectedReason]) {
                subReasons[selectedReason].forEach(function (reason) {
                    const option = document.createElement("option");
                    option.value = reason;
                    option.text = reason;
                    subReasonDropdown.appendChild(option);
                });
            }
        });

        // Trigger change if editing
        if (reasonDropdown.value) {
            reasonDropdown.dispatchEvent(new Event("change"));
            <?php if (isset($warning)): ?>
                subReasonDropdown.value = "<?php echo $warning->sub_reasons; ?>";
            <?php endif; ?>
        }
    });
</script>


<!-- employee name with code select script -->
<script>
    $(document).ready(function () {
        // enable select2 search
        $('#emid').select2({
            placeholder: "-- Select Employee --",
            allowClear: true
        });

        // auto load employee code & designation
        $('#emid').on('change', function () {
            const empId = $(this).val();
            if (empId) {
                fetch("<?php echo base_url('Warning/get_employee_details/'); ?>" + empId)
                    .then(res => res.json())
                    .then(data => {
                        $('#employee_id').val(data.em_code || "");
                        $('#designation').val(data.designation || "");
                    });
            } else {
                $('#employee_id').val("");
                $('#designation').val("");
            }
        });

        // trigger once if editing existing warning
        if ($('#emid').val()) {
            $('#emid').trigger('change');
        }
    });
</script>


<!-- Typing script -->

<script>
    $(document).ready(function () {
        // enable select2 search
        $('#emid').select2({
            placeholder: "-- Select Employee --",
            allowClear: true
        });

        // auto load employee code when selecting employee
        $('#emid').on('change', function () {
            const empId = $(this).val();
            if (empId) {
                fetch("<?php echo base_url('Warning/get_employee_code/'); ?>" + empId)
                    .then(res => res.json())
                    .then(data => {
                        $('#employee_id').val(data.em_code || "");
                    });
            } else {
                $('#employee_id').val("");
            }
        });

        // trigger once if editing
        if ($('#emid').val()) {
            $('#emid').trigger('change');
        }
    });
</script>


<!-- text Area  -->

<script>
    $(document).ready(function () {
        $('#brief_explanation').summernote({
            placeholder: 'Enter detailed explanation...',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['fontsize', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['picture', 'link', 'video']],
                // ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        $('#supervisors_comments').summernote({
            placeholder: 'Enter detailed explanation...',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['fontsize', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                // ['insert', ['picture', 'link', 'video']],
                // ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>

<style>
    /* Style the Select2 container */
.select2-container--default .select2-selection--single {
    height: 34px;                   /* match input height */
    border: 1px solid #aaa;
    border-radius: 6px;
    background: linear-gradient(to bottom, #f9f9f9 0%, #e0e0e0 100%);
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    font-size: 13px;
    padding-left: 6px;
    display: flex;
    align-items: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

/* Arrow styling */
.select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 3px;
    right: 8px;
}

/* Hover effect */
.select2-container--default .select2-selection--single:hover {
    background: linear-gradient(to bottom, #ffffff 0%, #dcdcdc 100%);
    box-shadow: 0 3px 6px rgba(0,0,0,0.25);
    transform: translateY(-1px);
}

/* Focus effect */
.select2-container--default.select2-container--open .select2-selection--single {
    border-color: #007bff;
    box-shadow: 0 3px 6px rgba(0,0,0,0.3);
}

/* Dropdown menu */
.select2-dropdown {
    border-radius: 6px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    font-size: 13px;
}

/* Options */
.select2-results__option {
    padding: 5px 10px;
    font-size: 13px;
}

/* Highlighted option */
.select2-results__option--highlighted {
    background-color: #007bff !important;
    color: #fff !important;
}

.form-control,
.select2-container--default .select2-selection--single {
    height: 38px;
    border: 1px solid #aaa;
    border-radius: 6px;
    background: linear-gradient(to bottom, #f9f9f9 0%, #e0e0e0 100%);
    box-shadow: 0 2px 4px rgba(0,0,0,0.15);
    font-size: 14px;
    padding: 6px 10px;
    transition: all 0.2s ease;
}

/* 🔹 Hover & Focus effects */
.form-control:hover,
.select2-container--default .select2-selection--single:hover {
    background: linear-gradient(to bottom, #ffffff 0%, #dcdcdc 100%);
    box-shadow: 0 3px 6px rgba(0,0,0,0.25);
    transform: translateY(-1px);
}

.form-control:focus,
.select2-container--default.select2-container--open .select2-selection--single {
    border-color: #007bff;
    box-shadow: 0 3px 6px rgba(0,0,0,0.3);
    outline: none;
}

/* 🔹 Fix Select2 text alignment */
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px; 
    padding-left: 6px;
}

/* 🔹 Dropdown styling */
.select2-dropdown {
    border-radius: 6px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    font-size: 14px;
}

.select2-results__option {
    padding: 6px 10px;
}

.select2-results__option--highlighted {
    background-color: #007bff !important;
    color: #fff !important;
}

</style>



<?php $this->load->view('backend/footer'); ?>