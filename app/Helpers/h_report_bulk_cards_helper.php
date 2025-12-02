<?php
// use setasign\Fpdi\Fpdi;
use setasign\Fpdi\Tcpdf\Fpdi;

function generateBOTMTEReportCard($studentsData)
{
    $pdf = new Fpdi();
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetFont('helvetica', '', 12);

    foreach ($studentsData as $key => $data) {

        $pdf->AddPage();
        $pdf->SetAlpha(0.1);
        $pdf->Image($data['school_logo'], 15, 75, 180, 0, 'PNG'); // Adjust dimensions and position as needed
        $pdf->SetAlpha(1);
        
        // Get page dimensions
        $pageWidth = $pdf->GetPageWidth();
        $leftMargin = 5; // Set in SetMargins
        $rightMargin = 5; // Set in SetMargins

        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false);

        $maxWidth = 50;
        $original = strtoupper($data['school_name']);
        $text = $original;

        // Remove characters from the end until it fits
        while ($pdf->GetStringWidth($text) > $maxWidth && strlen($text) > 0) {
            $text = substr($text, 0, -1);
        }

        $pdf->AddFont('LibreBodoni', 'B', 'assets/fonts/LibreBodoni-Bold.php');
        $pdf->SetFont('LibreBodoni', 'B', 30);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, $text, 0, 1, 'C');

        $pdf->SetFont('LibreBodoni', 'B', 25);
        $pdf->Cell(0, 13, $data['school_section'], 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);

        $pdf->Ln(6);

        $pdf->SetFont('Helvetica', '', 12);
        $lineHeight = 8;
        $pdf->Cell(0, $lineHeight, "Tel: {$data['school_phone']} | {$data['school_phone']} ", 0, 1, 'C');
        $pdf->Cell(0, $lineHeight, "{$data['school_address']}", 0, 1, 'C');
        $pdf->Cell(0, $lineHeight, "Email: {$data['school_email']}", 0, 1, 'C');
        $pdf->Ln(3);

        // Add school logo and student info
        if (file_exists($data['school_logo'])) {
            $pdf->Image($data['school_logo'], 26, 30, 35);
        }
        if (file_exists($data['student_profile_image'])) {
            // $pdf->Image($data['student_profile_image'], 150, 30, 35); 
            $pdf->Image($data['student_profile_image'], 150, 30, 0, 30);
        }

        $pdf->Ln(2);

        // Get the page width
        $pageWidth = $pdf->GetPageWidth();
        // Line thickness
        $lineHeight = 1;
        // Calculate the line start and end points
        $lineStartX = $leftMargin; // Start from the left margin
        $lineEndX = $pageWidth - $rightMargin; // End at the right margin
        $currentY = $pdf->GetY(); // Get the current vertical position

        // Draw the line
        $pdf->SetDrawColor(0, 0, 0); // Black color
        $pdf->SetFillColor(0, 0, 0);
        $pdf->Line($lineStartX, $currentY, $lineEndX, $currentY);
        $pdf->Rect($lineStartX, $currentY, $lineEndX - $lineStartX, $lineHeight, 'F');

        $pdf->Ln(6);

        $pdf->SetFont('LibreBodoni', 'B', 25);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, 'REPORT CARD', 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Helvetica', '', 12);

        // Label: Student Name
        // Get the page width and margins
        $pageWidth = $pdf->GetPageWidth();
        $margin = $leftMargin + $rightMargin;
        $totalWidth = $pageWidth - $margin;

        // Define relative widths for each column (reduce label width for closer values)
        $nameLabelWidth = $totalWidth * 0.1; // 10% for "Name" label
        $nameValueWidth = $totalWidth * 0.3; // 30% for "Name" value

        $classLabelWidth = $totalWidth * 0.1; // 10% for "Class" label
        $classValueWidth = $totalWidth * 0.3; // 30% for "Class" value

        $genderLabelWidth = $totalWidth * 0.1; // 10% for "Gender" label
        $genderValueWidth = $totalWidth * 0.3; // 30% for "Gender" value";

        $pdf->Ln(6);

        // Row: Name
        $pdf->SetX(10);
        $pdf->Cell($nameLabelWidth, 10, "Name:", 0, 0, 'L'); // Label
        $pdf->SetX($pdf->GetX() - 6);
        $pdf->SetTextColor(255, 0, 0); // Red for value
        $pdf->Cell($nameValueWidth, 10, $data['student_info_name'], 0, 0, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Row: Class
        $pdf->Cell($classLabelWidth, 10, "Class:", 0, 0, 'L'); // Label
        $pdf->SetX($pdf->GetX() - 6.5);
        $pdf->SetTextColor(255, 0, 0); // Red for value
        $pdf->Cell($classValueWidth, 10, $data['student_info_class'], 0, 0, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Row: Gender
        $pdf->Cell($genderLabelWidth, 10, "Gender:", 0, 0, 'L'); // Label
        $pdf->SetX($pdf->GetX() - 3);
        $pdf->SetTextColor(255, 0, 0); // Red for value
        $pdf->Cell($genderValueWidth, 10, $data['student_info_gender'], 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        $pdf->Ln(6);

        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->SetTextColor(44, 130, 201);

        if (in_array('B.O.T', $data['exams_added'])) {
            $pdf->Cell(0, 10, 'BEGINNING OF '. $data['term_name'] .' REPORT', 0, 1, 'C');
        }

        if (in_array('M.T.E', $data['exams_added'])) {
            $pdf->Cell(0, 10, 'MID OF '. $data['term_name'] .' REPORT', 0, 1, 'C');
        }

        $pdf->SetTextColor(0, 0, 0);
        
        $pdf->Ln(6);

        if ( (isset($data['student_exams']['M.T.E'] ) && $data['student_exams']['M.T.E']['grading_type_key'] =='positioning') || 
            (isset($data['student_exams']['B.O.T'] ) && $data['student_exams']['B.O.T']['grading_type_key'] =='positioning') ) {
            
            // Define proportions for columns
            $position = isset($data['student_exams']['M.T.E'] ) ? $data['student_exams']['M.T.E']['position']: $data['student_exams']['B.O.T']['position'];
            $number_of_students = isset($data['student_exams']['M.T.E'] ) ? $data['student_exams']['M.T.E']['number_of_students']: $data['student_exams']['B.O.T']['number_of_students'];
            $labelWidth = $totalWidth * 0.2; // 20% for each label
            $valueWidth = $totalWidth * 0.3; // 30% for each value
            $spacing = 10; // Space between the two sections

            // Row: Position In Class
            $pdf->SetX(10);
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Cell($labelWidth, 10, "Position In Class:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('Helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth); 

            // Add spacing between the two sections
            $pdf->Cell($spacing, 10, '', 0, 0); // Spacer

            // Row: Out Of
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Cell($totalWidth * 0.1, 10, "Out Of:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('Helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($totalWidth * 0.4, 10, $number_of_students, 0, 1, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth); 
        }
        else {
            $position = isset($data['student_exams']['M.T.E'] ) ? $data['student_exams']['M.T.E']['position']: $data['student_exams']['B.O.T']['position'];
            $labelWidth = $totalWidth * 0.1; // 20% for each label
            $valueWidth = $totalWidth * 0.85; // 80% for each value

            // Row: Position In Class
            $pdf->SetX(10);
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Cell($labelWidth, 10, "Division:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('Helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
            $pdf->Ln(10);
        }

        $pdf->Ln(12);

        // Define the column widths as proportions of the total page width
        $columnWidths = [
            'Subject' => 33,
            'subject_1' => 35,
            'subject_2' => 35,
            'subject_3' => 35, 
            'subject_4' => 35,
            'total' => 20
        ];

        $headerFont = 14;
        $subjects = isset( $data['exam_marks']['M.T.E'] ) && isset( $data['exam_marks']['M.T.E']['subjects'] ) ? $data['exam_marks']['M.T.E']['subjects']: ( isset($data['exam_marks']['B.O.T']['subjects']) ? $data['exam_marks']['B.O.T']['subjects']:[] );
        $examId = isset( $data['exam_marks']['M.T.E'] ) && isset( $data['exam_marks']['M.T.E']['exam_id'] ) ? $data['exam_marks']['M.T.E']['exam_id']: ( isset($data['exam_marks']['B.O.T']['exam_id']) ? $data['exam_marks']['B.O.T']['exam_id']:0 );
        $studentObj = $data['student_obj'];
        if ( count($subjects) > 4 ) {
            $columnWidths = [
                'Subject' => 18,
                'subject_1' => 32,
                'subject_2' => 32,
                'subject_3' => 32,
                'subject_4' => 32,
                'subject_5' => 32,
                'total' => 15
            ];
            // $headerFont = 10;
        }

        // Table Header
        $pdf->SetX(10);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont('Helvetica', '', $headerFont);
        $pdf->Cell($columnWidths['Subject'], 8, 'TEST', 1, 0, 'L', true);

        foreach ($subjects as $key => $subject) {
            $pdf->Cell($columnWidths['subject_'. ($key + 1) ], 8, strtoupper(htmlspecialchars($subject['short_name'])), 1, 0, 'C', true);
        }

        $pdf->Cell($columnWidths['total'], 8, 'Total', 1, 1, 'C', true);

        // Table Content
        $pdf->SetFont('Helvetica', '', 10);
        $subjectdata = [];
        $marks = ['name' => 'MARKS'];
        $aggs = ['name' => 'AGG'];
        foreach ($subjects as $key => $subject) {
            // populate marks
            $mark = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark']: '-';
            $marks['subject_'. ($key + 1)] = $mark > 0 ? $mark: '-';

            // populate agg
            $grade = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg']: '-';
            $aggs['subject_'. ($key + 1)] = $grade > 0? $grade : '-';
        }
        // totals
        $totalMark = isset($studentObj->scores['marks'][$examId]['total'])? $studentObj->scores['marks'][$examId]['total']: '-';
        $marks['total'] = $totalMark > 0 ? $totalMark : '-';

        $totalagg = isset($studentObj->scores['marks'][$examId]['total_agg'])? $studentObj->scores['marks'][$examId]['total_agg']: '-';
        $aggs['total'] = $totalagg > 0 ? $totalagg :'-' ;

        // update  subject data
        $subjectdata[] = $marks;
        $subjectdata[] = $aggs;

        foreach ($subjectdata as $key => $subject) {
            $subjects_count = count($subject) - 2;
            $pdf->SetX(10);
            $pdf->Cell($columnWidths['Subject'], 8, $subject['name'], 1);
            for ($x = 1; $x <= $subjects_count; $x++) {
                $pdf->Cell($columnWidths['subject_'. $x], 8, $subject['subject_'. $x], 1, 0, 'C');
            }

            $pdf->Cell($columnWidths['total'], 8, $subject['total'], 1, 1, 'C');
        }

        // Add summary and grading table
        $pdf->Ln(12);

        // Table Style: Set margins and font
        $pdf->SetFont('Helvetica', '', 11);
        $pdf->SetMargins(10, 10, 10);

        // Define a fixed position for the dotted line start
        $dottedLineStartX = 80; // Adjust this value as needed for alignment

        // Row: Class Teacher's Report Conduct
        $pdf->SetX(10);
        $pdf->SetFont('Helvetica', 'B', 11);
        $pdf->Cell(60, 10, "Class Teacher's Report Conduct:", 0, 0, 'L'); // Label

        // Position for dotted underline
        $currentY = $pdf->GetY() + 7;

        $pdf->SetFont('Helvetica', '', 11);
        $pdf->SetTextColor(44, 130, 201); // Blue for value
        $pdf->SetX($dottedLineStartX); // Move to the fixed starting position
        $pdf->Cell(0, 10, $data['class_teacher_comment'], 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline
        drawDottedLine($pdf, $dottedLineStartX, $currentY, $pdf->GetPageWidth() - $dottedLineStartX - 10);

        $pdf->Ln(6);

        // Row: Head Teacher's Comment
        $pdf->SetFont('Helvetica', 'B', 11);
        $pdf->Cell(60, 10, "Head Teacher's Comment:", 0, 0, 'L'); // Label

        // Position for dotted underline
        $currentY = $pdf->GetY() + 7;

        $pdf->SetFont('Helvetica', '', 11);
        $pdf->SetTextColor(44, 130, 201); // Blue for value
        $pdf->SetX($dottedLineStartX); // Move to the fixed starting position
        $pdf->Cell(0, 10, $data['head_teacher_comment'], 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline
        drawDottedLine($pdf, $dottedLineStartX, $currentY, $pdf->GetPageWidth() - $dottedLineStartX - 10);
        
        $pdf->Ln(6);

        // Row: Sign
        $pdf->SetFont('Helvetica', 'B', 11);
        $pdf->Cell(20, 10, "Head Teacher's  Sign:", 0, 0, 'L'); // Label

        // Position for dotted underline
        $currentY = $pdf->GetY() + 7;

        $pdf->SetFont('Helvetica', '', 11);
        $pdf->SetX($dottedLineStartX); // Move to the fixed starting position
        $pdf->Cell(0, 10, '', 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline
        drawDottedLine($pdf, $dottedLineStartX, $currentY, $pdf->GetPageWidth() - $dottedLineStartX - 10);

        $pdf->Ln(12);

        // Define proportions for columns
        $labelWidth = $totalWidth * 0.2; // 20% for each label
        $valueWidth = $totalWidth * 0.3; // 30% for each value
        $spacing = 10; // Space between the two sections

        // Row: Position In Class
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Cell($labelWidth, 10, "Next Term begins On:", 0, 0, 'L'); // Label

        // Adjust X position slightly for dotted underline
        $currentX = $pdf->GetX() + 6;
        $currentY = $pdf->GetY() + 7; // Position the line under the text

        $pdf->SetFont('Helvetica', '', 12);
        $pdf->SetTextColor(184, 49, 47); // Red for value
        $pdf->Cell($valueWidth, 10, '', 0, 0, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline for the value
        drawDottedLine($pdf, $currentX, $currentY, $valueWidth);

        // Add spacing between the two sections
        $pdf->Cell($spacing, 10, '', 0, 0); // Spacer

        // Row: Out Of
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Cell($totalWidth * 0.1, 10, "Ends On:", 0, 0, 'L'); // Label

        // Adjust X position slightly for dotted underline
        $currentX = $pdf->GetX() + 2;
        $currentY = $pdf->GetY() + 7; // Position the line under the text

        $pdf->SetFont('Helvetica', '', 12);
        $pdf->SetTextColor(184, 49, 47); // Red for value
        $pdf->Cell($totalWidth * 0.4, 10, '', 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline for the value
        drawDottedLine($pdf, $currentX, $currentY, $valueWidth); 

        $pdf->Ln(12);

        $pdf->SetFont('Helvetica', 'BI', 12);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, '"Transformed To Transform"', 0, 1, 'C');
    }

    return $pdf;
}


function generateENDReportCard($studentsData)
{
    $pdf = new Fpdi();
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetFont('helvetica', '', 12);

    foreach ($studentsData as $key => $data) {
        $pdf->AddPage();
        $pdf->SetAlpha(0.1); 
        $pdf->Image($data['school_logo'], 15, 75, 180, 0, 'PNG'); // Adjust dimensions and position as needed
        $pdf->SetAlpha(1);
        
        // Get page dimensions
        $pageWidth = $pdf->GetPageWidth();
        $leftMargin = 5; // Set in SetMargins
        $rightMargin = 5; // Set in SetMargins

        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false);

        $maxWidth = 50;
        $original = strtoupper($data['school_name']);
        $text = $original;

        // Remove characters from the end until it fits
        while ($pdf->GetStringWidth($text) > $maxWidth && strlen($text) > 0) {
            $text = substr($text, 0, -1);
        }
        $pdf->AddFont('LibreBodoni', 'B', 'assets/fonts/LibreBodoni-Bold.php');
        $pdf->SetFont('LibreBodoni', 'B', 30);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, $text, 0, 1, 'C');

        $pdf->SetFont('LibreBodoni', 'B', 25);
        $pdf->Cell(0, 13, $data['school_section'], 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);

        $pdf->Ln(6);

        $pdf->SetFont('Helvetica', '', 12);
        $lineHeight = 8; 
        $pdf->Cell(0, $lineHeight, "Tel: {$data['school_phone']} | {$data['school_phone']} ", 0, 1, 'C');
        $pdf->Cell(0, $lineHeight, "{$data['school_address']}", 0, 1, 'C');
        $pdf->Cell(0, $lineHeight, "Email: {$data['school_email']}", 0, 1, 'C');
        $pdf->Ln(3);

        // Add school logo and student info
        if (file_exists($data['school_logo'])) {
            $pdf->Image($data['school_logo'], 26, 30, 35);
        }
        if (file_exists($data['student_profile_image'])) {
            // $pdf->Image($data['student_profile_image'], 150, 30, 35);
            $pdf->Image($data['student_profile_image'], 150, 30, 0, 30);
        }

        $pdf->Ln(2);

        // Get the page width
        $pageWidth = $pdf->GetPageWidth();
        // Line thickness
        $lineHeight = 1;
        // Calculate the line start and end points
        $lineStartX = $leftMargin; // Start from the left margin
        $lineEndX = $pageWidth - $rightMargin; // End at the right margin
        $currentY = $pdf->GetY(); // Get the current vertical position

        // Draw the line
        $pdf->SetDrawColor(0, 0, 0); // Black color
        $pdf->SetFillColor(0, 0, 0);
        $pdf->Line($lineStartX, $currentY, $lineEndX, $currentY);
        $pdf->Rect($lineStartX, $currentY, $lineEndX - $lineStartX, $lineHeight, 'F');

        $pdf->Ln(6);

        $pdf->SetFont('LibreBodoni', 'B', 25);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, 'REPORT CARD', 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Helvetica', '', 12);

        // Label: Student Name
        // Get the page width and margins
        $pageWidth = $pdf->GetPageWidth();
        $margin = $leftMargin + $rightMargin;
        $totalWidth = $pageWidth - $margin;

        // Define relative widths for each column (reduce label width for closer values)
        $nameLabelWidth = $totalWidth * 0.1; // 10% for "Name" label
        $nameValueWidth = $totalWidth * 0.3; // 30% for "Name" value

        $classLabelWidth = $totalWidth * 0.1; // 10% for "Class" label
        $classValueWidth = $totalWidth * 0.3; // 30% for "Class" value

        $genderLabelWidth = $totalWidth * 0.1; // 10% for "Gender" label
        $genderValueWidth = $totalWidth * 0.3; // 30% for "Gender" value";

        $pdf->Ln(6);

        // Row: Name
        $pdf->SetX(10);
        $pdf->Cell($nameLabelWidth, 10, "Name:", 0, 0, 'L'); // Label
        $pdf->SetX($pdf->GetX() - 6);
        $pdf->SetTextColor(255, 0, 0); // Red for value
        $pdf->Cell($nameValueWidth, 10, $data['student_info_name'], 0, 0, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Row: Class
        $pdf->Cell($classLabelWidth, 10, "Class:", 0, 0, 'L'); // Label
        $pdf->SetX($pdf->GetX() - 6.5);
        $pdf->SetTextColor(255, 0, 0); // Red for value
        $pdf->Cell($classValueWidth, 10, $data['student_info_class'], 0, 0, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Row: Gender
        $pdf->Cell($genderLabelWidth, 10, "Gender:", 0, 0, 'L'); // Label
        $pdf->SetX($pdf->GetX() - 3);
        $pdf->SetTextColor(255, 0, 0); // Red for value
        $pdf->Cell($genderValueWidth, 10, $data['student_info_gender'], 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        $pdf->Ln(6);

        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->SetTextColor(44, 130, 201);

        $pdf->Cell(0, 10, 'END OF '. $data['term_name'] .' REPORT', 0, 1, 'C');

        $pdf->SetTextColor(0, 0, 0);

        $pdf->Ln(6);

        // Define proportions for columns
        $labelWidth = $totalWidth * 0.2; // 20% for each label
        $valueWidth = $totalWidth * 0.3; // 30% for each value
        $spacing = 10; // Space between the two sections

        if ( isset($data['student_exams']['E.O.T'] ) && $data['student_exams']['E.O.T']['grading_type_key'] =='positioning' ) {
            $position = isset($data['student_exams']['E.O.T'] ) ? $data['student_exams']['E.O.T']['position']: '-';
            $number_of_students = isset($data['student_exams']['E.O.T'] ) ? $data['student_exams']['E.O.T']['number_of_students']: '-';

            // Row: Position In Class
            $pdf->SetX(10);
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Cell($labelWidth, 10, "Position In Class:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('Helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth); 

            // Add spacing between the two sections
            $pdf->Cell($spacing, 10, '', 0, 0); // Spacer

            // Row: Out Of
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Cell($totalWidth * 0.1, 10, "Out Of:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('Helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($totalWidth * 0.4, 10, $number_of_students, 0, 1, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
        }else {
            $position = isset($data['student_exams']['E.O.T'] ) ? $data['student_exams']['E.O.T']['position']: '-';
            $labelWidth = $totalWidth * 0.1; // 20% for each label
            $valueWidth = $totalWidth * 0.85; // 80% for each value

            // Row: Position In Class
            $pdf->SetX(10);
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Cell($labelWidth, 10, "Division:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('Helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
            $pdf->Ln(10);
        }

        $pdf->Ln(12);

        // end of term
        // Define cell widths
        $columnWidths = [45, 20, 20, 17, 70, 21];

        // Header
        $pdf->SetX(10);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont('helvetica', '', 14);
        $pdf->Cell($columnWidths[0], 8, 'SUBJECT', 1, 0, 'L', true);
        $pdf->Cell($columnWidths[1], 8, 'SCORE', 1, 0, 'C', true);
        $pdf->Cell($columnWidths[2], 8, 'AGG', 1, 0, 'C', true);
        $pdf->Cell($columnWidths[3], 8, 'POS', 1, 0, 'C', true);
        $pdf->Cell($columnWidths[4], 8, "TEACHERS' COMMENT", 1, 0, 'C', true);
        $pdf->Cell($columnWidths[5], 8, 'INITIALS', 1, 1, 'C', true);

        // Rows
        $subjectdata = [];
        $subjects = isset( $data['exam_marks']['E.O.T'] ) && isset( $data['exam_marks']['E.O.T']['subjects'] ) ? $data['exam_marks']['E.O.T']['subjects']: [];
        $examId = isset( $data['exam_marks']['E.O.T'] ) && isset( $data['exam_marks']['E.O.T']['exam_id'] ) ? $data['exam_marks']['E.O.T']['exam_id']: 0;
        $studentObj = $data['student_obj'];

        foreach ($subjects as $key => $subject) {
            $name = strtoupper(htmlspecialchars($subject['name']));
            $score = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark']: '-';
            $grade = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg']: '-';
            $pos = '';
            $comment = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['remarks'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['remarks']: '-';
            $initials = $subject['initials'];
            $subjectdata[] = [ $name, $score > 0 ? $score: '-' , $grade > 0 ? $grade: '-', $pos, $comment ? $comment: '-', $initials ? $initials: '-' ];
        }

        // totals
        $totalmark = isset($studentObj->scores['marks'][$examId]['total']) ? $studentObj->scores['marks'][$examId]['total']: '-';
        $totalagg = isset($studentObj->scores['marks'][$examId]['total_agg'] ) ? $studentObj->scores['marks'][$examId]['total_agg']: '-';
        $subjectdata[] = ['TOTAL', $totalmark > 0? $totalmark: '-', $totalagg > 0? $totalagg: '-', '', '', ''];


        $pdf->SetFont('helvetica', '', 10);
        foreach ($subjectdata as $row) {
            $pdf->SetX(10);

            $pdf->Cell($columnWidths[0], 8, $row[0], 1, 0, 'L');
            $pdf->Cell($columnWidths[1], 8, $row[1], 1, 0, 'C');
            $pdf->Cell($columnWidths[2], 8, $row[2], 1, 0, 'C');
            $pdf->Cell($columnWidths[3], 8, $row[3], 1, 0, 'C');
            $pdf->Cell($columnWidths[4], 8, $row[4], 1, 0, 'C');
            $pdf->Cell($columnWidths[5], 8, $row[5], 1, 1, 'C');
        }
                
        // Add summary and grading table
        $pdf->Ln(6);

        // Table Style: Set margins and font
        $pdf->SetFont('Helvetica', '', 11);
        $pdf->SetMargins(10, 10, 10);

        // Define a fixed position for the dotted line start
        $dottedLineStartX = 80; // Adjust this value as needed for alignment

        // Row: Class Teacher's Report Conduct
        $pdf->SetX(10);
        $pdf->SetFont('Helvetica', 'B', 11);
        $pdf->Cell(60, 10, "Class Teacher's Report Conduct:", 0, 0, 'L'); // Label

        // Position for dotted underline
        $currentY = $pdf->GetY() + 7;

        $pdf->SetFont('Helvetica', '', 11);
        $pdf->SetTextColor(44, 130, 201); // Blue for value
        $pdf->SetX($dottedLineStartX); // Move to the fixed starting position
        $pdf->Cell(0, 10, $data['class_teacher_comment'], 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline
        drawDottedLine($pdf, $dottedLineStartX, $currentY, $pdf->GetPageWidth() - $dottedLineStartX - 10);

        $pdf->Ln(6);

        // Row: Head Teacher's Comment
        $pdf->SetFont('Helvetica', 'B', 11);
        $pdf->Cell(60, 10, "Head Teacher's Comment:", 0, 0, 'L'); // Label

        // Position for dotted underline
        $currentY = $pdf->GetY() + 7;

        $pdf->SetFont('Helvetica', '', 11);
        $pdf->SetTextColor(44, 130, 201); // Blue for value
        $pdf->SetX($dottedLineStartX); // Move to the fixed starting position
        $pdf->Cell(0, 10, $data['head_teacher_comment'], 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline
        drawDottedLine($pdf, $dottedLineStartX, $currentY, $pdf->GetPageWidth() - $dottedLineStartX - 10);
        
        $pdf->Ln(6);

        // Row: Sign
        $pdf->SetFont('Helvetica', 'B', 11);
        $pdf->Cell(20, 10, "Head Teacher's  Sign:", 0, 0, 'L'); // Label

        // Position for dotted underline
        $currentY = $pdf->GetY() + 7;

        $pdf->SetFont('Helvetica', '', 11);
        $pdf->SetX($dottedLineStartX); // Move to the fixed starting position
        $pdf->Cell(0, 10, '', 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline
        drawDottedLine($pdf, $dottedLineStartX, $currentY, $pdf->GetPageWidth() - $dottedLineStartX - 10);

        $pdf->Ln(6);

        // Define proportions for columns
        $labelWidth = $totalWidth * 0.2; // 20% for each label
        $valueWidth = $totalWidth * 0.3; // 30% for each value
        $spacing = 10; // Space between the two sections

        // Row: Position In Class
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Cell($labelWidth, 10, "Next Term begins On:", 0, 0, 'L'); // Label

        // Adjust X position slightly for dotted underline
        $currentX = $pdf->GetX() + 6;
        $currentY = $pdf->GetY() + 7; // Position the line under the text

        $pdf->SetFont('Helvetica', '', 12);
        $pdf->SetTextColor(184, 49, 47); // Red for value
        $pdf->Cell($valueWidth, 10, '', 0, 0, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline for the value
        drawDottedLine($pdf, $currentX, $currentY, $valueWidth);

        // Add spacing between the two sections
        $pdf->Cell($spacing, 10, '', 0, 0); // Spacer

        // Row: Out Of
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Cell($totalWidth * 0.1, 10, "Ends On:", 0, 0, 'L'); // Label

        // Adjust X position slightly for dotted underline
        $currentX = $pdf->GetX() + 2;
        $currentY = $pdf->GetY() + 7; // Position the line under the text

        $pdf->SetFont('Helvetica', '', 12);
        $pdf->SetTextColor(184, 49, 47); // Red for value
        $pdf->Cell($totalWidth * 0.4, 10, '', 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline for the value
        drawDottedLine($pdf, $currentX, $currentY, $valueWidth); 

        $pdf->Ln(12);

        $pdf->SetFont('Helvetica', 'BI', 12);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, '"Transformed To Transform"', 0, 1, 'C');
    }

    return $pdf;
}


function generateBOTAndMTEReportCard($studentsData)
{
    $pdf = new Fpdi();
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetFont('helvetica', '', 12);

    foreach ($studentsData as $key => $data) {
        $pdf->AddPage();

        $pdf->SetAlpha(0.1); 
        $pdf->Image($data['school_logo'], 15, 75, 180, 0, 'PNG'); // Adjust dimensions and position as needed
        $pdf->SetAlpha(1); 

        // Get page dimensions
        $pageWidth = $pdf->GetPageWidth();
        $leftMargin = 5; // Set in SetMargins
        $rightMargin = 5; // Set in SetMargins

        // $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false);

        // Add school header Address: {$data['school_address']} |  Email: {$data['school_email']}
        $maxWidth = 50;
        $original = strtoupper($data['school_name']);
        $text = $original;

        // Remove characters from the end until it fits
        while ($pdf->GetStringWidth($text) > $maxWidth && strlen($text) > 0) {
            $text = substr($text, 0, -1);
        }
        $pdf->AddFont('LibreBodoni', 'B', 'assets/fonts/LibreBodoni-Bold.php');
        $pdf->SetFont('LibreBodoni', 'B', 30);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, $text, 0, 1, 'C');

        $pdf->SetFont('LibreBodoni', 'B', 25);
        $pdf->Cell(0, 13, $data['school_section'], 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);

        $pdf->Ln(6);

        $pdf->SetFont('helvetica', '', 10);
        $lineHeight = 6;
        $pdf->Cell(0, $lineHeight, "Tel: {$data['school_phone']} | {$data['school_phone']} ", 0, 1, 'C');
        $pdf->Cell(0, $lineHeight, "{$data['school_address']}", 0, 1, 'C');
        $pdf->Cell(0, $lineHeight, "Email: {$data['school_email']}", 0, 1, 'C');
        $pdf->Ln(2);

        // Add school logo and student info
        if (file_exists($data['school_logo'])) {
            $pdf->Image($data['school_logo'], 26, 30, 35);
        }
        if (file_exists($data['student_profile_image'])) {
            // $pdf->Image($data['student_profile_image'], 150, 30, 35);
            $pdf->Image($data['student_profile_image'], 150, 30, 0, 30);
        }

        $pdf->Ln(2);

        // Get the page width
        $pageWidth = $pdf->GetPageWidth();
        // Line thickness
        $lineHeight = 1;
        // Calculate the line start and end points
        $lineStartX = $leftMargin; // Start from the left margin
        $lineEndX = $pageWidth - $rightMargin; // End at the right margin
        $currentY = $pdf->GetY(); // Get the current vertical position

        // Draw the line
        $pdf->SetDrawColor(0, 0, 0); // Black color
        $pdf->SetFillColor(0, 0, 0);
        $pdf->Line($lineStartX, $currentY, $lineEndX, $currentY);
        $pdf->Rect($lineStartX, $currentY, $lineEndX - $lineStartX, $lineHeight, 'F');

        $pdf->Ln(6);

        $pdf->SetFont('LibreBodoni', 'B', 25);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, 'REPORT CARD', 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', '', 10);

        // Label: Student Name
        // Get the page width and margins
        $pageWidth = $pdf->GetPageWidth();
        $margin = $leftMargin + $rightMargin;
        $totalWidth = $pageWidth - $margin;

        // Define relative widths for each column (reduce label width for closer values)
        $nameLabelWidth = $totalWidth * 0.1; // 10% for "Name" label
        $nameValueWidth = $totalWidth * 0.3; // 30% for "Name" value

        $classLabelWidth = $totalWidth * 0.1; // 10% for "Class" label
        $classValueWidth = $totalWidth * 0.3; // 30% for "Class" value

        $genderLabelWidth = $totalWidth * 0.1; // 10% for "Gender" label
        $genderValueWidth = $totalWidth * 0.3; // 30% for "Gender" value";

        $pdf->Ln(4);

        // Row: Name
        $pdf->Cell($nameLabelWidth, 10, "Name:", 0, 0, 'L'); // Label
        $pdf->SetX($pdf->GetX() - 6);
        $pdf->SetTextColor(255, 0, 0); // Red for value
        $pdf->Cell($nameValueWidth, 10, $data['student_info_name'], 0, 0, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Row: Class
        $pdf->Cell($classLabelWidth, 10, "Class:", 0, 0, 'L'); // Label
        $pdf->SetX($pdf->GetX() - 6.5);
        $pdf->SetTextColor(255, 0, 0); // Red for value
        $pdf->Cell($classValueWidth, 10, $data['student_info_class'], 0, 0, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Row: Gender
        $pdf->Cell($genderLabelWidth, 10, "Gender:", 0, 0, 'L'); // Label
        $pdf->SetX($pdf->GetX() - 3);
        $pdf->SetTextColor(255, 0, 0); // Red for value
        $pdf->Cell($genderValueWidth, 10, $data['student_info_gender'], 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        $pdf->Ln(6);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, 'BEGINNING OF '. $data['term_name'] .' REPORT', 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(2);

        if ( isset($data['student_exams']['B.O.T'] ) && $data['student_exams']['B.O.T']['grading_type_key'] =='positioning' ) {
            $position = isset($data['student_exams']['B.O.T'] ) ? $data['student_exams']['B.O.T']['position']: '-';
            $number_of_students = isset($data['student_exams']['B.O.T'] ) ? $data['student_exams']['B.O.T']['number_of_students']: '-';

            // Define proportions for columns
            $labelWidth = $totalWidth * 0.2; // 20% for each label
            $valueWidth = $totalWidth * 0.3; // 30% for each value
            $spacing = 10; // Space between the two sections

            // Row: Position In Class
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell($labelWidth, 10, "Position In Class:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth); 

            // Add spacing between the two sections
            $pdf->Cell($spacing, 10, '', 0, 0); // Spacer

            // Row: Out Of
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell($totalWidth * 0.1, 10, "Out Of:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($totalWidth * 0.4, 10, $number_of_students, 0, 1, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
        } else {
            $position = isset($data['student_exams']['B.O.T'] ) ? $data['student_exams']['B.O.T']['position']: '-';
            $labelWidth = $totalWidth * 0.1; // 20% for each label
            $valueWidth = $totalWidth * 0.85; // 80% for each value

            // Row: Position In Class
            $pdf->SetX(10);
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Cell($labelWidth, 10, "Division:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('Helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
            $pdf->Ln(10);
        }

        $pdf->Ln(6);

        // Define the column widths as proportions of the total page width
        $columnWidths = [
            'Subject' => 33,
            'subject_1' => 35,
            'subject_2' => 35,
            'subject_3' => 35, 
            'subject_4' => 35,
            'total' => 20
        ];

        $headerFont = 14;
        $subjects = isset( $data['exam_marks']['B.O.T'] ) && isset( $data['exam_marks']['B.O.T']['subjects'] ) ? $data['exam_marks']['B.O.T']['subjects']:[];
        $examId = isset( $data['exam_marks']['B.O.T'] ) && isset( $data['exam_marks']['B.O.T']['exam_id'] ) ? $data['exam_marks']['B.O.T']['exam_id']: 0;
        $studentObj = $data['student_obj'];
        if ( count($subjects) > 4 ) {
            $columnWidths = [
                'Subject' => 18,
                'subject_1' => 32,
                'subject_2' => 32,
                'subject_3' => 32,
                'subject_4' => 32,
                'subject_5' => 32,
                'total' => 15
            ];
            // $headerFont = 10;
        }

        // Table Header
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont('Helvetica', '', $headerFont);
        $pdf->Cell($columnWidths['Subject'], 8, 'TEST', 1, 0, 'L', true);

        foreach ($subjects as $key => $subject) {
            $pdf->Cell($columnWidths['subject_'. ($key + 1) ], 8, strtoupper(htmlspecialchars($subject['short_name'])), 1, 0, 'C', true);
        }

        $pdf->Cell($columnWidths['total'], 8, 'Total', 1, 1, 'C', true);

        // Table Content
        $pdf->SetFont('helvetica', '', 10);
        $subjectdata = [];

        $marks = ['name' => 'MARKS'];
        $aggs = ['name' => 'AGG'];
        foreach ($subjects as $key => $subject) {
            // populate marks
            $mark = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark']: '-';
            $marks['subject_'. ($key + 1)] = $mark > 0 ? $mark: '-';

            // populate agg
            $grade = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg']: '-';
            $aggs['subject_'. ($key + 1)] = $grade > 0? $grade : '-';
        }
        // totals
        $totalMark = isset($studentObj->scores['marks'][$examId]['total'])? $studentObj->scores['marks'][$examId]['total']: '-';
        $marks['total'] = $totalMark > 0 ? $totalMark : '-';

        $totalagg = isset($studentObj->scores['marks'][$examId]['total_agg'])? $studentObj->scores['marks'][$examId]['total_agg']: '-';
        $aggs['total'] = $totalagg > 0 ? $totalagg :'-' ;

        // update  subject data
        $subjectdata[] = $marks;
        $subjectdata[] = $aggs;

        foreach ($subjectdata as $key => $subject) {
            $subjects_count = count($subject) - 2;
            $pdf->Cell($columnWidths['Subject'], 8, $subject['name'], 1);
            for ($x = 1; $x <= $subjects_count; $x++) {
                $pdf->Cell($columnWidths['subject_'. $x], 8, $subject['subject_'. $x], 1, 0, 'C');
            }

            $pdf->Cell($columnWidths['total'], 8, $subject['total'], 1, 1, 'C');
        }

        // Add summary and grading table
        $pdf->Ln(12);


        // end of term
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, 'MID OF '. $data['term_name'] .' REPORT', 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(2);

        if ( isset($data['student_exams']['M.T.E'] ) && $data['student_exams']['M.T.E']['grading_type_key'] =='positioning' ) {
            $position = isset($data['student_exams']['M.T.E'] ) ? $data['student_exams']['M.T.E']['position']: '-';
            $number_of_students = isset($data['student_exams']['M.T.E'] ) ? $data['student_exams']['M.T.E']['number_of_students']: '-';
            
            // Define proportions for columns
            $labelWidth = $totalWidth * 0.2; // 20% for each label
            $valueWidth = $totalWidth * 0.3; // 30% for each value
            $spacing = 10; // Space between the two sections

            // Row: Position In Class
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell($labelWidth, 10, "Position In Class:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth); 

            // Add spacing between the two sections
            $pdf->Cell($spacing, 10, '', 0, 0); // Spacer

            // Row: Out Of
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell($totalWidth * 0.1, 10, "Out Of:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($totalWidth * 0.4, 10, $number_of_students, 0, 1, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
        }else {
            $position = isset($data['student_exams']['M.T.E'] ) ? $data['student_exams']['M.T.E']['position']: '-';
            $labelWidth = $totalWidth * 0.1; // 20% for each label
            $valueWidth = $totalWidth * 0.85; // 80% for each value

            // Row: Position In Class
            $pdf->SetX(10);
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Cell($labelWidth, 10, "Division:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('Helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
            $pdf->Ln(10);
        }

        $pdf->Ln(6);

        // Mid of term
        // Define the column widths as proportions of the total page width
        $columnWidths = [
            'Subject' => 33,
            'subject_1' => 35,
            'subject_2' => 35,
            'subject_3' => 35, 
            'subject_4' => 35,
            'total' => 20
        ];

        $headerFont = 14;
        $subjects = isset( $data['exam_marks']['M.T.E'] ) && isset( $data['exam_marks']['M.T.E']['subjects'] ) ? $data['exam_marks']['M.T.E']['subjects']: [];
        $examId = isset( $data['exam_marks']['M.T.E'] ) && isset( $data['exam_marks']['M.T.E']['exam_id'] ) ? $data['exam_marks']['M.T.E']['exam_id']: 0;
        $studentObj = $data['student_obj'];
        if ( count($subjects) > 4 ) {
            $columnWidths = [
                'Subject' => 18,
                'subject_1' => 32,
                'subject_2' => 32,
                'subject_3' => 32,
                'subject_4' => 32,
                'subject_5' => 32,
                'total' => 15
            ];
            // $headerFont = 10;
        }

        // Table Header
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont('Helvetica', '', $headerFont);

        $pdf->Cell($columnWidths['Subject'], 8, 'TEST', 1, 0, 'L', true);

        foreach ($subjects as $key => $subject) {
            $pdf->Cell($columnWidths['subject_'. ($key + 1) ], 8, strtoupper(htmlspecialchars($subject['short_name'])), 1, 0, 'C', true);
        }

        $pdf->Cell($columnWidths['total'], 8, 'Total', 1, 1, 'C', true);

        // Table Content
        $pdf->SetFont('helvetica', '', 10);
        $subjectdata = [];
        $marks = ['name' => 'MARKS'];
        $aggs = ['name' => 'AGG'];
        foreach ($subjects as $key => $subject) {
            // populate marks
            $mark = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark']: '-';
            $marks['subject_'. ($key + 1)] = $mark > 0 ? $mark: '-';

            // populate agg
            $grade = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg']: '-';
            $aggs['subject_'. ($key + 1)] = $grade > 0? $grade : '-';
        }
        // totals
        $totalMark = isset($studentObj->scores['marks'][$examId]['total'])? $studentObj->scores['marks'][$examId]['total']: '-';
        $marks['total'] = $totalMark > 0 ? $totalMark : '-';

        $totalagg = isset($studentObj->scores['marks'][$examId]['total_agg'])? $studentObj->scores['marks'][$examId]['total_agg']: '-';
        $aggs['total'] = $totalagg > 0 ? $totalagg :'-' ;

        // update  subject data
        $subjectdata[] = $marks;
        $subjectdata[] = $aggs;

        foreach ($subjectdata as $key => $subject) {
            $subjects_count = count($subject) - 2;
            $pdf->Cell($columnWidths['Subject'], 8, $subject['name'], 1);
            for ($x = 1; $x <= $subjects_count; $x++) {
                $pdf->Cell($columnWidths['subject_'. $x], 8, $subject['subject_'. $x], 1, 0, 'C');
            }

            $pdf->Cell($columnWidths['total'], 8, $subject['total'], 1, 1, 'C');
        }

        $pdf->Ln(8);

        // Table Style: Set margins and font
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetMargins(10, 10, 10);

        // Define a fixed position for the dotted line start
        $dottedLineStartX = 80; // Adjust this value as needed for alignment

        // Row: Class Teacher's Report Conduct
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(60, 10, "Class Teacher's Report Conduct:", 0, 0, 'L'); // Label

        // Position for dotted underline
        $currentY = $pdf->GetY() + 7;

        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetTextColor(44, 130, 201); // Blue for value
        $pdf->SetX($dottedLineStartX); // Move to the fixed starting position
        $pdf->Cell(0, 10, $data['class_teacher_comment'], 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline
        drawDottedLine($pdf, $dottedLineStartX, $currentY, $pdf->GetPageWidth() - $dottedLineStartX - 10);

        $pdf->Ln(2);

        // Row: Head Teacher's Comment
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(60, 10, "Head Teacher's Comment:", 0, 0, 'L'); // Label

        // Position for dotted underline
        $currentY = $pdf->GetY() + 7;

        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetTextColor(44, 130, 201); // Blue for value
        $pdf->SetX($dottedLineStartX); // Move to the fixed starting position
        $pdf->Cell(0, 10, $data['head_teacher_comment'], 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline
        drawDottedLine($pdf, $dottedLineStartX, $currentY, $pdf->GetPageWidth() - $dottedLineStartX - 10);
        
        $pdf->Ln(2);

        // Row: Sign
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(20, 10, "Head Teacher's  Sign:", 0, 0, 'L'); // Label

        // Position for dotted underline
        $currentY = $pdf->GetY() + 7;

        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetX($dottedLineStartX); // Move to the fixed starting position
        $pdf->Cell(0, 10, '', 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline
        drawDottedLine($pdf, $dottedLineStartX, $currentY, $pdf->GetPageWidth() - $dottedLineStartX - 10);

        $pdf->Ln(3);

        // Define proportions for columns
        $labelWidth = $totalWidth * 0.2; // 20% for each label
        $valueWidth = $totalWidth * 0.3; // 30% for each value
        $spacing = 10; // Space between the two sections

        // Row: Position In Class
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell($labelWidth, 10, "Next Term begins On:", 0, 0, 'L'); // Label

        // Adjust X position slightly for dotted underline
        $currentX = $pdf->GetX() + 2;
        $currentY = $pdf->GetY() + 7; // Position the line under the text

        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetTextColor(184, 49, 47); // Red for value
        $pdf->Cell($valueWidth, 10, '', 0, 0, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline for the value
        drawDottedLine($pdf, $currentX, $currentY, $valueWidth);

        // Add spacing between the two sections
        $pdf->Cell($spacing, 10, '', 0, 0); // Spacer

        // Row: Out Of
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell($totalWidth * 0.1, 10, "Ends On:", 0, 0, 'L'); // Label

        // Adjust X position slightly for dotted underline
        $currentX = $pdf->GetX() + 2;
        $currentY = $pdf->GetY() + 7; // Position the line under the text

        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetTextColor(184, 49, 47); // Red for value
        $pdf->Cell($totalWidth * 0.4, 10, '', 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline for the value
        drawDottedLine($pdf, $currentX, $currentY, $valueWidth); 

        $pdf->Ln(8);

        $pdf->SetFont('helvetica', 'BI', 10);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, '"Transformed To Transform"', 0, 1, 'C');
    }

    return $pdf;
}


function generateBOTORMTEEndReportCard($studentsData)
{
    $pdf = new Fpdi();
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetFont('helvetica', '', 12);

    foreach ($studentsData as $key => $data) {
        $pdf->AddPage();
        $pdf->SetAlpha(0.1); 
        $pdf->Image($data['school_logo'], 15, 75, 180, 0, 'PNG'); // Adjust dimensions and position as needed
        $pdf->SetAlpha(1); 

        // Get page dimensions
        $pageWidth = $pdf->GetPageWidth();
        $leftMargin = 5; // Set in SetMargins
        $rightMargin = 5; // Set in SetMargins

        // $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false);

        // Add school header Address: {$data['school_address']} |  Email: {$data['school_email']}
        $maxWidth = 50;
        $original = strtoupper($data['school_name']);
        $text = $original;

        // Remove characters from the end until it fits
        while ($pdf->GetStringWidth($text) > $maxWidth && strlen($text) > 0) {
            $text = substr($text, 0, -1);
        }
        $pdf->AddFont('LibreBodoni', 'B', 'assets/fonts/LibreBodoni-Bold.php');
        $pdf->SetFont('LibreBodoni', 'B', 30);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, $text, 0, 1, 'C');

        $pdf->SetFont('LibreBodoni', 'B', 25);
        $pdf->Cell(0, 13, $data['school_section'], 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);

        $pdf->Ln(6);

        $pdf->SetFont('helvetica', '', 10);
        $lineHeight = 6;
        $pdf->Cell(0, $lineHeight, "Tel: {$data['school_phone']} | {$data['school_phone']} ", 0, 1, 'C');
        $pdf->Cell(0, $lineHeight, "{$data['school_address']}", 0, 1, 'C');
        $pdf->Cell(0, $lineHeight, "Email: {$data['school_email']}", 0, 1, 'C');
        $pdf->Ln(2);

        // Add school logo and student info
        if (file_exists($data['school_logo'])) {
            $pdf->Image($data['school_logo'], 26, 30, 35);
        }
        if (file_exists($data['student_profile_image'])) {
            // $pdf->Image($data['student_profile_image'], 150, 30, 35);
            $pdf->Image($data['student_profile_image'], 150, 30, 0, 30);
        }

        $pdf->Ln(2);

        // Get the page width
        $pageWidth = $pdf->GetPageWidth();
        // Line thickness
        $lineHeight = 1;
        // Calculate the line start and end points
        $lineStartX = $leftMargin; // Start from the left margin
        $lineEndX = $pageWidth - $rightMargin; // End at the right margin
        $currentY = $pdf->GetY(); // Get the current vertical position

        // Draw the line
        $pdf->SetDrawColor(0, 0, 0); // Black color
        $pdf->SetFillColor(0, 0, 0);
        $pdf->Line($lineStartX, $currentY, $lineEndX, $currentY);
        $pdf->Rect($lineStartX, $currentY, $lineEndX - $lineStartX, $lineHeight, 'F');

        $pdf->Ln(2);

        $pdf->SetFont('LibreBodoni', 'B', 25);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, 'REPORT CARD', 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', '', 10);

        // Label: Student Name
        // Get the page width and margins
        $pageWidth = $pdf->GetPageWidth();
        $margin = $leftMargin + $rightMargin;
        $totalWidth = $pageWidth - $margin;

        // Define relative widths for each column (reduce label width for closer values)
        $nameLabelWidth = $totalWidth * 0.1; // 10% for "Name" label
        $nameValueWidth = $totalWidth * 0.3; // 30% for "Name" value

        $classLabelWidth = $totalWidth * 0.1; // 10% for "Class" label
        $classValueWidth = $totalWidth * 0.3; // 30% for "Class" value

        $genderLabelWidth = $totalWidth * 0.1; // 10% for "Gender" label
        $genderValueWidth = $totalWidth * 0.3; // 30% for "Gender" value";

        $pdf->Ln(3);

        // Row: Name
        $pdf->Cell($nameLabelWidth, 10, "Name:", 0, 0, 'L'); // Label
        $pdf->SetX($pdf->GetX() - 6);
        $pdf->SetTextColor(255, 0, 0); // Red for value
        $pdf->Cell($nameValueWidth, 10, $data['student_info_name'], 0, 0, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Row: Class
        $pdf->Cell($classLabelWidth, 10, "Class:", 0, 0, 'L'); // Label
        $pdf->SetX($pdf->GetX() - 6.5);
        $pdf->SetTextColor(255, 0, 0); // Red for value
        $pdf->Cell($classValueWidth, 10, $data['student_info_class'], 0, 0, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Row: Gender
        $pdf->Cell($genderLabelWidth, 10, "Gender:", 0, 0, 'L'); // Label
        $pdf->SetX($pdf->GetX() - 3);
        $pdf->SetTextColor(255, 0, 0); // Red for value
        $pdf->Cell($genderValueWidth, 10, $data['student_info_gender'], 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        $pdf->Ln(3);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetTextColor(44, 130, 201);

        if (in_array('B.O.T', $data['exams_added'])) {
            $pdf->Cell(0, 10, 'BEGINNING OF '. $data['term_name'] .' REPORT', 0, 1, 'C');
        }

        if (in_array('M.T.E', $data['exams_added'])) {
            $pdf->Cell(0, 10, 'MID OF '. $data['term_name'] .' REPORT', 0, 1, 'C');
        }

        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(2);

        if ( (isset($data['student_exams']['M.T.E'] ) && $data['student_exams']['M.T.E']['grading_type_key'] =='positioning') || 
            (isset($data['student_exams']['B.O.T'] ) && $data['student_exams']['B.O.T']['grading_type_key'] =='positioning') ) {
            
            $position = isset($data['student_exams']['M.T.E'] ) ? $data['student_exams']['M.T.E']['position']: $data['student_exams']['B.O.T']['position'];
            $number_of_students = isset($data['student_exams']['M.T.E'] ) ? $data['student_exams']['M.T.E']['number_of_students']: $data['student_exams']['B.O.T']['number_of_students'];
            
            // Define proportions for columns
            $labelWidth = $totalWidth * 0.2; // 20% for each label
            $valueWidth = $totalWidth * 0.3; // 30% for each value
            $spacing = 10; // Space between the two sections

            // Row: Position In Class
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell($labelWidth, 10, "Position In Class:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth); 

            // Add spacing between the two sections
            $pdf->Cell($spacing, 10, '', 0, 0); // Spacer

            // Row: Out Of
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell($totalWidth * 0.1, 10, "Out Of:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($totalWidth * 0.4, 10, $number_of_students, 0, 1, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
        }else {
            $position = isset($data['student_exams']['M.T.E'] ) ? $data['student_exams']['M.T.E']['position']: $data['student_exams']['B.O.T']['position'];
            $labelWidth = $totalWidth * 0.1; // 20% for each label
            $valueWidth = $totalWidth * 0.85; // 80% for each value

            // Row: Position In Class
            $pdf->SetX(10);
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Cell($labelWidth, 10, "Division:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('Helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
            $pdf->Ln(10);
        }

        $pdf->Ln(3);


        // Define the column widths as proportions of the total page width
        $columnWidths = [
            'Subject' => 33,
            'subject_1' => 35,
            'subject_2' => 35,
            'subject_3' => 35, 
            'subject_4' => 35,
            'total' => 20
        ];

        $headerFont = 14;
        $subjects = isset( $data['exam_marks']['M.T.E'] ) && isset( $data['exam_marks']['M.T.E']['subjects'] ) ? $data['exam_marks']['M.T.E']['subjects']: ( isset($data['exam_marks']['B.O.T']['subjects']) ? $data['exam_marks']['B.O.T']['subjects']:[] );
        $examId = isset( $data['exam_marks']['M.T.E'] ) && isset( $data['exam_marks']['M.T.E']['exam_id'] ) ? $data['exam_marks']['M.T.E']['exam_id']: ( isset($data['exam_marks']['B.O.T']['exam_id']) ? $data['exam_marks']['B.O.T']['exam_id']:0 );
        $studentObj = $data['student_obj'];
        if ( count($subjects) > 4 ) {
            $columnWidths = [
                'Subject' => 18,
                'subject_1' => 32,
                'subject_2' => 32,
                'subject_3' => 32,
                'subject_4' => 32,
                'subject_5' => 32,
                'total' => 15
            ];
            // $headerFont = 10;
        }

        // Table Header
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont('Helvetica', '', $headerFont);
        $pdf->Cell($columnWidths['Subject'], 8, 'TEST', 1, 0, 'L', true);

        foreach ($subjects as $key => $subject) {
            $pdf->Cell($columnWidths['subject_'. ($key + 1) ], 8, strtoupper(htmlspecialchars($subject['short_name'])), 1, 0, 'C', true);
        }

        $pdf->Cell($columnWidths['total'], 8, 'Total', 1, 1, 'C', true);

        // Table Content
        $pdf->SetFont('helvetica', '', 10);
        $subjectdata = [];
        $marks = ['name' => 'MARKS'];
        $aggs = ['name' => 'AGG'];
        foreach ($subjects as $key => $subject) {
            // populate marks
            $mark = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark']: '-';
            $marks['subject_'. ($key + 1)] = $mark > 0 ? $mark: '-';

            // populate agg
            $grade = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg']: '-';
            $aggs['subject_'. ($key + 1)] = $grade > 0? $grade : '-';
        }
        // totals
        $totalMark = isset($studentObj->scores['marks'][$examId]['total'])? $studentObj->scores['marks'][$examId]['total']: '-';
        $marks['total'] = $totalMark > 0 ? $totalMark : '-';

        $totalagg = isset($studentObj->scores['marks'][$examId]['total_agg'])? $studentObj->scores['marks'][$examId]['total_agg']: '-';
        $aggs['total'] = $totalagg > 0 ? $totalagg :'-' ;

        // update  subject data
        $subjectdata[] = $marks;
        $subjectdata[] = $aggs;

        foreach ($subjectdata as $key => $subject) {
            $subjects_count = count($subject) - 2;
            $pdf->Cell($columnWidths['Subject'], 8, $subject['name'], 1);
            for ($x = 1; $x <= $subjects_count; $x++) {
                $pdf->Cell($columnWidths['subject_'. $x], 8, $subject['subject_'. $x], 1, 0, 'C');
            }

            $pdf->Cell($columnWidths['total'], 8, $subject['total'], 1, 1, 'C');
        }
                
        // Add summary and grading table
        $pdf->Ln(6);


        // end of term
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, 'END OF '. $data['term_name'] .' REPORT', 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(2);

        if ( isset($data['student_exams']['E.O.T'] ) && $data['student_exams']['E.O.T']['grading_type_key'] =='positioning' ) {
            $position = isset($data['student_exams']['E.O.T'] ) ? $data['student_exams']['E.O.T']['position']: '-';
            $number_of_students = isset($data['student_exams']['E.O.T'] ) ? $data['student_exams']['E.O.T']['number_of_students']: '-';

            // Define proportions for columns
            $labelWidth = $totalWidth * 0.2; // 20% for each label
            $valueWidth = $totalWidth * 0.3; // 30% for each value
            $spacing = 10; // Space between the two sections

            // Row: Position In Class
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell($labelWidth, 10, "Position In Class:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth); 

            // Add spacing between the two sections
            $pdf->Cell($spacing, 10, '', 0, 0); // Spacer

            // Row: Out Of
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell($totalWidth * 0.1, 10, "Out Of:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($totalWidth * 0.4, 10, $number_of_students, 0, 1, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
        }else {
            $position = isset($data['student_exams']['E.O.T'] ) ? $data['student_exams']['E.O.T']['position']: '-';
            $labelWidth = $totalWidth * 0.1; // 20% for each label
            $valueWidth = $totalWidth * 0.85; // 80% for each value

            // Row: Position In Class
            $pdf->SetX(10);
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Cell($labelWidth, 10, "Division:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('Helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
            $pdf->Ln(10);
        }

        $pdf->Ln(3);

        // Define cell widths
        $columnWidths = [45, 20, 20, 17, 70, 21];

        // Header
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell($columnWidths[0], 8, 'SUBJECT', 1, 0, 'L', true);
        $pdf->Cell($columnWidths[1], 8, 'SCORE', 1, 0, 'C', true);
        $pdf->Cell($columnWidths[2], 8, 'AGG', 1, 0, 'C', true);
        $pdf->Cell($columnWidths[3], 8, 'POS', 1, 0, 'C', true);
        $pdf->Cell($columnWidths[4], 8, "TEACHERS' COMMENT", 1, 0, 'C', true);
        $pdf->Cell($columnWidths[5], 8, 'INITIALS', 1, 1, 'C', true);

        // Rows
        $subjectdata = [];
        $subjects = isset( $data['exam_marks']['E.O.T'] ) && isset( $data['exam_marks']['E.O.T']['subjects'] ) ? $data['exam_marks']['E.O.T']['subjects']: [];
        $examId = isset( $data['exam_marks']['E.O.T'] ) && isset( $data['exam_marks']['E.O.T']['exam_id'] ) ? $data['exam_marks']['E.O.T']['exam_id']: 0;
        $studentObj = $data['student_obj'];

        foreach ($subjects as $key => $subject) {
            $name = strtoupper(htmlspecialchars($subject['name']));
            $score = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark']: '-';
            $grade = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg']: '-';
            $pos = '';
            $comment = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['remarks'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['remarks']: '-';
            $initials = $subject['initials'];
            $subjectdata[] = [ $name, $score > 0 ? $score: '-' , $grade > 0 ? $grade: '-', $pos, $comment ? $comment: '-', $initials ? $initials: '-' ];
        }
        // totals
        $totalmark = isset($studentObj->scores['marks'][$examId]['total']) ? $studentObj->scores['marks'][$examId]['total']: '-';
        $totalagg = isset($studentObj->scores['marks'][$examId]['total_agg'] ) ? $studentObj->scores['marks'][$examId]['total_agg']: '-';
        $subjectdata[] = ['TOTAL', $totalmark > 0? $totalmark: '-', $totalagg > 0? $totalagg: '-', '', '', ''];

        foreach ($subjectdata as $row) {
            $pdf->Cell($columnWidths[0], 8, $row[0], 1, 0, 'L');
            $pdf->Cell($columnWidths[1], 8, $row[1], 1, 0, 'C');
            $pdf->Cell($columnWidths[2], 8, $row[2], 1, 0, 'C');
            $pdf->Cell($columnWidths[3], 8, $row[3], 1, 0, 'C');
            $pdf->Cell($columnWidths[4], 8, $row[4], 1, 0, 'C');
            $pdf->Cell($columnWidths[5], 8, $row[5], 1, 1, 'C');
        }

        $pdf->Ln(3);

        // Table Style: Set margins and font
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetMargins(10, 10, 10);

        // Define a fixed position for the dotted line start
        $dottedLineStartX = 80; // Adjust this value as needed for alignment

        // Row: Class Teacher's Report Conduct
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(60, 10, "Class Teacher's Report Conduct:", 0, 0, 'L'); // Label

        // Position for dotted underline
        $currentY = $pdf->GetY() + 7;

        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetTextColor(44, 130, 201); // Blue for value
        $pdf->SetX($dottedLineStartX); // Move to the fixed starting position
        $pdf->Cell(0, 10, $data['class_teacher_comment'], 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline
        drawDottedLine($pdf, $dottedLineStartX, $currentY, $pdf->GetPageWidth() - $dottedLineStartX - 10);

        $pdf->Ln(2);

        // Row: Head Teacher's Comment
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(60, 10, "Head Teacher's Comment:", 0, 0, 'L'); // Label

        // Position for dotted underline
        $currentY = $pdf->GetY() + 7;

        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetTextColor(44, 130, 201); // Blue for value
        $pdf->SetX($dottedLineStartX); // Move to the fixed starting position
        $pdf->Cell(0, 10, $data['head_teacher_comment'], 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline
        drawDottedLine($pdf, $dottedLineStartX, $currentY, $pdf->GetPageWidth() - $dottedLineStartX - 10);
        
        $pdf->Ln(2);

        // Row: Sign
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(20, 10, "Head Teacher's  Sign:", 0, 0, 'L'); // Label

        // Position for dotted underline
        $currentY = $pdf->GetY() + 7;

        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetX($dottedLineStartX); // Move to the fixed starting position
        $pdf->Cell(0, 10, '', 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline
        drawDottedLine($pdf, $dottedLineStartX, $currentY, $pdf->GetPageWidth() - $dottedLineStartX - 10);

        $pdf->Ln(3);

        // Define proportions for columns
        $labelWidth = $totalWidth * 0.2; // 20% for each label
        $valueWidth = $totalWidth * 0.3; // 30% for each value
        $spacing = 10; // Space between the two sections

        // Row: Position In Class
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell($labelWidth, 10, "Next Term begins On:", 0, 0, 'L'); // Label

        // Adjust X position slightly for dotted underline
        $currentX = $pdf->GetX() + 2;
        $currentY = $pdf->GetY() + 7; // Position the line under the text

        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetTextColor(184, 49, 47); // Red for value
        $pdf->Cell($valueWidth, 10, '', 0, 0, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline for the value
        drawDottedLine($pdf, $currentX, $currentY, $valueWidth);

        // Add spacing between the two sections
        $pdf->Cell($spacing, 10, '', 0, 0); // Spacer

        // Row: Out Of
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell($totalWidth * 0.1, 10, "Ends On:", 0, 0, 'L'); // Label

        // Adjust X position slightly for dotted underline
        $currentX = $pdf->GetX() + 2;
        $currentY = $pdf->GetY() + 7; // Position the line under the text

        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetTextColor(184, 49, 47); // Red for value
        $pdf->Cell($totalWidth * 0.4, 10, '', 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline for the value
        drawDottedLine($pdf, $currentX, $currentY, $valueWidth); 

        $pdf->Ln(3);

        $pdf->SetFont('helvetica', 'BI', 10);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, '"Transformed To Transform"', 0, 1, 'C');
    }

    return $pdf;
}

function generateBOTMTEEndReportCard($studentsData)
{
    $pdf = new Fpdi();
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    
    foreach ($studentsData as $key => $data) {
        $pdf->AddPage();
        $pdf->SetAlpha(0.1); 
        $pdf->Image($data['school_logo'], 15, 75, 180, 0, 'PNG'); // Adjust dimensions and position as needed
        $pdf->SetAlpha(1); 

        // Get page dimensions
        $pageWidth = $pdf->GetPageWidth();
        $leftMargin = 5; // Set in SetMargins
        $rightMargin = 5; // Set in SetMargins

        // $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false);

        // Add school header Address: {$data['school_address']} |  Email: {$data['school_email']}
        $maxWidth = 50;
        $original = strtoupper($data['school_name']);
        $text = $original;

        // Remove characters from the end until it fits
        while ($pdf->GetStringWidth($text) > $maxWidth && strlen($text) > 0) {
            $text = substr($text, 0, -1);
        }

        $pdf->AddFont('LibreBodoni', 'B', 'assets/fonts/LibreBodoni-Bold.php');
        $pdf->SetFont('LibreBodoni', 'B', 30);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, $text, 0, 1, 'C');

        $pdf->SetFont('LibreBodoni', 'B', 25);
        $pdf->Cell(0, 10, $data['school_section'], 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);

        $pdf->Ln(6);

        $pdf->SetFont('helvetica', '', 10);
        $lineHeight = 6;
        $pdf->Cell(0, $lineHeight, "Tel: {$data['school_phone']} | {$data['school_phone']} ", 0, 1, 'C');
        $pdf->Cell(0, $lineHeight, "{$data['school_address']}", 0, 1, 'C');
        $pdf->Cell(0, $lineHeight, "Email: {$data['school_email']}", 0, 1, 'C');
        $pdf->Ln(2);

        // Add school logo and student info
        if (file_exists($data['school_logo'])) {
            $pdf->Image($data['school_logo'], 26, 30, 35);
        }
        if (file_exists($data['student_profile_image'])) {
            // $pdf->Image($data['student_profile_image'], 150, 30, 35);
            $pdf->Image($data['student_profile_image'], 150, 30, 0, 30);
        }

        $pdf->Ln(2);

        // Get the page width
        $pageWidth = $pdf->GetPageWidth();
        // Line thickness
        $lineHeight = 1;
        // Calculate the line start and end points
        $lineStartX = $leftMargin; // Start from the left margin
        $lineEndX = $pageWidth - $rightMargin; // End at the right margin
        $currentY = $pdf->GetY(); // Get the current vertical position

        // Draw the line
        $pdf->SetDrawColor(0, 0, 0); // Black color
        $pdf->SetFillColor(0, 0, 0);
        $pdf->Line($lineStartX, $currentY, $lineEndX, $currentY);
        $pdf->Rect($lineStartX, $currentY, $lineEndX - $lineStartX, $lineHeight, 'F');

        $pdf->Ln(2);

        $pdf->SetFont('LibreBodoni', 'B', 25);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, 'REPORT CARD', 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', '', 10);

        // Label: Student Name
        // Get the page width and margins
        $pageWidth = $pdf->GetPageWidth();
        $margin = $leftMargin + $rightMargin;
        $totalWidth = $pageWidth - $margin;

        // Define relative widths for each column (reduce label width for closer values)
        $nameLabelWidth = $totalWidth * 0.1; // 10% for "Name" label
        $nameValueWidth = $totalWidth * 0.3; // 30% for "Name" value

        $classLabelWidth = $totalWidth * 0.1; // 10% for "Class" label
        $classValueWidth = $totalWidth * 0.3; // 30% for "Class" value

        $genderLabelWidth = $totalWidth * 0.1; // 10% for "Gender" label
        $genderValueWidth = $totalWidth * 0.3; // 30% for "Gender" value";

        $pdf->Ln(2);

        // Row: Name
        $pdf->Cell($nameLabelWidth, 10, "Name:", 0, 0, 'L'); // Label
        $pdf->SetX($pdf->GetX() - 6);
        $pdf->SetTextColor(255, 0, 0); // Red for value
        $pdf->Cell($nameValueWidth, 10, $data['student_info_name'], 0, 0, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Row: Class
        $pdf->Cell($classLabelWidth, 10, "Class:", 0, 0, 'L'); // Label
        $pdf->SetX($pdf->GetX() - 6.5);
        $pdf->SetTextColor(255, 0, 0); // Red for value
        $pdf->Cell($classValueWidth, 10, $data['student_info_class'], 0, 0, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Row: Gender
        $pdf->Cell($genderLabelWidth, 10, "Gender:", 0, 0, 'L'); // Label
        $pdf->SetX($pdf->GetX() - 3);
        $pdf->SetTextColor(255, 0, 0); // Red for value
        $pdf->Cell($genderValueWidth, 10, $data['student_info_gender'], 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        $pdf->Ln(2);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, 'BEGINNING OF '. $data['term_name'] .' REPORT', 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(2);

        if ( isset($data['student_exams']['B.O.T'] ) && $data['student_exams']['B.O.T']['grading_type_key'] =='positioning') {
            
            // Define proportions for columns
            $position = isset($data['student_exams']['B.O.T'] ) ? $data['student_exams']['B.O.T']['position']: '-';
            $number_of_students = isset($data['student_exams']['B.O.T'] ) ? $data['student_exams']['B.O.T']['number_of_students']: '-';

            // Define proportions for columns
            $labelWidth = $totalWidth * 0.2; // 20% for each label
            $valueWidth = $totalWidth * 0.3; // 30% for each value
            $spacing = 10; // Space between the two sections

            // Row: Position In Class
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell($labelWidth, 10, "Position In Class:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth); 

            // Add spacing between the two sections
            $pdf->Cell($spacing, 10, '', 0, 0); // Spacer

            // Row: Out Of
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell($totalWidth * 0.1, 10, "Out Of:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($totalWidth * 0.4, 10, $number_of_students, 0, 1, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
        }else {
            $position = isset($data['student_exams']['B.O.T'] ) ? $data['student_exams']['B.O.T']['position']: '-';
            $labelWidth = $totalWidth * 0.1; // 20% for each label
            $valueWidth = $totalWidth * 0.85; // 80% for each value

            // Row: Position In Class
            $pdf->SetX(10);
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Cell($labelWidth, 10, "Division:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('Helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
            $pdf->Ln(10);
        }

        $pdf->Ln(2);

        // Beginning of term
        // Define the column widths as proportions of the total page width
        $columnWidths = [
            'Subject' => 33,
            'subject_1' => 35,
            'subject_2' => 35,
            'subject_3' => 35, 
            'subject_4' => 35,
            'total' => 20
        ];

        $headerFont = 14;
        $subjects = isset( $data['exam_marks']['B.O.T'] ) && isset( $data['exam_marks']['B.O.T']['subjects'] ) ? $data['exam_marks']['B.O.T']['subjects']: [];
        $examId = isset( $data['exam_marks']['B.O.T'] ) && isset( $data['exam_marks']['B.O.T']['exam_id'] ) ? $data['exam_marks']['B.O.T']['exam_id']: 0;
        $studentObj = $data['student_obj'];

        if ( count($subjects) > 4 ) {
            $columnWidths = [
                'Subject' => 18,
                'subject_1' => 32,
                'subject_2' => 32,
                'subject_3' => 32,
                'subject_4' => 32,
                'subject_5' => 32,
                'total' => 15
            ];
            // $headerFont = 10;
        }

        // Table Header
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont('helvetica', '', $headerFont);
        $pdf->Cell($columnWidths['Subject'], 7, 'TEST', 1, 0, 'L', true);

        foreach ($subjects as $key => $subject) {
            $pdf->Cell($columnWidths['subject_'. ($key + 1) ], 7, strtoupper(htmlspecialchars($subject['short_name'])), 1, 0, 'C', true);
        }

        $pdf->Cell($columnWidths['total'], 7, 'Total', 1, 1, 'C', true);

        // Table Content
        $pdf->SetFont('helvetica', '', 10);
        $subjectdata = [];

        $marks = ['name' => 'MARKS'];
        $aggs = ['name' => 'AGG'];
        foreach ($subjects as $key => $subject) {
            // populate marks
            $mark = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark']: '-';
            $marks['subject_'. ($key + 1)] = $mark > 0 ? $mark: '-';

            // populate agg
            $grade = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg']: '-';
            $aggs['subject_'. ($key + 1)] = $grade > 0? $grade : '-';
        }
        // totals
        $totalMark = isset($studentObj->scores['marks'][$examId]['total'])? $studentObj->scores['marks'][$examId]['total']: '-';
        $marks['total'] = $totalMark > 0 ? $totalMark : '-';

        $totalagg = isset($studentObj->scores['marks'][$examId]['total_agg'])? $studentObj->scores['marks'][$examId]['total_agg']: '-';
        $aggs['total'] = $totalagg > 0 ? $totalagg :'-' ;

        // update  subject data
        $subjectdata[] = $marks;
        $subjectdata[] = $aggs;

        foreach ($subjectdata as $key => $subject) {
            $subjects_count = count($subject) - 2;
            $pdf->Cell($columnWidths['Subject'], 7, $subject['name'], 1);
            for ($x = 1; $x <= $subjects_count; $x++) {
                $pdf->Cell($columnWidths['subject_'. $x], 7, $subject['subject_'. $x], 1, 0, 'C');
            }

            $pdf->Cell($columnWidths['total'], 7, $subject['total'], 1, 1, 'C');
        }
                
        // Add summary and grading table
        $pdf->Ln(2);

        // Mid-term

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, 'MID OF '. $data['term_name'] .' REPORT', 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(2);

        if ( isset($data['student_exams']['M.T.E'] ) && $data['student_exams']['M.T.E']['grading_type_key'] =='positioning') {
            
            // Define proportions for columns
            $position = isset($data['student_exams']['M.T.E'] ) ? $data['student_exams']['M.T.E']['position']: '-';
            $number_of_students = isset($data['student_exams']['M.T.E'] ) ? $data['student_exams']['M.T.E']['number_of_students']: '-';

            // Define proportions for columns
            $labelWidth = $totalWidth * 0.2; // 20% for each label
            $valueWidth = $totalWidth * 0.3; // 30% for each value
            $spacing = 10; // Space between the two sections

            // Row: Position In Class
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell($labelWidth, 10, "Position In Class:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth); 

            // Add spacing between the two sections
            $pdf->Cell($spacing, 10, '', 0, 0); // Spacer

            // Row: Out Of
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell($totalWidth * 0.1, 10, "Out Of:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($totalWidth * 0.4, 10, $number_of_students, 0, 1, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
        } else {
            $position = isset($data['student_exams']['M.T.E'] ) ? $data['student_exams']['M.T.E']['position']: '-';
            $labelWidth = $totalWidth * 0.1; // 20% for each label
            $valueWidth = $totalWidth * 0.85; // 80% for each value

            // Row: Position In Class
            $pdf->SetX(10);
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Cell($labelWidth, 10, "Division:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('Helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
            $pdf->Ln(10);
        }

        $pdf->Ln(2);

        // Define the column widths as proportions of the total page width
        $columnWidths = [
            'Subject' => 33,
            'subject_1' => 35,
            'subject_2' => 35,
            'subject_3' => 35, 
            'subject_4' => 35,
            'total' => 20
        ];

        $headerFont = 14;
        $subjects = isset( $data['exam_marks']['M.T.E'] ) && isset( $data['exam_marks']['M.T.E']['subjects'] ) ? $data['exam_marks']['M.T.E']['subjects']: [];
        $examId = isset( $data['exam_marks']['M.T.E'] ) && isset( $data['exam_marks']['M.T.E']['exam_id'] ) ? $data['exam_marks']['M.T.E']['exam_id']: 0;
        $studentObj = $data['student_obj'];
        if ( count($subjects) > 4 ) {
            $columnWidths = [
                'Subject' => 18,
                'subject_1' => 32,
                'subject_2' => 32,
                'subject_3' => 32,
                'subject_4' => 32,
                'subject_5' => 32,
                'total' => 15
            ];
            // $headerFont = 10;
        }

        // Table Header
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont('helvetica', '', $headerFont);
        $pdf->Cell($columnWidths['Subject'], 7, 'TEST', 1, 0, 'L', true);

        foreach ($subjects as $key => $subject) {
            $pdf->Cell($columnWidths['subject_'. ($key + 1) ], 7, strtoupper(htmlspecialchars($subject['short_name'])), 1, 0, 'C', true);
        }

        $pdf->Cell($columnWidths['total'], 7, 'Total', 1, 1, 'C', true);

        // Table Content
        $pdf->SetFont('helvetica', '', 10);
        $subjectdata = [];
        $marks = ['name' => 'MARKS'];
        $aggs = ['name' => 'AGG'];

        foreach ($subjects as $key => $subject) {
            // populate marks
            $mark = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark']: '-';
            $marks['subject_'. ($key + 1)] = $mark > 0 ? $mark: '-';

            // populate agg
            $grade = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg']: '-';
            $aggs['subject_'. ($key + 1)] = $grade > 0? $grade : '-';
        }
        // totals
        $totalMark = isset($studentObj->scores['marks'][$examId]['total'])? $studentObj->scores['marks'][$examId]['total']: '-';
        $marks['total'] = $totalMark > 0 ? $totalMark : '-';

        $totalagg = isset($studentObj->scores['marks'][$examId]['total_agg'])? $studentObj->scores['marks'][$examId]['total_agg']: '-';
        $aggs['total'] = $totalagg > 0 ? $totalagg :'-' ;

        // update  subject data
        $subjectdata[] = $marks;
        $subjectdata[] = $aggs;

        foreach ($subjectdata as $key => $subject) {
            $subjects_count = count($subject) - 2;
            $pdf->Cell($columnWidths['Subject'], 7, $subject['name'], 1);
            for ($x = 1; $x <= $subjects_count; $x++) {
                $pdf->Cell($columnWidths['subject_'. $x], 7, $subject['subject_'. $x], 1, 0, 'C');
            }

            $pdf->Cell($columnWidths['total'], 7, $subject['total'], 1, 1, 'C');
        }
                
        // Add summary and grading table
        $pdf->Ln(2);

        // end of term
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, 'END OF '. $data['term_name'] .' REPORT', 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(2);

        if ( isset($data['student_exams']['E.O.T'] ) && $data['student_exams']['E.O.T']['grading_type_key'] =='positioning' ) {
            $position = isset($data['student_exams']['E.O.T'] ) ? $data['student_exams']['E.O.T']['position']: '-';
            $number_of_students = isset($data['student_exams']['E.O.T'] ) ? $data['student_exams']['E.O.T']['number_of_students']: '-';

            // Define proportions for columns
            $labelWidth = $totalWidth * 0.2; // 20% for each label
            $valueWidth = $totalWidth * 0.3; // 30% for each value
            $spacing = 10; // Space between the two sections

            // Row: Position In Class
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell($labelWidth, 10, "Position In Class:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth); 

            // Add spacing between the two sections
            $pdf->Cell($spacing, 10, '', 0, 0); // Spacer

            // Row: Out Of
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell($totalWidth * 0.1, 10, "Out Of:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($totalWidth * 0.4, 10, $number_of_students, 0, 1, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
        } else {
            $position = isset($data['student_exams']['E.O.T'] ) ? $data['student_exams']['E.O.T']['position']: '-';
            $labelWidth = $totalWidth * 0.1; // 20% for each label
            $valueWidth = $totalWidth * 0.85; // 80% for each value

            // Row: Position In Class
            $pdf->SetX(10);
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Cell($labelWidth, 10, "Division:", 0, 0, 'L'); // Label

            // Adjust X position slightly for dotted underline
            $currentX = $pdf->GetX() + 2; 
            $currentY = $pdf->GetY() + 9; // Position the line under the text

            $pdf->SetFont('Helvetica', 'B', 16);
            $pdf->SetTextColor(184, 49, 47); // Red for value
            $pdf->Cell($valueWidth, 10, $position, 0, 0, 'L'); // Value
            $pdf->SetTextColor(0, 0, 0); // Reset to black

            // Draw dotted underline for the value
            drawDottedLine($pdf, $currentX, $currentY, $valueWidth);
            $pdf->Ln(10);
        }

        $pdf->Ln(2);

        // Define cell widths
        $columnWidths = [45, 20, 20, 17, 70, 21];

        // Header
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont('helvetica', '', 14);
        $pdf->Cell($columnWidths[0], 7, 'SUBJECT', 1, 0, 'L', true);
        $pdf->Cell($columnWidths[1], 7, 'SCORE', 1, 0, 'C', true);
        $pdf->Cell($columnWidths[2], 7, 'AGG', 1, 0, 'C', true);
        $pdf->Cell($columnWidths[3], 7, 'POS', 1, 0, 'C', true);
        $pdf->Cell($columnWidths[4], 7, "TEACHERS' COMMENT", 1, 0, 'C', true);
        $pdf->Cell($columnWidths[5], 7, 'INITIALS', 1, 1, 'C', true);

        // Rows
        $subjectdata = [];
        $subjects = isset( $data['exam_marks']['E.O.T'] ) && isset( $data['exam_marks']['E.O.T']['subjects'] ) ? $data['exam_marks']['E.O.T']['subjects']: [];
        $examId = isset( $data['exam_marks']['E.O.T'] ) && isset( $data['exam_marks']['E.O.T']['exam_id'] ) ? $data['exam_marks']['E.O.T']['exam_id']: 0;
        $studentObj = $data['student_obj'];

        foreach ($subjects as $key => $subject) {
            $name = strtoupper(htmlspecialchars($subject['name']));
            $score = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['final_mark']: '-';
            $grade = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['agg']: '-';
            $pos = '';
            $comment = isset($studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['remarks'])? $studentObj->scores['marks'][$examId]['subjects'][$subject['id']]['remarks']: '-';
            $initials = $subject['initials'];
            $subjectdata[] = [ $name, $score > 0 ? $score: '-' , $grade > 0 ? $grade: '-', $pos, $comment ? $comment: '-', $initials ? $initials: '-' ];
        }
        // totals
        $totalmark = isset($studentObj->scores['marks'][$examId]['total']) ? $studentObj->scores['marks'][$examId]['total']: '-';
        $totalagg = isset($studentObj->scores['marks'][$examId]['total_agg'] ) ? $studentObj->scores['marks'][$examId]['total_agg']: '-';
        $subjectdata[] = ['TOTAL', $totalmark > 0? $totalmark: '-', $totalagg > 0? $totalagg: '-', '', '', ''];

        $pdf->SetFont('helvetica', '', 10);

        foreach ($subjectdata as $row) {
            $pdf->Cell($columnWidths[0], 7, $row[0], 1, 0, 'L');
            $pdf->Cell($columnWidths[1], 7, $row[1], 1, 0, 'C');
            $pdf->Cell($columnWidths[2], 7, $row[2], 1, 0, 'C');
            $pdf->Cell($columnWidths[3], 7, $row[3], 1, 0, 'C');
            $pdf->Cell($columnWidths[4], 7, $row[4], 1, 0, 'C');
            $pdf->Cell($columnWidths[5], 7, $row[5], 1, 1, 'C');
        }

        $pdf->Ln(3);

        // Table Style: Set margins and font
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetMargins(10, 10, 10);

        // Define a fixed position for the dotted line start
        $dottedLineStartX = 80; // Adjust this value as needed for alignment

        // Row: Class Teacher's Report Conduct
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(60, 4, "Class Teacher's Report Conduct:", 0, 0, 'L'); // Label

        // Position for dotted underline
        $currentY = $pdf->GetY() + 4;

        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetTextColor(44, 130, 201); // Blue for value
        $pdf->SetX($dottedLineStartX); // Move to the fixed starting position
        $pdf->Cell(0, 4, $data['class_teacher_comment'], 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline
        drawDottedLine($pdf, $dottedLineStartX, $currentY, $pdf->GetPageWidth() - $dottedLineStartX - 10);

        $pdf->Ln(2);

        // Row: Head Teacher's Comment
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(60, 4, "Head Teacher's Comment:", 0, 0, 'L'); // Label

        // Position for dotted underline
        $currentY = $pdf->GetY() + 4;

        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetTextColor(44, 130, 201); // Blue for value
        $pdf->SetX($dottedLineStartX); // Move to the fixed starting position
        $pdf->Cell(0, 4, $data['head_teacher_comment'], 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline
        drawDottedLine($pdf, $dottedLineStartX, $currentY, $pdf->GetPageWidth() - $dottedLineStartX - 10);
        
        $pdf->Ln(2);

        // Row: Sign
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(20, 4, "Head Teacher's  Sign:", 0, 0, 'L'); // Label

        // Position for dotted underline
        $currentY = $pdf->GetY() + 4;

        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetX($dottedLineStartX); // Move to the fixed starting position
        $pdf->Cell(0, 4, '', 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline
        drawDottedLine($pdf, $dottedLineStartX, $currentY, $pdf->GetPageWidth() - $dottedLineStartX - 10);

        $pdf->Ln(3);

        // Define proportions for columns
        $labelWidth = $totalWidth * 0.2; // 20% for each label
        $valueWidth = $totalWidth * 0.3; // 30% for each value
        $spacing = 10; // Space between the two sections

        // Row: Position In Class
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell($labelWidth, 4, "Next Term begins On:", 0, 0, 'L'); // Label

        // Adjust X position slightly for dotted underline
        $currentX = $pdf->GetX() + 2;
        $currentY = $pdf->GetY() + 4; // Position the line under the text

        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetTextColor(184, 49, 47); // Red for value
        $pdf->Cell($valueWidth, 4, '', 0, 0, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline for the value
        drawDottedLine($pdf, $currentX, $currentY, $valueWidth);

        // Add spacing between the two sections
        $pdf->Cell($spacing, 10, '', 0, 0); // Spacer

        // Row: Out Of
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell($totalWidth * 0.1, 4, "Ends On:", 0, 0, 'L'); // Label

        // Adjust X position slightly for dotted underline
        $currentX = $pdf->GetX() + 2;
        $currentY = $pdf->GetY() + 4; // Position the line under the text

        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetTextColor(184, 49, 47); // Red for value
        $pdf->Cell($totalWidth * 0.4, 4, '', 0, 1, 'L'); // Value
        $pdf->SetTextColor(0, 0, 0); // Reset to black

        // Draw dotted underline for the value
        drawDottedLine($pdf, $currentX, $currentY, $valueWidth); 

        $pdf->Ln(3);

        $pdf->SetFont('helvetica', 'BI', 10);
        $pdf->SetTextColor(44, 130, 201);
        $pdf->Cell(0, 10, '"Transformed To Transform"', 0, 1, 'C');
    }

    return $pdf;
}

function drawDottedLine($pdf, $x, $y, $width, $dotWidth = 1, $gapWidth = 1) {
    $startX = $x;
    while ($startX < $x + $width) {
        $pdf->Line($startX, $y, $startX + $dotWidth, $y); // Draw dot
        $startX += $dotWidth + $gapWidth; // Move to the next dot position
    }
}