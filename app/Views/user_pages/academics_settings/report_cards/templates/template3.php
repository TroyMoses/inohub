<style>
  .bordered {
    border-collapse: collapse;
    width: 100%;
  }

  .bordered th, 
  .bordered td {
    border: 1px solid #000; /* Black border */
    padding: 8px;
    text-align: center; /* Align content in the center */
  }

  .bordered th {
    background-color: #f2f2f2; /* Light grey background for header */
  }

  .bordered caption {
    margin: 10px 0;
    font-weight: bold;
  }
</style>
<div style="border: 2px solid; padding: 15px; margin: 20px auto; max-width: auto;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 10px;">
        <center>
            <h2>{school_name}</h2>
        </center>
    </div>

    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 10px;">
        <div style="flex: 1; padding: 0px; box-sizing: border-box;">
            <img src="https://schoolhub.inocrate.com/assets/uploads/7/logo/inocrate-logo-removebg-preview_1719054676.png" alt="School Logo" style="max-width: 40%; height: auto; top: -32px;">
        </div>
        <div style="flex: 1; padding: 0px; box-sizing: border-box; text-align: center;">
            <div style="margin: 0; padding: 0; line-height: 1.15;"><span style="color: rgb(44, 130, 201);">Address: {school_address}</span></div>
            <div style="margin: 0; padding: 0; line-height: 1.15;"><span style="color: rgb(44, 130, 201);">Tel: {school_phone}</span></div>
            <div style="margin: 0; padding: 0; line-height: 1.15;"><span style="color: rgb(44, 130, 201);">Email: {school_email}</span></div>
            <div style="margin-top: 10px; padding: 0;"><b>{term}</b></div>
            <div style="margin: 0; padding: 0; margin-top:5">{motto}</div>
        </div>
        <div style="flex: 1; padding: 0px; box-sizing: border-box; text-align: right;">
            <img src="https://media.licdn.com/dms/image/v2/D4D03AQGAEvNqc5WNaA/profile-displayphoto-shrink_800_800/profile-displayphoto-shrink_800_800/0/1698398514651?e=1743638400&v=beta&t=buTfEQ-sp7n7-NXkB1o-Tf5_GCeaV_Il8WVdCV0lT4U" alt="Student Image" style="max-width: 40%; height: auto; top: -32px;">
        </div>
    </div>

    <!-- Student Information -->
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 0px;">
        <div style="flex: 1; padding: 5px; box-sizing: border-box;"><strong>Name:</strong> <span style="color: rgb(184, 49, 47);">{student_info_name} </span> </div>
        <div style="flex: 1; padding: 5px; box-sizing: border-box;"><strong>RegNo:</strong> <span style="color: rgb(184, 49, 47);">{student_info_reg_number} </span> </div>
        <div style="flex: 1; padding: 5px; box-sizing: border-box;"><strong>Gender:</strong> <span style="color: rgb(184, 49, 47);">{student_info_gender} </span> </div>
    </div>
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 10px;">
        <div style="flex: 1; padding: 5px; box-sizing: border-box;"><strong>Class:</strong> <span style="color: rgb(184, 49, 47);">{student_info_class}</span> </div>
        <div style="flex: 1; padding: 5px; box-sizing: border-box;"><strong>Class Position:</strong> <span style="color: rgb(184, 49, 47);"> {student_info_class_position}</span> </div>
    </div>

    <!-- Grades Table -->
    <table style="width:width:100%; table-layout: fixed; border-collapse: collapse;" class="bordered">
        <thead>
            <!--begin_grading_report_card_table_header_1-->
            <tr>
                <th>SUBJECT</th>
                <th>B.O.T</th>
                <th>M.T</th>
                <th>E.O.T</th>
                <th>HW</th>
                <th>TM</th>
                <th>MOT</th>
                <th>AVERAGE</th>
                <th>GRADE</th>
                <th>COMMENT</th>
                <th>INITIAL</th>
            </tr>
            <!--end_grading_report_card_table_header_1-->
        </thead>
        <tbody>
            <!--begin_grading_report_card_table_content_1-->
            <tr>
                <td>English</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{avg}</td>
                <td style="text-align: center;">{grade}</td>
                <td style="text-align: center;">{comment}</td>
                <td style="text-align: center;">{initial}</td>
            </tr>
            <tr>
                <td>Social Studies</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{avg}</td>
                <td style="text-align: center;">{grade}</td>
                <td style="text-align: center;">{comment}</td>
                <td style="text-align: center;">{initial}</td>
            </tr>
            <tr>
                <td>Science</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{avg}</td>
                <td style="text-align: center;">{grade}</td>
                <td style="text-align: center;">{comment}</td>
                <td style="text-align: center;">{initial}</td>
            </tr>
            <tr>
                <td>IRE</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{mrk}</td>
                <td style="text-align: center;">{avg}</td>
                <td style="text-align: center;">{grade}</td>
                <td style="text-align: center;">{comment}</td>
                <td style="text-align: center;">{initial}</td>
            </tr>
            <!--end_grading_report_card_table_content_1-->
        </tbody>
    </table>

    <!-- Summary -->
    <table style="width:width:100%; table-layout: fixed; border-collapse: collapse; margin-bottom: 10px;"  class="bordered">
        <tr>
            <td><b>AVERAGE: {avg}</b></td>
            <td><b>TOTAL:{total}</b></td>
            <td><b>AGGREGATES:{agg}</b></td>
            <td><b>DIVISION:{div}</b></td>
		</tr>
    </table>

    <!-- Grading Table -->
    <br />
    <center style="margin-bottom: 5px;">
        <h4>Grading</h4>
    </center>

    <center>
        <table style="width:width:100%; table-layout: fixed; border-collapse: collapse; margin-top: 10px; margin-bottom: 30px;"  class="bordered">
            <thead>
                <tr>
                    <th><span style="color: rgb(184, 49, 47);">D1</span></th>
                    <th><span style="color: rgb(184, 49, 47);">D2</span></th>
                    <th><span style="color: rgb(184, 49, 47);">C3</span></th>
                    <th><span style="color: rgb(184, 49, 47);">C4</span></th>
                    <th><span style="color: rgb(184, 49, 47);">C5</span></th>
                    <th><span style="color: rgb(184, 49, 47);">C6</span></th>
                    <th><span style="color: rgb(184, 49, 47);">P7</span></th>
                    <th><span style="color: rgb(184, 49, 47);">P8</span></th>
                    <th><span style="color: rgb(184, 49, 47);">F9</span></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center; padding:2px">{min} - {max}</td>
                    <td style="text-align: center; padding:2px">{min} - {max}</td>
                    <td style="text-align: center; padding:2px">{min} - {max}</td>
                    <td style="text-align: center; padding:2px">{min} - {max}</td>
                    <td style="text-align: center; padding:2px">{min} - {max}</td>
                    <td style="text-align: center; padding:2px">{min} - {max}</td>
                    <td style="text-align: center; padding:2px">{min} - {max}</td>
                    <td style="text-align: center; padding:2px">{min} - {max}</td>
                    <td style="text-align: center; padding:2px">{min} - {max}</td>
                </tr>
            </tbody>
        </table>
    </center>

    <!-- Comments Section -->
    <table style="width: 100%; margin-bottom: 30px; border-spacing: 0;">
        <tr>
            <td style="width: 30%; vertical-align: top; border:0px"><strong>Class Teacher's Comment:</strong></td>
            <td style="width: 70%; border:0px; border-bottom: 1px dotted black; padding-bottom: 5px;"><span style="color: rgb(44, 130, 201);">{class_teacher_comment}</span></td>
        </tr>
        <tr>
            <td style="vertical-align: top; border:0px"><strong>Signature:</strong></td>
            <td style="border:0px; border-bottom: 1px dotted black; padding-bottom: 5px;">{class_teacher_sign}</td>
        </tr>
        <tr>
            <td style="vertical-align: top; border:0px"><strong>Conduct Comment:</strong></td>
            <td style="border:0px; border-bottom: 1px dotted black; padding-bottom: 5px;"><span style="color: rgb(44, 130, 201);">{conduct_comment}</span></td>
        </tr>
        <tr>
            <td style="border:0px; vertical-align: top;"><strong>Head Teacher's Comment:</strong></td>
            <td style="border:0px; border-bottom: 1px dotted black; padding-bottom: 5px;"><span style="color: rgb(44, 130, 201);">{head_teacher_comment}</span></td>
        </tr>
        <tr>
            <td style="vertical-align: top; border:0px"><strong>Signature:</strong></td>
            <td style="border:0px; border-bottom: 1px dotted black; padding-bottom: 5px;">{head_teacher_sign}</td>
        </tr>
    </table>

    <!-- Footer -->
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 10px;">
        <div style="flex: 1; padding: 5px; box-sizing: border-box;">
            <p>This Term has ended on: <strong><span style="border-bottom: 1px dotted black;">{report_issued_on}</span></strong></p>
        </div>
        <div style="flex: 1; padding: 5px; box-sizing: border-box;">
            <p>Next Term Begins On: <strong><span style="border-bottom: 1px dotted black;">{next_term_begins_on}</span></strong></p>
        </div>
    </div>
    <div style="text-align: center;">
        <p>Fees Balance: <strong><span style="border-bottom: 1px dotted black;">{fees_balance}/=</span></strong></p>
    </div>
    <div style="text-align: center; margin-top:30px">
        <span style="color: rgb(184, 49, 47);">
            <span style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-style: italic;">This report card is invalid, without school stamp.</span>
        </span>
    </div>
</div>
