<style>
  .bordered {
    border-collapse: collapse;
    width: 100%;
  }

  .bordered th, 
  .bordered td {
    border: .1px solid #000; /* Black border */
    padding: 2px;
    text-align: center; /* Align content in the center */
  }

  .bordered th {
    background-color: #f2f2f2; /* Light grey background for header */
  }

  .bordered caption {
    margin: 1px 0;
    font-weight: bold;
  }
</style>
<div style="border: .1px solid; padding: 15px; margin: 10px auto; max-width: auto;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 5px;">
        <center>
            <h3>{school_name}</h3>
        </center>
    </div>

    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 10px;">
        <div style="flex: 1; padding: 0px; box-sizing: border-box;">
            <!--start_logo_of_term_report-->
            <img src="<?php echo h_session('school_logo') ? base_url(h_session('school_logo')) :base_url('assets/img/brand/logo.png'); ?>" alt="School Logo" style="max-width: 40%; height: auto; top: -32px;">
            <!--start_logo_of_term_report-->
        </div>
        <div style="flex: 1; padding: 0px; box-sizing: border-box; text-align: center;">
            <div style="margin: 0; padding: 0; line-height: 1.15;"><span style="color: rgb(44, 130, 201);">Address: {school_address}</span></div>
            <div style="margin: 0; padding: 0; line-height: 1.15;"><span style="color: rgb(44, 130, 201);">Tel: {school_phone}</span></div>
            <div style="margin: 0; padding: 0; line-height: 1.15;"><span style="color: rgb(44, 130, 201);">Email: {school_email}</span></div>
            <div style="margin: 0; padding: 0; margin-top:5">{motto}</div>
        </div>
        <div style="flex: 1; padding: 0px; box-sizing: border-box; text-align: right;">
            <!--start_profile_of_term_report-->
            <!-- <img src="https://media.licdn.com/dms/image/v2/D4D03AQGAEvNqc5WNaA/profile-displayphoto-shrink_800_800/profile-displayphoto-shrink_800_800/0/1698398514651?e=1743638400&v=beta&t=buTfEQ-sp7n7-NXkB1o-Tf5_GCeaV_Il8WVdCV0lT4U" alt="Student Image" style="max-width: 40%; height: auto; top: -32px;"> -->
            <!--start_profile_of_term_report-->
        </div>
    </div>

    <!-- Student Information -->
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 0px;">
        <div style="flex: 1; padding: 5px; box-sizing: border-box;"><strong style="white-space: nowrap; font-size:12">Name:</strong> <span style="color: rgb(184, 49, 47); font-size:12">{student_info_name} </span> </div>
        <div style="flex: 1; padding: 5px; box-sizing: border-box;"><strong style="white-space: nowrap; font-size:12">Class:</strong> <span style="color: rgb(184, 49, 47); font-size:12">{student_info_class} </span> </div>
        <div style="flex: 1; padding: 5px; box-sizing: border-box;"><strong style="white-space: nowrap; font-size:12">Gender:</strong> <span style="color: rgb(184, 49, 47); font-size:12">{student_info_gender} </span> </div>
    </div>

    <!--start_begining_of_term_report-->
    <div class="class-report-card">
        <div style="margin-bottom: 10px;">
            <center><h5 style="margin-bottom: 5px;"> <!--start_begining_of_term_header--> BEGINNING OF TERM 1 REPORT <!--start_begining_of_term_header--> </h5></center>
            <div style="display: flex; align-items: center;">
                <strong style="font-size:12">Division:</strong>
                <span style="flex: 1; color: rgb(184, 49, 47); border-bottom: 1px dotted black; margin-left: 5px; font-size:12">{beginning_term_division}</span>
            </div>
        </div>
        <!-- Grades Table -->
        <table style="width:width:100%; table-layout: fixed; border-collapse: collapse;font-size:11" class="bordered">
            <thead>
                <!--beginning_report_card_table_header_1-->
                <tr>
                    <th style="text-align: left;">Test</th>
                    <th>English</th>
                    <th>MATHS</th>
                    <th>SCI</th>
                    <th>SST</th>
                    <th>R.E</th>
                    <th>Total</th>
                </tr>
                <!--beginning_report_card_table_header_1-->
            </thead>
            <tbody>
                <!--beginning_report_card_table_content_1-->
                <tr>
                    <td style="text-align: left;">Marks</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{total}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">AGG</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{total}</td>
                </tr>
                <!--beginning_report_card_table_content_1-->
            </tbody>
        </table>
    </div>
    <!--start_begining_of_term_report-->

    <!--start_middle_of_term_report-->
    <div class="class-report-card">
        <div style="margin-bottom: 10px;">
            <center><h5 style="margin-bottom: 5px;"> <!--start_middle_of_term_header--> MID OF TERM 1 REPORT <!--start_middle_of_term_header--> </h5></center>
            <div style="display: flex; align-items: center;">
                <strong style="font-size:12">Division:</strong>
                <span style="flex: 1; color: rgb(184, 49, 47); border-bottom: 1px dotted black; margin-left: 5px; font-size:12">{mid_term_division}</span>
            </div>
        </div>
        <!-- Grades Table -->
        <table style="width:width:100%; table-layout: fixed; border-collapse: collapse; font-size:11" class="bordered">
            <thead>
                <!--middle_report_card_table_header_1-->
                <tr>
                    <th style="text-align: left;">Test</th>
                    <th>English</th>
                    <th>MATHS</th>
                    <th>SCI</th>
                    <th>SST</th>
                    <th>R.E</th>
                    <th>Total</th>
                </tr>
                <!--middle_report_card_table_header_1-->
            </thead>
            <tbody>
                <!--middle_report_card_table_content_1-->
                <tr>
                    <td style="text-align: left;">Marks</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{total}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">AGG</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{total}</td>
                </tr>
                <!--middle_report_card_table_content_1-->
            </tbody>
        </table>
    </div>
    <!--start_middle_of_term_report-->

    <!--start_end_of_term_report-->
    <div class="class-report-card">
        <div style="margin-bottom: 10px;">
            <center><h5 style="margin-bottom: 5px;"> <!--end_end_of_term_header--> END OF TERM 1 REPORT <!--end_end_of_term_header--> </h5></center>
            <div style="display: flex; align-items: center;">
                <strong style="font-size:12">Division:</strong>
                <span style="flex: 1; color: rgb(184, 49, 47); border-bottom: 1px dotted black; margin-left: 5px; font-size:12">{end_term_division}</span>
            </div>
        </div>
        <!-- Grades Table -->
        <table style="width:width:100%; table-layout: fixed; border-collapse: collapse;font-size:11" class="bordered">
            <thead>
                <!--end_term_report_card_table_header_1-->
                <tr>
                    <th style="text-align: left;">SUBJECT</th>
                    <th>SCORE</th>
                    <th>AGG</th>
                    <th>POS</th>
                    <th>TEACHERS' COMMENT</th>
                    <th>INITIALS</th>
                </tr>
                <!--end_term_report_card_table_header_1-->
            </thead>
            <tbody>
                <!--end_term_report_card_table_content_1-->
                <tr>
                    <td style="text-align: left;">ENGLISH</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{agg}</td>
                    <td style="text-align: center;">{pos}</td>
                    <td style="text-align: center;">{comment}</td>
                    <td style="text-align: center;">{initial}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">MATHS</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{agg}</td>
                    <td style="text-align: center;">{pos}</td>
                    <td style="text-align: center;">{comment}</td>
                    <td style="text-align: center;">{initial}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">SCIENCE</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{agg}</td>
                    <td style="text-align: center;">{pos}</td>
                    <td style="text-align: center;">{comment}</td>
                    <td style="text-align: center;">{initial}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">SOCIAL STUDIES</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{agg}</td>
                    <td style="text-align: center;">{pos}</td>
                    <td style="text-align: center;">{comment}</td>
                    <td style="text-align: center;">{initial}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">R.E</td>
                    <td style="text-align: center;">{mrk}</td>
                    <td style="text-align: center;">{agg}</td>
                    <td style="text-align: center;">{pos}</td>
                    <td style="text-align: center;">{comment}</td>
                    <td style="text-align: center;">{initial}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">TOTAL</td>
                    <td style="text-align: center;">{total_mrk}</td>
                    <td style="text-align: center;">{total_agg}</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                </tr>
                <!--end_term_report_card_table_content_1-->
            </tbody>
        </table>
    </div>
    <!--start_end_of_term_report-->

    <!-- Comments Section -->
    <table style="width: 100%; margin-bottom: 20px; border-spacing: 0; margin-top: 30px; font-size:11">
        <tr>
            <td style="width: 30%; vertical-align: top; border:0px"><strong>Class Teacher's Report Conduct:</strong></td>
            <td style="width: 70%; border:0px; border-bottom: 1px dotted black; padding-bottom: 5px;"><span style="color: rgb(44, 130, 201);">{class_teacher_comment}</span></td>
        </tr>
        <tr>
            <td style="border:0px; vertical-align: top;"><strong>Head Teacher's Comment:</strong></td>
            <td style="border:0px; border-bottom: 1px dotted black; padding-bottom: 5px;"><span style="color: rgb(44, 130, 201);">{head_teacher_comment}</span></td>
        </tr>
        <tr>
            <td style="vertical-align: top; border:0px"><strong>Sign:</strong></td>
            <td style="border:0px; border-bottom: 1px dotted black; padding-bottom: 5px;">{head_teacher_sign}</td>
        </tr>
    </table>

    <!-- Footer -->
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 5px;">
        <div style="flex: 1; padding: 5px; box-sizing: border-box;">
            <p style="font-size:12">Next Term begins on: <strong><span style="border-bottom: 1px dotted black;">{next_term_begins_on}</span></strong></p>
        </div>
        <div style="flex: 1; padding: 5px; box-sizing: border-box;">
            <p style="font-size:12">Ends On: <strong><span style="border-bottom: 1px dotted black;">{next_term_ends_on}</span></strong></p>
        </div>
    </div>
    <div style="text-align: center; margin-top:20px">
        <span style="color: rgb(184, 49, 47);">
            <span style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-style: italic;">This report card is invalid, without school stamp.</span>
        </span>
    </div>
</div>
